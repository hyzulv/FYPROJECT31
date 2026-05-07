@extends('layouts.customer')

@section('title', 'Order Confirmed - MAT ROCK Restaurant')

@section('content')
<div class="success-container">
    <div class="success-card">
        <div class="success-icon-large">
            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="45" stroke="#d1986a" stroke-width="3" fill="rgba(209,152,106,0.1)"/>
                <path d="M30 50l12 12 24-24" stroke="#d1986a" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h1>Order Confirmed!</h1>
        <p class="order-id">Order {{ $order->order_id }}</p>
        <p class="order-details">Table {{ $order->table_number }}</p>

        <div class="order-summary-card">
            <h3>Order Summary</h3>
            @php
                $items = json_decode($order->items, true) ?? [];
            @endphp
            @foreach($items as $item)
            <div class="summary-item">
                <div class="summary-item-info">
                    <span class="summary-item-name">{{ $item['name'] }}</span>
                    <span class="summary-item-qty">x{{ $item['quantity'] }}</span>
                </div>
                <span class="summary-item-price">RM {{ number_format($item['price'] * $item['quantity'], 2) }}</span>
            </div>
            @endforeach
            <div class="summary-divider"></div>
            <div class="summary-total">
                <span>Total</span>
                <span>RM {{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <div class="status-badge">
            <span class="status-dot"></span>
            <span>Preparing your order</span>
        </div>

        <p class="thank-you">Thank you for dining with us!</p>

        <a href="{{ route('homepage') }}" class="btn-primary full-width">
            Back to Home
        </a>
    </div>
</div>
@endsection
