<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CustomerOrderController;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Feedback;

// Customer Ordering Routes (No Auth Required)
Route::get('/', function () {
    $foods = \App\Models\MenuItem::where('status', 'available')
        ->whereIn('category', ['ala_carte', 'combo_set', 'mix', 'nasi_lemak', 'kicap', 'set_family'])
        ->inRandomOrder()
        ->take(4)
        ->get();
    $drinks = \App\Models\MenuItem::where('status', 'available')
        ->where('category', 'minuman')
        ->inRandomOrder()
        ->take(4)
        ->get();
    $feedbacks = \App\Models\Feedback::orderBy('feedback_date', 'desc')->take(10)->get();
    $ownedFeedbackIds = session('owned_feedback_ids', []);
    return view('homepage', ['foods' => $foods, 'drinks' => $drinks, 'feedbacks' => $feedbacks, 'ownedFeedbackIds' => $ownedFeedbackIds]);
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
Route::get('/order/receipt/{order}', [CustomerOrderController::class, 'receipt'])->name('customer.order.receipt');
Route::post('/payment/callback', [CustomerOrderController::class, 'paymentCallback'])->name('payment.callback');
Route::get('/payment/redirect', [CustomerOrderController::class, 'paymentRedirect'])->name('payment.redirect');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string',
    ]);

    try {
        $adminEmail = Admin::value('email');
        \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\ContactMail(
            $validated['name'],
            $validated['email'],
            $validated['message']
        ));
        return back()->with('contact_success', 'Thank you! Your message has been sent successfully.');
    } catch (\Exception $e) {
        return back()->with('contact_error', 'Sorry, failed to send message. Please try again later.');
    }
})->name('contact.send');

Route::post('/feedback', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'rating' => 'required|integer|min:1|max:5',
        'message' => 'required|string',
    ]);

    try {
        $feedback = Feedback::create([
            'customer_name' => $validated['customer_name'],
            'rating' => $validated['rating'],
            'message' => $validated['message'],
            'feedback_date' => now(),
        ]);
        session()->push('owned_feedback_ids', $feedback->id);
        return back()->with('feedback_success', 'Thank you for your feedback!');
    } catch (\Exception $e) {
        return back()->with('feedback_error', 'Sorry, failed to submit feedback. Please try again later.');
    }
})->name('feedback.send');

Route::put('/feedback/{id}', function (\Illuminate\Http\Request $request, $id) {
    $ownedIds = session('owned_feedback_ids', []);
    if (!in_array((int)$id, $ownedIds)) {
        return back()->with('feedback_error', 'You can only edit your own feedback.');
    }

    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'rating' => 'required|integer|min:1|max:5',
        'message' => 'required|string',
    ]);

    try {
        $feedback = Feedback::findOrFail($id);
        $feedback->update([
            'customer_name' => $validated['customer_name'],
            'rating' => $validated['rating'],
            'message' => $validated['message'],
        ]);
        return back()->with('feedback_success', 'Your feedback has been updated!');
    } catch (\Exception $e) {
        return back()->with('feedback_error', 'Sorry, failed to update feedback. Please try again later.');
    }
})->name('feedback.update');

Route::delete('/feedback/{id}', function ($id) {
    $ownedIds = session('owned_feedback_ids', []);
    if (!in_array((int)$id, $ownedIds)) {
        return back()->with('feedback_error', 'You can only delete your own feedback.');
    }

    try {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        $ownedIds = array_filter($ownedIds, function ($oid) use ($id) {
            return (int)$oid !== (int)$id;
        });
        session(['owned_feedback_ids' => array_values($ownedIds)]);
        return back()->with('feedback_success', 'Your feedback has been deleted.');
    } catch (\Exception $e) {
        return back()->with('feedback_error', 'Sorry, failed to delete feedback. Please try again later.');
    }
})->name('feedback.delete');

// Staff Routes
Route::middleware('auth:staff')->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $readyOrders = Order::where('status', 'ready')->count();
        $totalMenuItems = MenuItem::where('status', 'available')->count();
        $recentOrders = Order::where('payment_status', '!=', 'failed')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($order) {
                $items = json_decode($order->items, true) ?? [];
                $itemsText = collect($items)->map(function ($item) {
                    return $item['name'] . ' x' . ($item['quantity'] ?? 1);
                })->implode(', ');

                return [
                    'id' => $order->order_id,
                    'table' => $order->table_number,
                    'items' => $itemsText ?: '-',
                    'total' => number_format($order->total, 2),
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'time' => $order->created_at?->diffForHumans(),
                ];
            });

        return view('staff.dashboard', [
            'userName' => auth()->user()->name,
            'userRole' => 'staff',
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'readyOrders' => $readyOrders,
            'totalMenuItems' => $totalMenuItems,
            'recentOrders' => $recentOrders,
        ]);
    })->name('dashboard');

    Route::get('/profile', function () {
        $user = auth()->user();
        return view('staff.profile', [
            'userName' => $user->name,
            'userRole' => 'staff',
            'prefix' => 'staff',
            'profile' => [
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => 'staff',
                'phone' => $user->phone,
                'status' => $user->status,
                'join_date' => $user->created_at?->format('F d, Y') ?? 'January 2024',
            ],
        ]);
    })->name('profile');

    Route::post('/profile/update-name', function (\Illuminate\Http\Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        auth()->user()->update(['name' => $request->name]);
        return back()->with('success', 'Name updated successfully!');
    })->name('profile.update.name');

    Route::post('/profile/update-email', function (\Illuminate\Http\Request $request) {
        $request->validate(['email' => ['required', 'email', 'max:255', function ($attribute, $value, $fail) {
            $exists = Staff::where('email', $value)->where('id', '!=', auth()->id())->exists()
                   || Admin::where('email', $value)->exists();
            if ($exists) { $fail('The email has already been taken.'); }
        }]]);
        auth()->user()->update(['email' => $request->email]);
        return back()->with('success', 'Email updated successfully!');
    })->name('profile.update.email');

    Route::post('/profile/update-phone', function (\Illuminate\Http\Request $request) {
        $request->validate(['phone' => 'nullable|string|max:255']);
        auth()->user()->update(['phone' => '+60' . ltrim($request->phone, '0')]);
        return back()->with('success', 'Phone updated successfully!');
    })->name('profile.update.phone');

    Route::get('/change-password', function () {
        return view('auth.change-password', [
            'userName' => auth()->user()->name,
            'userRole' => 'staff',
        ]);
    })->name('change-password');

    Route::post('/change-password', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if (!\Illuminate\Support\Facades\Hash::check($validated['current_password'], auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        auth()->user()->update(['password' => \Illuminate\Support\Facades\Hash::make($validated['password'])]);
        return redirect()->route('staff.profile')->with('success', 'Password changed successfully!');
    })->name('change-password.submit');

    Route::post('/orders/{orderId}/status', function ($orderId, \Illuminate\Http\Request $request) {
        $request->validate(['status' => 'required|in:pending,preparing,ready']);
        $order = Order::where('order_id', $orderId)->firstOrFail();
        if ($order->payment_status === 'unpaid') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Cannot change status for unpaid orders.'], 403);
            }
            return back()->withErrors(['error' => 'Cannot change status for unpaid orders.']);
        }
        $order->update(['status' => $request->status]);
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Order status updated!');
    })->name('orders.update-status');

    Route::delete('/orders/{orderId}', function ($orderId, \Illuminate\Http\Request $request) {
        $order = Order::where('order_id', $orderId)->firstOrFail();
        $order->delete();
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Order deleted!');
    })->name('orders.destroy');

    Route::get('/orders', function () {
        $orders = Order::where('payment_status', '!=', 'failed')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
            $items = json_decode($order->items, true) ?? [];
            $itemsText = collect($items)->map(function ($item) {
                return $item['name'] . ' x' . ($item['quantity'] ?? 1);
            })->implode(', ');

            return [
                'id' => $order->order_id,
                'table' => $order->table_number,
                'items' => $itemsText ?: '-',
                'total' => number_format($order->total, 2),
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'time' => $order->created_at?->diffForHumans() ?: '-',
            ];
        });

        return view('staff.orders', [
            'userName' => auth()->user()->name,
            'userRole' => 'staff',
            'orders' => $orders,
        ]);
    })->name('orders');

    Route::get('/menu', function () {
        $menuItems = MenuItem::orderBy('category')->orderBy('name')->get();
        $addOns = MenuItem::where('category', 'add_on')->orderBy('name')->get();
        return view('staff.menu', [
            'userName' => auth()->user()->name,
            'userRole' => 'staff',
            'menuItems' => $menuItems,
            'addOns' => $addOns,
        ]);
    })->name('menu');

    Route::get('/feedback', function () {
        $rating = request()->query('rating');
        $query = Feedback::orderBy('feedback_date', 'desc');
        if ($rating && in_array((int)$rating, [1,2,3,4,5])) {
            $query->where('rating', (int)$rating);
        }
        $feedbacks = $query->get()->map(function ($fb) {
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
            'selectedRating' => $rating ? (int)$rating : null,
        ]);
    })->name('feedback');
});

// Admin Routes
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $readyOrders = Order::where('status', 'ready')->count();
        $totalStaff = Staff::count();
        $recentOrders = Order::where('payment_status', '!=', 'failed')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($order) {
                $items = json_decode($order->items, true) ?? [];
                $itemsText = collect($items)->map(function ($item) {
                    return $item['name'] . ' x' . ($item['quantity'] ?? 1);
                })->implode(', ');

                return [
                    'id' => $order->order_id,
                    'table' => $order->table_number,
                    'items' => $itemsText ?: '-',
                    'total' => number_format($order->total, 2),
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'time' => $order->created_at?->diffForHumans(),
                ];
            });

        return view('admin.dashboard', [
            'userName' => auth()->user()->name,
            'userRole' => 'admin',
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'readyOrders' => $readyOrders,
            'totalStaff' => $totalStaff,
            'recentOrders' => $recentOrders,
        ]);
    })->name('dashboard');

    Route::get('/profile', function () {
        $user = auth()->user();
        return view('admin.profile', [
            'userName' => $user->name,
            'userRole' => 'admin',
            'prefix' => 'admin',
            'profile' => [
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => 'admin',
                'phone' => $user->phone,
                'status' => $user->status,
                'join_date' => $user->created_at?->format('F d, Y') ?? 'January 2023',
            ],
        ]);
    })->name('profile');

    Route::post('/profile/update-name', function (\Illuminate\Http\Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        auth()->user()->update(['name' => $request->name]);
        return back()->with('success', 'Name updated successfully!');
    })->name('profile.update.name');

    Route::post('/profile/update-email', function (\Illuminate\Http\Request $request) {
        $request->validate(['email' => ['required', 'email', 'max:255', function ($attribute, $value, $fail) {
            $exists = Admin::where('email', $value)->where('id', '!=', auth()->id())->exists()
                   || Staff::where('email', $value)->exists();
            if ($exists) { $fail('The email has already been taken.'); }
        }]]);
        auth()->user()->update(['email' => $request->email]);
        return back()->with('success', 'Email updated successfully!');
    })->name('profile.update.email');

    Route::post('/profile/update-phone', function (\Illuminate\Http\Request $request) {
        $request->validate(['phone' => 'nullable|string|max:255']);
        auth()->user()->update(['phone' => '+60' . ltrim($request->phone, '0')]);
        return back()->with('success', 'Phone updated successfully!');
    })->name('profile.update.phone');

    Route::get('/change-password', function () {
        return view('auth.change-password', [
            'userName' => auth()->user()->name,
            'userRole' => 'admin',
        ]);
    })->name('change-password');

    Route::post('/change-password', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if (!\Illuminate\Support\Facades\Hash::check($validated['current_password'], auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        auth()->user()->update(['password' => \Illuminate\Support\Facades\Hash::make($validated['password'])]);
        return redirect()->route('admin.profile')->with('success', 'Password changed successfully!');
    })->name('change-password.submit');

    Route::post('/orders/{orderId}/status', function ($orderId, \Illuminate\Http\Request $request) {
        $request->validate(['status' => 'required|in:pending,preparing,ready']);
        $order = Order::where('order_id', $orderId)->firstOrFail();
        if ($order->payment_status === 'unpaid') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Cannot change status for unpaid orders.'], 403);
            }
            return back()->withErrors(['error' => 'Cannot change status for unpaid orders.']);
        }
        $order->update(['status' => $request->status]);
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Order status updated!');
    })->name('orders.update-status');

    Route::delete('/orders/{orderId}', function ($orderId, \Illuminate\Http\Request $request) {
        $order = Order::where('order_id', $orderId)->firstOrFail();
        $order->delete();
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Order deleted!');
    })->name('orders.destroy');

    Route::get('/orders', function () {
        $orders = Order::where('payment_status', '!=', 'failed')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
            $items = json_decode($order->items, true) ?? [];
            $itemsText = collect($items)->map(function ($item) {
                return $item['name'] . ' x' . ($item['quantity'] ?? 1);
            })->implode(', ');

            return [
                'id' => $order->order_id,
                'table' => $order->table_number,
                'items' => $itemsText ?: '-',
                'total' => number_format($order->total, 2),
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'time' => $order->created_at?->diffForHumans() ?: '-',
            ];
        });

        return view('admin.orders', [
            'userName' => auth()->user()->name,
            'userRole' => 'admin',
            'orders' => $orders,
        ]);
    })->name('orders');

    Route::get('/menu', function () {
        $menuItems = MenuItem::orderBy('category')->orderBy('name')->get();
        $addOns = MenuItem::where('category', 'add_on')->orderBy('name')->get();
        return view('admin.menu', [
            'userName' => auth()->user()->name,
            'userRole' => 'admin',
            'menuItems' => $menuItems,
            'addOns' => $addOns,
        ]);
    })->name('menu');

    Route::get('/feedback', function () {
        $rating = request()->query('rating');
        $query = Feedback::orderBy('feedback_date', 'desc');
        if ($rating && in_array((int)$rating, [1,2,3,4,5])) {
            $query->where('rating', (int)$rating);
        }
        $feedbacks = $query->get()->map(function ($fb) {
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
            'selectedRating' => $rating ? (int)$rating : null,
        ]);
    })->name('feedback');

    Route::get('/staff', function () {
        $admins = Admin::all()->map(function ($u) {
            return ['id' => 'admin_' . $u->id, 'name' => $u->name, 'username' => $u->username, 'email' => $u->email, 'role' => 'admin', 'phone' => $u->phone ?? '+60 12-345 6789', 'status' => ucfirst($u->status), 'model' => 'admin'];
        });
        $staff = Staff::all()->map(function ($u) {
            return ['id' => 'staff_' . $u->id, 'name' => $u->name, 'username' => $u->username, 'email' => $u->email, 'role' => 'staff', 'phone' => $u->phone ?? '+60 12-345 6789', 'status' => ucfirst($u->status), 'model' => 'staff'];
        });
        $allUsers = $admins->concat($staff)->sortBy('name')->values();

        return view('admin.staff', [
            'userName' => auth()->user()->name,
            'userRole' => 'admin',
            'staff' => $allUsers,
        ]);
    })->name('staff');

    Route::post('/staff/add', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (Admin::where('username', $value)->exists() || Staff::where('username', $value)->exists()) {
                    $fail('The username has already been taken.');
                }
            }],
            'email' => ['required', 'email', 'max:255', function ($attribute, $value, $fail) {
                if (Admin::where('email', $value)->exists() || Staff::where('email', $value)->exists()) {
                    $fail('The email has already been taken.');
                }
            }],
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'phone' => 'nullable|string|max:255',
        ]);

        Staff::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'phone' => $validated['phone'] ? '+60' . ltrim($validated['phone'], '0') : null,
            'status' => 'active',
        ]);

        return redirect()->route('admin.staff')->with('success', 'Staff added successfully!');
    })->name('staff.add');

    Route::delete('/staff/{id}', function ($id) {
        $parts = explode('_', $id, 2);
        $type = $parts[0];
        $realId = $parts[1] ?? $id;

        if ($type === 'admin') {
            $user = Admin::findOrFail($realId);
            if (Admin::count() <= 1) {
                return back()->withErrors(['error' => 'Cannot delete the last admin.']);
            }
        } else {
            $user = Staff::findOrFail($realId);
        }
        $user->delete();
        return redirect()->route('admin.staff')->with('success', 'Staff deleted successfully!');
    })->name('staff.delete');

    Route::get('/staff/{id}/edit', function ($id) {
        $parts = explode('_', $id, 2);
        $type = $parts[0];
        $realId = $parts[1] ?? $id;

        if ($type === 'admin') {
            $user = Admin::findOrFail($realId);
        } else {
            $user = Staff::findOrFail($realId);
        }

        return response()->json([
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'status' => ucfirst($user->status),
        ]);
    })->name('staff.edit');

    Route::post('/staff/{id}/update', function (\Illuminate\Http\Request $request, $id) {
        $parts = explode('_', $id, 2);
        $type = $parts[0];
        $realId = $parts[1] ?? $id;

        if ($type === 'admin') {
            $user = Admin::findOrFail($realId);
        } else {
            $user = Staff::findOrFail($realId);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) use ($user) {
                $adminExists = Admin::where('username', $value)->where('id', '!=', $user->id)->exists();
                $staffExists = Staff::where('username', $value)->where('id', '!=', $user->id)->exists();
                if ($adminExists || $staffExists) {
                    $fail('The username has already been taken.');
                }
            }],
            'email' => ['required', 'email', 'max:255', function ($attribute, $value, $fail) use ($user) {
                $adminExists = Admin::where('email', $value)->where('id', '!=', $user->id)->exists();
                $staffExists = Staff::where('email', $value)->where('id', '!=', $user->id)->exists();
                if ($adminExists || $staffExists) {
                    $fail('The email has already been taken.');
                }
            }],
            'phone' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|min:6',
            'password_confirmation' => 'required_with:password|same:password',
        ]);

        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ? '+60' . ltrim($validated['phone'], '0') : null,
            'status' => $validated['status'],
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.staff')->with('success', 'Staff updated successfully!');
    })->name('staff.update');
});

// Public API - Recent orders for customer order status
Route::get('/api/orders/recent', function () {
    $orders = Order::where('payment_status', 'paid')
        ->where(function ($q) {
            $q->where('status', '!=', 'ready')
              ->orWhere('updated_at', '>=', now()->subMinutes(1));
        })
        ->orderBy('updated_at', 'desc')
        ->take(50)
        ->get()
        ->map(function ($order) {
            $items = json_decode($order->items, true) ?? [];
            $itemsText = collect($items)->map(function ($item) {
                return $item['name'] . ' x' . ($item['quantity'] ?? 1);
            })->implode(', ');

            return [
                'id' => $order->order_id,
                'items' => $itemsText ?: '-',
                'status' => $order->status,
                'updated_at' => $order->updated_at?->toISOString(),
                'time' => $order->updated_at?->diffForHumans() ?? '-',
            ];
        });

    return response()->json(['orders' => $orders]);
});

// API Routes for Real-time Order Sync & Menu Management
Route::middleware('auth:staff,admin')->prefix('api')->name('api.')->group(function () {
    Route::get('/orders/check', function () {
        static $lastCount = null;
        $currentCount = Order::where('payment_status', '!=', 'failed')->count();
        $lastCount = $lastCount ?? $currentCount;
        $hasNew = $currentCount > $lastCount;
        $lastCount = $currentCount;

        $latestOrders = Order::where('payment_status', '!=', 'failed')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($order) {
                $items = json_decode($order->items, true) ?? [];
                $itemsText = collect($items)->map(function ($item) {
                    return $item['name'] . ' x' . ($item['quantity'] ?? 1);
                })->implode(', ');

                return [
                    'id' => $order->order_id,
                    'table' => $order->table_number,
                    'items' => $itemsText ?: '-',
                    'total' => number_format($order->total, 2),
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'time' => $order->created_at?->diffForHumans(),
                    'timestamp' => $order->created_at?->toISOString(),
                ];
            });

        return response()->json([
            'hasNew' => $hasNew,
            'totalOrders' => $currentCount,
            'pendingOrders' => Order::where('payment_status', '!=', 'failed')->where('status', 'pending')->count(),
            'readyOrders' => Order::where('payment_status', '!=', 'failed')->where('status', 'ready')->count(),
            'orders' => $latestOrders,
        ]);
    })->name('orders.check');

    Route::post('/orders/{id}/status', function ($id) {
        $request = request();
        $request->validate(['status' => 'required|in:pending,preparing,ready']);
        $order = Order::findOrFail($id);
        if ($order->payment_status === 'unpaid') {
            return response()->json(['success' => false, 'message' => 'Cannot change status for unpaid orders.'], 403);
        }
        $order->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    })->name('orders.update-status');

    Route::get('/menu/addons', function () {
        $addOns = MenuItem::where('category', 'add_on')->orderBy('name')->get(['id', 'name', 'group_name']);
        return response()->json(['addons' => $addOns]);
    })->name('menu.addons');

    Route::get('/menu/check', function () {
        $menuItems = MenuItem::orderBy('category')->orderBy('name')->get()->map(function ($item) {
            $imgFile = \App\Helpers\MenuImageHelper::getImageFilename($item->name);
            return [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'price' => number_format($item->price, 2),
                'category' => $item->category,
                'status' => $item->status,
                'image' => $item->image,
                'image_url' => $imgFile ? asset('images/menu/' . $imgFile) : null,
            ];
        });
        return response()->json(['menu' => $menuItems]);
    })->name('menu.check');

    Route::post('/menu/add', function () {
        $request = request();
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'status' => 'nullable|in:available,unavailable',
            'image' => ($request->category !== 'add_on' ? 'required|' : 'nullable|') . 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'linked_addons' => 'nullable|array',
            'linked_addons.*' => 'integer|exists:menu_items,id',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/menu'), $imageName);
        }

        $item = MenuItem::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'status' => $request->status ?? 'available',
            'image' => $imageName,
        ]);

        if ($request->category !== 'add_on') {
            $allAddons = MenuItem::where('category', 'add_on')
                ->whereJsonContains('applies_to', $request->category)
                ->get();
            foreach ($allAddons as $addon) {
                if (!$request->filled('linked_addons') || !in_array($addon->id, $request->linked_addons)) {
                    $appliesTo = $addon->applies_to ?? [];
                    $appliesTo = array_values(array_filter($appliesTo, fn($c) => $c !== $request->category));
                    $addon->update(['applies_to' => $appliesTo]);
                }
            }

            if ($request->filled('linked_addons')) {
                $addons = MenuItem::whereIn('id', $request->linked_addons)->where('category', 'add_on')->get();
                foreach ($addons as $addon) {
                    $appliesTo = $addon->applies_to ?? [];
                    if (!in_array($request->category, $appliesTo)) {
                        $appliesTo[] = $request->category;
                        $addon->update(['applies_to' => $appliesTo]);
                    }
                }
            }
        }

        return response()->json(['success' => true, 'item' => $item]);
    })->name('menu.add');

    Route::delete('/menu/{id}', function ($id) {
        $item = MenuItem::findOrFail($id);
        if ($item->image && file_exists(public_path('images/menu/' . $item->image))) {
            @unlink(public_path('images/menu/' . $item->image));
        }
        $item->delete();
        return response()->json(['success' => true]);
    })->name('menu.delete');

    Route::patch('/menu/{id}/status', function ($id) {
        $request = request();
        $request->validate(['status' => 'required|in:available,unavailable']);
        $item = MenuItem::findOrFail($id);
        $item->update(['status' => $request->status]);
        return response()->json(['success' => true, 'status' => $item->status]);
    })->name('menu.status');

    Route::get('/menu/{id}', function ($id) {
        $item = MenuItem::findOrFail($id);
        $linkedAddonIds = [];
        if ($item->category !== 'add_on') {
            $linkedAddonIds = MenuItem::where('category', 'add_on')
                ->whereJsonContains('applies_to', $item->category)
                ->pluck('id')
                ->toArray();
        }
        return response()->json([
            'item' => $item,
            'linked_addon_ids' => $linkedAddonIds,
        ]);
    })->name('menu.show');

    Route::post('/menu/{id}/update', function ($id) {
        $request = request();
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'status' => 'nullable|in:available,unavailable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'linked_addons' => 'nullable|array',
            'linked_addons.*' => 'integer|exists:menu_items,id',
        ]);

        $item = MenuItem::findOrFail($id);
        $oldCategory = $item->category;

        $imageName = $item->image;
        if ($request->hasFile('image')) {
            if ($item->image && file_exists(public_path('images/menu/' . $item->image))) {
                @unlink(public_path('images/menu/' . $item->image));
            }
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/menu'), $imageName);
        }

        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'status' => $request->status ?? 'available',
            'image' => $imageName,
        ]);

        if ($oldCategory !== $request->category && $oldCategory !== 'add_on') {
            $oldLinkedAddons = MenuItem::where('category', 'add_on')
                ->whereJsonContains('applies_to', $oldCategory)
                ->get();
            foreach ($oldLinkedAddons as $addon) {
                $appliesTo = $addon->applies_to ?? [];
                $appliesTo = array_values(array_filter($appliesTo, fn($c) => $c !== $oldCategory));
                $addon->update(['applies_to' => $appliesTo]);
            }
        }

        if ($request->category !== 'add_on') {
            $allAddons = MenuItem::where('category', 'add_on')
                ->whereJsonContains('applies_to', $request->category)
                ->get();
            foreach ($allAddons as $addon) {
                if (!$request->filled('linked_addons') || !in_array($addon->id, $request->linked_addons)) {
                    $appliesTo = $addon->applies_to ?? [];
                    $appliesTo = array_values(array_filter($appliesTo, fn($c) => $c !== $request->category));
                    $addon->update(['applies_to' => $appliesTo]);
                }
            }

            if ($request->filled('linked_addons')) {
                $addons = MenuItem::whereIn('id', $request->linked_addons)->where('category', 'add_on')->get();
                foreach ($addons as $addon) {
                    $appliesTo = $addon->applies_to ?? [];
                    if (!in_array($request->category, $appliesTo)) {
                        $appliesTo[] = $request->category;
                        $addon->update(['applies_to' => $appliesTo]);
                    }
                }
            }
        }

        return response()->json(['success' => true]);
    })->name('menu.update');
});

// Test line
