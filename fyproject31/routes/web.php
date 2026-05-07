<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CustomerOrderController;
use App\Models\User;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Feedback;

// Customer Ordering Routes (No Auth Required)
Route::get('/', function () {
    return view('homepage');
})->name('homepage');
Route::get('/homepage', function () {
    return redirect()->route('homepage');
});
Route::get('/welcome', [CustomerOrderController::class, 'welcome'])->name('customer.welcome');
Route::get('/menu', [CustomerOrderController::class, 'menu'])->name('customer.menu');
Route::get('/item/{id}', [CustomerOrderController::class, 'itemDetail'])->name('customer.item.detail');
Route::get('/cart', [CustomerOrderController::class, 'cart'])->name('customer.cart');
Route::get('/checkout', [CustomerOrderController::class, 'checkout'])->name('customer.checkout');
Route::post('/order/store', [CustomerOrderController::class, 'storeOrder'])->name('customer.order.store');
Route::get('/order/success/{orderId}', [CustomerOrderController::class, 'orderSuccess'])->name('customer.order.success');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/demo', function () {
    return view('demo');
})->name('demo');

// Staff Routes
Route::middleware('auth')->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalMenuItems = MenuItem::where('status', 'available')->count();
        $recentOrders = Order::orderBy('created_at', 'desc')->take(5)->get()->map(function ($order) {
            return [
                'id' => $order->order_id,
                'table' => $order->table_number,
                'items' => $order->items,
                'total' => number_format($order->total, 2),
                'status' => $order->status,
            ];
        });

        return view('staff.dashboard', [
            'userName' => auth()->user()->name,
            'userRole' => 'staff',
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
            'totalMenuItems' => $totalMenuItems,
            'recentOrders' => $recentOrders,
        ]);
    })->name('dashboard');

    Route::get('/profile', function () {
        $user = auth()->user();
        return view('staff.profile', [
            'userName' => $user->name,
            'userRole' => 'staff',
            'staff' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'phone' => $user->phone ?? '+60 12-345 6789',
                'join_date' => $user->created_at?->format('F Y') ?? 'January 2024',
            ],
        ]);
    })->name('profile');

    Route::get('/orders', function () {
        $orders = Order::orderBy('created_at', 'desc')->get()->map(function ($order) {
            return [
                'id' => $order->order_id,
                'table' => $order->table_number,
                'items' => $order->items,
                'total' => number_format($order->total, 2),
                'status' => $order->status,
                'time' => $order->order_time ? date('h:i A', strtotime($order->order_time)) : '-',
            ];
        });

        return view('staff.orders', [
            'userName' => auth()->user()->name,
            'userRole' => 'staff',
            'orders' => $orders,
        ]);
    })->name('orders');

    Route::get('/menu', function () {
        $menuItems = MenuItem::where('status', 'available')->get()->map(function ($item) {
            return [
                'name' => $item->name,
                'description' => $item->description,
                'price' => number_format($item->price, 2),
            ];
        });

        $foods = $menuItems->where('category', 'food');
        $drinks = $menuItems->where('category', 'drink');

        return view('staff.menu', [
            'userName' => auth()->user()->name,
            'userRole' => 'staff',
            'menu' => [
                'food' => $foods,
                'drinks' => $drinks,
            ],
        ]);
    })->name('menu');

    Route::get('/feedback', function () {
        $feedbacks = Feedback::orderBy('feedback_date', 'desc')->get()->map(function ($fb) {
            return [
                'customer' => $fb->customer_name,
                'rating' => $fb->rating,
                'message' => $fb->message,
                'date' => $fb->feedback_date->format('F j, Y'),
            ];
        });

        return view('staff.feedback', [
            'userName' => auth()->user()->name,
            'userRole' => 'staff',
            'feedbacks' => $feedbacks,
        ]);
    })->name('feedback');
});

// Admin Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalStaff = User::where('role', 'staff')->count();
        $recentOrders = Order::orderBy('created_at', 'desc')->take(5)->get()->map(function ($order) {
            return [
                'id' => $order->order_id,
                'table' => $order->table_number,
                'items' => $order->items,
                'total' => number_format($order->total, 2),
                'status' => $order->status,
            ];
        });

        return view('admin.dashboard', [
            'userName' => auth()->user()->name,
            'userRole' => 'admin',
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
            'totalStaff' => $totalStaff,
            'recentOrders' => $recentOrders,
        ]);
    })->name('dashboard');

    Route::get('/profile', function () {
        $user = auth()->user();
        return view('admin.profile', [
            'userName' => $user->name,
            'userRole' => 'admin',
            'admin' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'phone' => $user->phone ?? '+60 11-123 4567',
                'join_date' => $user->created_at?->format('F Y') ?? 'January 2023',
            ],
        ]);
    })->name('profile');

    Route::get('/orders', function () {
        $orders = Order::orderBy('created_at', 'desc')->get()->map(function ($order) {
            return [
                'id' => $order->order_id,
                'table' => $order->table_number,
                'items' => $order->items,
                'total' => number_format($order->total, 2),
                'status' => $order->status,
                'time' => $order->order_time ? date('h:i A', strtotime($order->order_time)) : '-',
            ];
        });

        return view('admin.orders', [
            'userName' => auth()->user()->name,
            'userRole' => 'admin',
            'orders' => $orders,
        ]);
    })->name('orders');

    Route::get('/menu', function () {
        $menuItems = MenuItem::where('status', 'available')->get()->map(function ($item) {
            return [
                'name' => $item->name,
                'description' => $item->description,
                'price' => number_format($item->price, 2),
            ];
        });

        $foods = $menuItems->where('category', 'food');
        $drinks = $menuItems->where('category', 'drink');

        return view('admin.menu', [
            'userName' => auth()->user()->name,
            'userRole' => 'admin',
            'menu' => [
                'food' => $foods,
                'drinks' => $drinks,
            ],
        ]);
    })->name('menu');

    Route::get('/feedback', function () {
        $feedbacks = Feedback::orderBy('feedback_date', 'desc')->get()->map(function ($fb) {
            return [
                'customer' => $fb->customer_name,
                'rating' => $fb->rating,
                'message' => $fb->message,
                'date' => $fb->feedback_date->format('F j, Y'),
            ];
        });

        return view('admin.feedback', [
            'userName' => auth()->user()->name,
            'userRole' => 'admin',
            'feedbacks' => $feedbacks,
        ]);
    })->name('feedback');

    Route::get('/staff', function () {
        $staff = User::whereIn('role', ['staff', 'admin'])->get()->map(function ($u) {
            return [
                'id' => $u->id,
                'name' => $u->name,
                'username' => $u->username,
                'email' => $u->email,
                'role' => $u->role,
                'phone' => $u->phone ?? '+60 12-345 6789',
                'status' => ucfirst($u->status),
            ];
        });

        return view('admin.staff', [
            'userName' => auth()->user()->name,
            'userRole' => 'admin',
            'staff' => $staff,
        ]);
    })->name('staff');

    Route::post('/staff/add', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:staff,admin',
            'phone' => 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['phone'],
            'status' => 'active',
        ]);

        return redirect()->route('admin.staff')->with('success', 'Staff added successfully!');
    })->name('staff.add');

    Route::delete('/staff/{id}', function ($id) {
        $user = User::findOrFail($id);
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->withErrors(['error' => 'Cannot delete the last admin.']);
        }
        $user->delete();
        return redirect()->route('admin.staff')->with('success', 'Staff deleted successfully!');
    })->name('staff.delete');
});
