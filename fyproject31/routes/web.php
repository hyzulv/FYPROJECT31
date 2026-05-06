<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Models\User;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Feedback;

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/homepage', function () {
    return redirect()->route('homepage');
});

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
        $staff = User::where('role', 'staff')->orWhere('role', 'admin')->get()->map(function ($u) {
            return [
                'name' => $u->name,
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
});
