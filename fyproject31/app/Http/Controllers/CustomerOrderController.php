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

    public function menu(Request $request)
    {
        $query = MenuItem::where('status', 'available');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $menuItems = $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'price' => number_format($item->price, 2),
                'category' => $item->category,
                'image' => $item->image,
            ];
        });

        $categories = MenuItem::where('status', 'available')
            ->distinct()
            ->pluck('category')
            ->toArray();

        return view('customer.menu', [
            'menuItems' => $menuItems,
            'categories' => $categories,
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
            'status' => 'pending',
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
