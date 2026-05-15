<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\ToyyibPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CustomerOrderController extends Controller
{
    public function index()
    {
        return view('customer.homepage');
    }

    public function welcome()
    {
        return view('customer.welcome');
    }

    public function itemDetail($id)
    {
        $item = MenuItem::where('id', $id)->where('status', 'available')->firstOrFail();

        $addOns = MenuItem::where('category', 'add_on')
            ->where('status', 'available')
            ->get()
            ->filter(function ($addOn) use ($item) {
                if ($addOn->applies_to !== null && !in_array($item->category, $addOn->applies_to)) {
                    return false;
                }
                if ($addOn->exclude_for !== null && in_array($item->name, $addOn->exclude_for)) {
                    return false;
                }
                return true;
            })
            ->groupBy('group_name')
            ->map(function ($group, $groupName) {
                return [
                    'group_name' => $groupName,
                    'selection_type' => $group->first()->selection_type,
                    'items' => $group->map(function ($addOn) {
                        return [
                            'id' => $addOn->id,
                            'name' => $addOn->name,
                            'price' => number_format($addOn->price, 2),
                            'image' => $addOn->image,
                        ];
                    })->values(),
                ];
            })
            ->values();

        $itemData = [
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'price' => number_format($item->price, 2),
            'category' => $item->category,
            'image' => $item->image,
        ];

        return view('customer.item-detail', [
            'item' => $itemData,
            'addOns' => $addOns,
        ]);
    }

    public function menu(Request $request)
    {
        $menuItems = MenuItem::where('status', 'available')
            ->where('category', '!=', 'add_on')
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category')
            ->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'description' => $item->description,
                        'price' => number_format($item->price, 2),
                        'category' => $item->category,
                        'image' => $item->image,
                    ];
                });
            });

        $categoryOrder = ['ala_carte', 'combo_set', 'mix', 'nasi_lemak', 'kicap', 'set_family', 'minuman'];
        $categoryLabels = [
            'ala_carte' => 'Ala Carte',
            'combo_set' => 'Combo Set',
            'mix' => 'Mix',
            'nasi_lemak' => 'Nasi Lemak',
            'kicap' => 'Kicap Edition',
            'set_family' => 'Set Family',
            'minuman' => 'Minuman',
        ];

        $sortedCategories = [];
        foreach ($categoryOrder as $cat) {
            if ($menuItems->has($cat)) {
                $sortedCategories[] = $cat;
            }
        }

        return view('customer.menu', [
            'menuItems' => $menuItems,
            'categories' => $sortedCategories,
            'categoryLabels' => $categoryLabels,
        ]);
    }

    public function cart()
    {
        return view('customer.cart');
    }

    public function checkout()
    {
        return view('customer.checkout');
    }

    public function storeOrder(Request $request, ToyyibPayService $toyyibpay)
    {
        $request->validate([
            'table_number' => 'required|string|max:10',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:menu_items,id',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
        ]);

        $order = Order::create([
            'order_id' => '#ORD-' . strtoupper(Str::random(6)),
            'table_number' => $request->table_number,
            'items' => json_encode($request->items),
            'total' => $request->total,
            'status' => 'preparing',
            'order_time' => now()->format('H:i:s'),
            'payment_status' => 'unpaid',
        ]);

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        try {
            $itemNames = collect($request->items)->pluck('name')->take(3)->implode(', ');
            if (count($request->items) > 3) {
                $itemNames .= '...';
            }

            $bill = $toyyibpay->createBill([
                'bill_name' => 'Mat Rock Order ' . $order->order_id,
                'bill_description' => 'Table ' . $request->table_number . ' - ' . $itemNames,
                'amount' => $request->total,
                'reference_no' => $order->id,
                'customer_name' => 'Customer',
                'return_url' => $this->getToyyibpayUrl(route('payment.redirect', [], false)),
                'callback_url' => $this->getToyyibpayUrl(route('payment.callback', [], false)),
            ]);

            if (isset($bill['BillCode'])) {
                $order->update(['bill_code' => $bill['BillCode']]);
            }
        } catch (\Exception $e) {
            Log::error('ToyyibPay bill creation failed', [
                'order_id' => $order->order_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return response()->json([
            'success' => true,
            'order_id' => $order->order_id,
                'receipt_url' => route('customer.order.receipt', ['order' => $order->id]),
            'message' => 'Order placed successfully!',
        ]);
    }

    public function paymentCallback(Request $request)
    {
        $billCode = $request->input('bill_code');
        $statusId = $request->input('status_id');
        $transactionId = $request->input('transaction_id');
        $refNo = $request->input('order_id');

        Log::info('ToyyibPay callback received', $request->all());

        if (!$billCode) {
            return response('Missing bill_code', 400);
        }

        $order = Order::where('id', $refNo)->orWhere('bill_code', $billCode)->first();

        if (!$order) {
            Log::warning('Order not found for callback', ['bill_code' => $billCode, 'ref_no' => $refNo]);
            return response('Order not found', 404);
        }

        $paymentStatus = match ($statusId) {
            1 => 'paid',
            3 => 'failed',
            default => 'unpaid',
        };

        $updateData = ['payment_status' => $paymentStatus];

        if ($paymentStatus === 'paid') {
            $updateData['paid_at'] = now();
            if ($transactionId) {
                $updateData['transaction_id'] = $transactionId;
            }
        }

        $order->update($updateData);

        return response('OK', 200);
    }

    public function paymentRedirect(Request $request)
    {
        $refNo = $request->input('order_id');
        $statusId = $request->input('status_id');
        $billCode = $request->input('bill_code');
        $transactionId = $request->input('transaction_id');

        if ($refNo) {
            $order = Order::find($refNo);
        } elseif ($billCode) {
            $order = Order::where('bill_code', $billCode)->first();
        } else {
            $order = null;
        }

        if ($order && $statusId) {
            $paymentStatus = match ($statusId) {
                '1' => 'paid',
                '3' => 'failed',
                default => 'unpaid',
            };

            if ($paymentStatus === 'paid' && $order->payment_status !== 'paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                    'transaction_id' => $transactionId,
                ]);
            } elseif ($paymentStatus === 'failed' && $order->payment_status !== 'paid') {
                $order->update(['payment_status' => 'failed']);
            }
        }

        if ($order) {
            return redirect()->route('customer.order.receipt', ['order' => $order->id]);
        }

        return redirect()->route('homepage');
    }

    public function receipt(Order $order, ToyyibPayService $toyyibpay)
    {

        $paymentUrl = null;
        if ($order->bill_code && $order->payment_status === 'unpaid') {
            $paymentUrl = $toyyibpay->getPaymentUrl($order->bill_code);
        }

        return view('customer.receipt', [
            'order' => $order,
            'payment_url' => $paymentUrl,
        ]);
    }

    public function orderSuccess($orderId)
    {
        $order = Order::where('order_id', $orderId)->firstOrFail();
        return view('customer.order-success', ['order' => $order]);
    }

    private function getToyyibpayUrl(string $path): string
    {
        $base = config('services.toyyibpay.redirect_url');
        if ($base) {
            return rtrim($base, '/') . '/' . ltrim($path, '/');
        }
        return url($path);
    }
}
