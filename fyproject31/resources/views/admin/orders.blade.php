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
                <th>Payment</th>
                <th>Status</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="ordersTableBody">
            @foreach($orders as $order)
            <tr data-order-id="{{ $order['id'] }}">
                <td>{{ $order['id'] }}</td>
                <td>{{ $order['table'] }}</td>
                <td>{{ $order['items'] }}</td>
                <td>RM {{ $order['total'] }}</td>
                <td><span class="badge badge-{{ $order['payment_status'] ?? 'unpaid' }}">{{ ucfirst($order['payment_status'] ?? 'unpaid') }}</span></td>
                <td>
                    @if($order['payment_status'] === 'unpaid')
                        <select disabled style="padding: 6px 10px; background: #f5f5f5; color: #222; border: 1px solid #ddd; border-radius: 6px; font-size: 0.85rem; appearance: none; -webkit-appearance: none;">
                            <option value="{{ $order['status'] }}" selected>Invalid order</option>
                        </select>
                    @else
                        <select onchange="updateOrderStatus('{{ $order['id'] }}', this.value)" style="padding: 6px 10px; background: #f5f5f5; color: #222; border: 1px solid #ddd; border-radius: 6px; font-size: 0.85rem;">
                            <option value="pending" {{ $order['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="preparing" {{ $order['status'] == 'preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="ready" {{ $order['status'] == 'ready' ? 'selected' : '' }}>Ready</option>
                        </select>
                    @endif
                </td>
                <td class="order-time" data-time="{{ $order['time'] }}">{{ $order['time'] }}</td>
                <td>
                    <button onclick="deleteOrder('{{ $order['id'] }}')" style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Delete</button>
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

function updateOrderStatus(orderId, status) {
    if (!orderId) return;
    const encodedId = encodeURIComponent(orderId);
    fetch(`/admin/orders/${encodedId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: status })
    })
    .then(res => {
        if (!res.ok) {
            return res.json().then(err => { throw err; });
        }
        return res.json();
    })
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert('Failed to update order status');
        }
    })
    .catch(err => {
        console.error('Status update error:', err);
        alert('Error: ' + JSON.stringify(err));
    });
}

function deleteOrder(orderId) {
    if (!orderId) return;
    if (!confirm('Delete this order?')) return;
    const encodedId = encodeURIComponent(orderId);
    fetch(`/admin/orders/${encodedId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ _method: 'DELETE' })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert('Failed to delete order');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error deleting order');
    });
}

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
        const encodedId = encodeURIComponent(order.id);
        const payStatus = order.payment_status || 'unpaid';
        const isUnpaid = payStatus === 'unpaid';
        html += `<tr data-order-id="${order.id}">
            <td>${order.id}</td>
            <td>${order.table}</td>
            <td>${order.items}</td>
            <td>RM ${order.total}</td>
            <td><span class="badge badge-${payStatus}">${payStatus.charAt(0).toUpperCase() + payStatus.slice(1)}</span></td>
            <td>
                ${isUnpaid
                    ? `<select disabled style="padding: 6px 10px; background: #f5f5f5; color: #222; border: 1px solid #ddd; border-radius: 6px; font-size: 0.85rem; appearance: none; -webkit-appearance: none;">
                        <option value="${order.status}" selected>Invalid order</option>
                    </select>`
                    : `<select onchange="updateOrderStatus('${order.id}', this.value)" style="padding: 6px 10px; background: #f5f5f5; color: #222; border: 1px solid #ddd; border-radius: 6px; font-size: 0.85rem;">
                        <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>Pending</option>
                        <option value="preparing" ${order.status === 'preparing' ? 'selected' : ''}>Preparing</option>
                        <option value="ready" ${order.status === 'ready' ? 'selected' : ''}>Ready</option>
                    </select>`
                }
            </td>
            <td class="order-time" data-time="${order.time}">${order.time}</td>
            <td>
                <button onclick="deleteOrder('${order.id}')" style="background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Delete</button>
            </td>
        </tr>`;
    });
    tbody.innerHTML = html;
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
