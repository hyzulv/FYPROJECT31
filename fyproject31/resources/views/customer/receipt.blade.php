@extends('layouts.customer')

@section('title', 'Order Receipt - MAT ROCK Restaurant')

@section('content')
<div class="receipt-container">
    <div class="receipt-actions no-print">
        <button class="action-btn" onclick="window.print()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                <path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
                <path d="M6 14h12v8H6z"/>
            </svg>
            Print / Save PDF
        </button>
        <a href="{{ route('homepage') }}" class="action-btn secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                <path d="M3 12l9-9 9 9"/><path d="M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10"/>
            </svg>
            Back to Home
        </a>
    </div>

    <div class="receipt-card" id="receiptContent">
        <div class="receipt-header">
            <div class="receipt-logo">
                <img src="{{ asset('images/brand/logo.jpg') }}" alt="MAT ROCK">
            </div>
            <h1>MAT ROCK</h1>
            <p class="receipt-subtitle">Ayam Goreng Kunyit Skudai</p>
            <p class="receipt-order-id">Order {{ $order->order_id }}</p>
            <p class="receipt-table">Table: {{ $order->table_number }}</p>
            <p class="receipt-time">{{ now()->format('d/m/Y h:i A') }}</p>
        </div>

        <div class="receipt-divider"></div>

        <div class="receipt-items">
            <h3>Order Items</h3>
            @php
                $items = json_decode($order->items, true) ?? [];
                $subtotal = 0;
            @endphp
            @foreach($items as $item)
                @php
                    $itemTotal = $item['price'] * $item['quantity'];
                    $subtotal += $itemTotal;
                @endphp
                <div class="receipt-item">
                    <div class="receipt-item-info">
                        <span class="receipt-item-name">{{ $item['name'] }}</span>
                        @if(!empty($item['addons']))
                            <div class="receipt-item-addons">
                                @foreach($item['addons'] as $addon)
                                    <span>+ {{ $addon['name'] }}</span>
                                @endforeach
                            </div>
                        @endif
                        <span class="receipt-item-qty">x{{ $item['quantity'] }}</span>
                    </div>
                    <span class="receipt-item-price">RM {{ number_format($itemTotal, 2) }}</span>
                </div>
            @endforeach
        </div>

        <div class="receipt-divider"></div>

        <div class="receipt-totals">
            <div class="receipt-total-row">
                <span>Subtotal</span>
                <span>RM {{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="receipt-total-row">
                <span>Service Tax (6%)</span>
                <span>RM {{ number_format($order->total - $subtotal, 2) }}</span>
            </div>
            <div class="receipt-total-row final">
                <span>Total</span>
                <span>RM {{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <div class="receipt-divider"></div>

        <div class="receipt-payment">
            <h3>Payment Status</h3>
            @if($order->payment_status === 'paid')
                <div class="payment-status paid">
                    <span class="payment-badge paid">Paid</span>
                    @if($order->transaction_id)
                        <p>Transaction: {{ $order->transaction_id }}</p>
                    @endif
                    @if($order->paid_at)
                        <p>{{ $order->paid_at->format('d/m/Y h:i A') }}</p>
                    @endif
                </div>
            @elseif($order->payment_status === 'failed')
                <div class="payment-status failed">
                    <span class="payment-badge failed">Payment Failed</span>
                    <p>Please try again or pay at counter.</p>
                </div>
            @else
                <div class="payment-status unpaid">
                    <span class="payment-badge unpaid">Unpaid</span>
                    <p>Please complete your payment to confirm order.</p>
                </div>
            @endif
        </div>

        <div class="receipt-footer">
            <p>Thank you for dining with us!</p>
            <p class="receipt-footer-location">Skudai, Johor Bahru</p>
        </div>
    </div>
</div>

<style>
.receipt-container {
    max-width: 480px;
    margin: 0 auto;
    padding: 20px 16px 40px;
}

.receipt-actions {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: #420C09;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: #300806;
    transform: translateY(-2px);
}

.action-btn.secondary {
    background: rgba(66,12,9,0.08);
    color: #420C09;
}

.action-btn.secondary:hover {
    background: rgba(66,12,9,0.15);
}

.receipt-card {
    background: #fff;
    border: 2px solid #420C09;
    border-radius: 16px;
    padding: 32px 24px;
    box-shadow: 0 10px 30px rgba(66,12,9,0.1);
}

.receipt-header {
    text-align: center;
    margin-bottom: 20px;
}

.receipt-logo {
    width: 70px;
    height: 70px;
    margin: 0 auto 12px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #420C09;
}

.receipt-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.receipt-header h1 {
    color: #420C09;
    font-size: 1.4rem;
    margin: 0 0 4px;
}

.receipt-subtitle {
    color: #666;
    font-size: 0.85rem;
    margin: 0 0 16px;
}

.receipt-order-id {
    color: #420C09;
    font-weight: 700;
    font-size: 1.1rem;
    margin: 0 0 4px;
}

.receipt-table, .receipt-time {
    color: #666;
    font-size: 0.9rem;
    margin: 2px 0;
}

.receipt-divider {
    height: 1px;
    background: rgba(66,12,9,0.15);
    margin: 16px 0;
}

.receipt-items h3 {
    color: #420C09;
    font-size: 0.95rem;
    margin: 0 0 12px;
}

.receipt-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 8px 0;
    border-bottom: 1px solid rgba(66,12,9,0.06);
}

.receipt-item:last-child {
    border-bottom: none;
}

.receipt-item-info {
    flex: 1;
}

.receipt-item-name {
    font-weight: 500;
    color: #222;
    font-size: 0.9rem;
}

.receipt-item-addons {
    font-size: 0.78rem;
    color: #888;
    margin-top: 2px;
}

.receipt-item-addons span {
    display: block;
}

.receipt-item-qty {
    display: block;
    color: #888;
    font-size: 0.8rem;
    margin-top: 2px;
}

.receipt-item-price {
    font-weight: 600;
    color: #222;
    font-size: 0.9rem;
    white-space: nowrap;
}

.receipt-totals {
    padding: 4px 0;
}

.receipt-total-row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    color: #666;
    font-size: 0.9rem;
}

.receipt-total-row.final {
    color: #420C09;
    font-weight: 700;
    font-size: 1.1rem;
    border-top: 1px solid rgba(66,12,9,0.15);
    padding-top: 10px;
    margin-top: 4px;
}

.receipt-payment {
    text-align: center;
}

.receipt-payment h3 {
    color: #420C09;
    font-size: 0.95rem;
    margin: 0 0 12px;
}

.payment-status p {
    color: #666;
    font-size: 0.85rem;
    margin: 4px 0;
}

.payment-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
    margin-bottom: 8px;
}

.payment-badge.paid {
    background: rgba(40, 167, 69, 0.15);
    color: #28a745;
}

.payment-badge.unpaid {
    background: rgba(255, 193, 7, 0.2);
    color: #cc9a06;
}

.payment-badge.failed {
    background: rgba(220, 53, 69, 0.12);
    color: #dc3545;
}

.pay-now-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 12px;
    padding: 12px 24px;
    background: #420C09;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
}

.pay-now-btn:hover {
    background: #300806;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(66,12,9,0.3);
}

.receipt-footer {
    text-align: center;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid rgba(66,12,9,0.1);
}

.receipt-footer p {
    color: #420C09;
    font-weight: 600;
    font-size: 0.9rem;
    margin: 0 0 4px;
}

.receipt-footer-location {
    color: #999 !important;
    font-weight: 400 !important;
    font-size: 0.8rem !important;
}

@media print {
    .no-print {
        display: none !important;
    }
    .receipt-container {
        padding: 0;
    }
    .receipt-card {
        border: none;
        box-shadow: none;
        padding: 20px;
    }
    body {
        background: #fff !important;
    }
}

@media (max-width: 480px) {
    .receipt-card {
        padding: 24px 16px;
    }
    .receipt-actions {
        flex-direction: column;
    }
    .action-btn {
        justify-content: center;
    }
}
</style>
@endsection
