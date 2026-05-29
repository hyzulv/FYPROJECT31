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
    <div class="stat-card" id="statReady">
        <div class="card-icon">✅</div>
        <div class="card-value" id="readyOrders">{{ $readyOrders }}</div>
        <div class="card-label">Ready Orders</div>
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
                    <td><span class="badge badge-{{ $order['payment_status'] === 'unpaid' ? 'unpaid' : $order['status'] }}">{{ $order['payment_status'] === 'unpaid' ? 'Invalid order' : ucfirst($order['status']) }}</span></td>
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
let lastStatusHash = '';

function checkNewOrders() {
    fetch("{{ route('api.orders.check') }}")
        .then(res => res.json())
        .then(data => {
            const currentStatusHash = data.orders.map(o => o.id + o.status).join('|');
            if (data.hasNew) {
                showNotification(data);
            }
            if (data.hasNew || currentStatusHash !== lastStatusHash) {
                updateOrders(data);
            }
            lastOrderCount = data.totalOrders;
            lastStatusHash = currentStatusHash;
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
            new Notification('New Order!', { body: data.pendingOrders + ' pending orders' });
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
            <td><span class="badge badge-${order.payment_status === 'unpaid' || order.payment_status === 'failed' ? 'unpaid' : order.status}">${order.payment_status === 'unpaid' || order.payment_status === 'failed' ? 'Invalid order' : order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span></td>
            <td class="order-time" data-time="${order.timestamp || order.time}">${order.time}</td>
        </tr>`;
    });
    tbody.innerHTML = html;
    updateTimes();

    const pending = document.getElementById('statPending');
    pending.style.animation = 'none';
    pending.offsetHeight;
    pending.style.animation = 'flashCard 0.6s ease';
}

function updateTimes() {
    document.querySelectorAll('.order-time').forEach(td => {
        const timeStr = td.getAttribute('data-time');
        if (timeStr) {
            const date = new Date(timeStr);
            if (!isNaN(date)) {
                const now = new Date();
                const diff = Math.floor((now - date) / 1000);
                let relative = '';
                if (diff < 60) relative = 'Just now';
                else if (diff < 3600) relative = Math.floor(diff/60) + ' min ago';
                else if (diff < 86400) relative = Math.floor(diff/3600) + ' hr ago';
                else relative = Math.floor(diff/86400) + ' days ago';
                td.textContent = relative;
            }
        }
    });
}

setInterval(updateTimes, 60000);
updateTimes();

if (!window._orderPolling) {
    window._orderPolling = setInterval(checkNewOrders, 5000);
}
</script>
@endpush
