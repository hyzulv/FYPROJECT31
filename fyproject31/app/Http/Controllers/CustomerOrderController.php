<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
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
                $appliesTo = json_decode($addOn->applies_to, true);
                if ($appliesTo !== null && !in_array($item->category, $appliesTo)) {
                    return false;
                }
                $excludeFor = json_decode($addOn->exclude_for, true);
                if ($excludeFor !== null && in_array($item->name, $excludeFor)) {
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

    public function storeOrder(Request $request)
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

        return response()->json([
            'success' => true,
            'order_id' => $order->order_id,
            'message' => 'Order placed successfully!',
        ]);
    }

    public function orderSuccess($orderId)
    {
        $order = Order::where('order_id', $orderId)->firstOrFail();
        return view('customer.order-success', ['order' => $order]);
    }
}
