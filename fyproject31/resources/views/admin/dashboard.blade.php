@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
    <div class="live-indicator"><span class="live-dot"></span> Live Updates</div>
</div>

<div class="stat-cards">
    <div class="stat-card" id="statTotal">
        <div class="card-icon">📦</div>
        <div class="card-value" id="totalOrders">{{ $totalOrders }}</div>
        <div class="card-label">Total Orders</div>
    </div>
    <div class="stat-card" id="statPending">
        <div class="card-icon">⏳</div>
        <div class="card-value" id="pendingOrders">{{ $pendingOrders }}</div>
        <div class="card-label">Pending Orders</div>
    </div>
    <div class="stat-card">
        <div class="card-icon">✅</div>
        <div class="card-value">{{ $completedOrders }}</div>
        <div class="card-label">Completed Orders</div>
    </div>
    <div class="stat-card">
        <div class="card-icon">👥</div>
        <div class="card-value">{{ $totalStaff }}</div>
        <div class="card-label">Total Staff</div>
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
                <th>Time</th>
            </tr>
        </thead>
        <tbody id="ordersTableBody">
            @foreach($recentOrders as $order)
            <tr>
                <td>{{ $order['id'] }}</td>
                <td>{{ $order['table'] }}</td>
                <td>{{ $order['items'] }}</td>
                <td>RM {{ $order['total'] }}</td>
                <td><span class="badge badge-{{ $order['status'] }}">{{ ucfirst($order['status']) }}</span></td>
                <td>-</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="notification-toast" id="orderNotification">
    <span class="toast-icon">🔔</span>
    <span class="toast-text"><strong>New Order!</strong> <span id="newOrderInfo"></span></span>
</div>
@endsection

@push('scripts')
<script>
let lastOrderCount = {{ $totalOrders }};

function checkNewOrders() {
    fetch("{{ route('api.orders.check') }}")
        .then(res => res.json())
        .then(data => {
            if (data.hasNew) {
                showNotification(data);
                updateOrders(data);
            }
            lastOrderCount = data.totalOrders;
        })
        .catch(err => console.log('Order check error:', err));
}

function showNotification(data) {
    playNotificationSound();
    const notif = document.getElementById('orderNotification');
    document.getElementById('newOrderInfo').textContent = data.pendingOrders + ' pending orders';
    notif.classList.add('show');
    setTimeout(() => notif.classList.remove('show'), 4000);

    try {
        if (Notification.permission === 'granted') {
            new Notification('New Order!', { body: data.pendingOrders + ' pending orders waiting' });
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission();
        }
    } catch(e) {}
}

function updateOrders(data) {
    document.getElementById('totalOrders').textContent = data.totalOrders;
    document.getElementById('pendingOrders').textContent = data.pendingOrders;

    const tbody = document.getElementById('ordersTableBody');
    let html = '';
    data.orders.forEach(order => {
        html += `<tr>
            <td>${order.id}</td>
            <td>${order.table}</td>
            <td>${order.items}</td>
            <td>RM ${order.total}</td>
            <td><span class="badge badge-${order.status}">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span></td>
            <td>${order.time}</td>
        </tr>`;
    });
    tbody.innerHTML = html;

    const pending = document.getElementById('statPending');
    pending.style.animation = 'none';
    pending.offsetHeight;
    pending.style.animation = 'flashCard 0.6s ease';
}

if (!window._orderPolling) {
    window._orderPolling = setInterval(checkNewOrders, 5000);
}
</script>
@endpush
