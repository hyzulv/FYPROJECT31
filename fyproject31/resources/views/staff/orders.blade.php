@extends('layouts.app')

@section('title', 'Orders')
@section('page-title', 'View Orders')

@section('content')
<div class="data-card">
    <h3>All Orders</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Table</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="ordersTableBody">
            @foreach($orders as $order)
            <tr>
                <td>{{ $order['id] }}</td>
                <td>{{ $order['table] }}</td>
                <td>{{ $order['items] }}</td>
                <td>RM {{ $order['total] }}</td>
                <td>
                    <form action="{{ route($userRole . '.orders.update-status', $order['id]) }}" method="POST" style="margin:0;">
                        @csrf
                        <select name="status" onchange="this.form.submit()" style="padding: 6px 10px; background: #2a2a2a; color: #fff; border: 1px solid rgba(209, 152, 106, 0.3); border-radius: 6px; font-size: 0.85rem;">
                            <option value="pending" {{ $order['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="preparing" {{ $order['status'] == 'preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="ready" {{ $order['status'] == 'ready' ? 'selected' : '' }}>Ready</option>
                            <option value="completed" {{ $order['status'] == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order['status'] == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </td>
                <td class="order-time" data-time="{{ $order['time] }}">{{ $order['time'] }}</td>
                <td>
                    <form action="{{ route($userRole . '.orders.destroy', $order['id']) }}" method="POST" onsubmit="return confirm('Delete this order?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
let lastOrderCount = {{ count($orders) }};

function checkNewOrders() {
    fetch("{{ route('api.orders.check') }}")
        .then(res => res.json())
        .then(data => {
            if (data.hasNew) {
                updateOrders(data);
            }
            lastOrderCount = data.totalOrders;
        })
        .catch(err => console.log('Order check error:', err));
}

function updateOrders(data) {
    const tbody = document.getElementById('ordersTableBody');
    let html = '';
    data.orders.forEach(order => {
        html += `<tr>
            <td>${order.id}</td>
            <td>${order.table}</td>
            <td>${order.items}</td>
            <td>RM ${order.total}</td>
            <td>
                <form action="{{ route($userRole . '.orders.update-status', '') }}/${order.id}" method="POST" style="margin:0;">
                    @csrf
                    <select name="status" onchange="this.form.submit()" style="padding: 6px 10px; background: #2a2a2a; color: #fff; border: 1px solid rgba(209, 152, 106, 0.3); border-radius: 6px; font-size: 0.85rem;">
                        <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>Pending</option>
                        <option value="preparing" ${order.status === 'preparing' ? 'selected' : ''}>Preparing</option>
                        <option value="ready" ${order.status === 'ready' ? 'selected' : ''}>Ready</option>
                        <option value="completed" ${order.status === 'completed' ? 'selected' : ''}>Completed</option>
                        <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                    </select>
                </form>
            </td>
            <td class="order-time" data-time="${order.time}">${order.time}</td>
            <td>
                <form action="{{ route($userRole . '.orders.destroy', '') }}/${order.id}" method="POST" onsubmit="return confirm('Delete this order?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Delete</button>
                </form>
            </td>
        </tr>`;
    });
    tbody.innerHTML = html;
}

// Update relative times every minute
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
