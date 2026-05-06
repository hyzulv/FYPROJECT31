@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="stat-cards">
    <div class="stat-card">
        <div class="card-icon">📦</div>
        <div class="card-value">{{ $totalOrders }}</div>
        <div class="card-label">Total Orders</div>
    </div>
    <div class="stat-card">
        <div class="card-icon">⏳</div>
        <div class="card-value">{{ $pendingOrders }}</div>
        <div class="card-label">Pending Orders</div>
    </div>
    <div class="stat-card">
        <div class="card-icon">✅</div>
        <div class="card-value">{{ $completedOrders }}</div>
        <div class="card-label">Completed Orders</div>
    </div>
    <div class="stat-card">
        <div class="card-icon">🍽️</div>
        <div class="card-value">{{ $totalMenuItems }}</div>
        <div class="card-label">Menu Items</div>
    </div>
</div>

<div class="data-card">
    <h3>Recent Orders</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Table</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
            <tr>
                <td>{{ $order['id'] }}</td>
                <td>{{ $order['table'] }}</td>
                <td>{{ $order['items'] }}</td>
                <td>RM {{ $order['total'] }}</td>
                <td><span class="badge badge-{{ $order['status'] }}">{{ ucfirst($order['status']) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
