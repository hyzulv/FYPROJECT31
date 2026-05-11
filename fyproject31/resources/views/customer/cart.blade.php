@extends('layouts.customer')

@section('title', 'Cart - MAT ROCK Restaurant')

@section('content')
<div class="cart-container">
    <header class="cart-header">
        <button class="back-btn" onclick="window.history.back()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </button>
        <h1>Your Cart</h1>
        <button class="clear-cart-btn" onclick="clearCartAction()" title="Clear Cart">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14"/>
            </svg>
        </button>
    </header>

    <div class="cart-items" id="cartItems">
    </div>

    <div class="cart-empty" id="cartEmpty" style="display: none;">
        <div class="empty-icon">
            <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="40" cy="40" r="30" stroke="#420C09" stroke-width="2" fill="rgba(66,12,9,0.1)"/>
                <path d="M25 35h30l-3 20H28l-3-20z" stroke="#420C09" stroke-width="2" fill="none"/>
                <circle cx="35" cy="45" r="2" fill="#420C09"/>
                <circle cx="45" cy="45" r="2" fill="#420C09"/>
            </svg>
        </div>
        <h3>Your cart is empty</h3>
        <p>Add some delicious items from our menu</p>
        <a href="{{ route('customer.menu') }}" class="btn-primary">Browse Menu</a>
    </div>

    <div class="cart-summary" id="cartSummary" style="display: none;">
        <div class="summary-row">
            <span>Subtotal</span>
            <span id="subtotalAmount">RM 0.00</span>
        </div>
        <div class="summary-row">
            <span>Service Tax (6%)</span>
            <span id="taxAmount">RM 0.00</span>
        </div>
        <div class="summary-divider"></div>
        <div class="summary-row total">
            <span>Total</span>
            <span id="totalAmount">RM 0.00</span>
        </div>
        <a href="{{ route('customer.checkout') }}" class="btn-checkout">
            Proceed to Checkout
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6"/>
            </svg>
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    renderCartPage();
    window.onCartUpdate = renderCartPage;

    document.getElementById('cartItems').addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.remove-btn');
        if (removeBtn) {
            const key = removeBtn.getAttribute('data-key');
            window.cartManager.removeItem(key);
            return;
        }
        const qtyBtn = e.target.closest('.qty-btn');
        if (qtyBtn) {
            const key = qtyBtn.getAttribute('data-key');
            const action = qtyBtn.getAttribute('data-action');
            if (action === 'increase') {
                window.cartManager.increaseItem(key);
            } else {
                window.cartManager.decreaseItem(key);
            }
        }
    });
});

function renderCartPage() {
    const cart = window.cartManager.getCart();
    const cartItemsEl = document.getElementById('cartItems');
    const cartEmptyEl = document.getElementById('cartEmpty');
    const cartSummaryEl = document.getElementById('cartSummary');

    if (!cartItemsEl || !cartEmptyEl || !cartSummaryEl) return;

    if (cart.length === 0) {
        cartItemsEl.innerHTML = '';
        cartEmptyEl.style.display = 'flex';
        cartSummaryEl.style.display = 'none';
        return;
    }

    cartEmptyEl.style.display = 'none';
    cartSummaryEl.style.display = 'block';

    let html = '';
    let subtotal = 0;

    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;

        let addonsHtml = '';
        if (item.addons && item.addons.length > 0) {
            addonsHtml = '<div class="cart-item-addons">';
            item.addons.forEach(addon => {
                addonsHtml += '<span class="addon-tag">+ ' + addon.name + '</span>';
            });
            addonsHtml += '</div>';
        }

        html += '<div class="cart-item">';
        html += '  <div class="cart-item-top">';
        html += '    <div class="cart-item-info">';
        html += '      <h3>' + escapeHtml(item.name) + '</h3>';
        html += '      ' + addonsHtml;
        html += '    </div>';
        html += '    <button class="remove-btn" data-key="' + item.key + '" title="Remove">';
        html += '      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>';
        html += '    </button>';
        html += '  </div>';
        html += '  <div class="cart-item-bottom">';
        html += '    <div class="cart-item-actions">';
        html += '      <button class="qty-btn" data-key="' + item.key + '" data-action="decrease">';
        html += '        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/></svg>';
        html += '      </button>';
        html += '      <span class="qty-display">' + item.quantity + '</span>';
        html += '      <button class="qty-btn" data-key="' + item.key + '" data-action="increase">';
        html += '        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>';
        html += '      </button>';
        html += '    </div>';
        html += '    <div class="cart-item-total">RM ' + itemTotal.toFixed(2) + '</div>';
        html += '  </div>';
        html += '</div>';
    });

    cartItemsEl.innerHTML = html;

    const tax = subtotal * 0.06;
    const total = subtotal + tax;

    document.getElementById('subtotalAmount').textContent = 'RM ' + subtotal.toFixed(2);
    document.getElementById('taxAmount').textContent = 'RM ' + tax.toFixed(2);
    document.getElementById('totalAmount').textContent = 'RM ' + total.toFixed(2);
}

function escapeHtml(str) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

function clearCartAction() {
    if (confirm('Clear all items from cart?')) {
        window.cartManager.clearCart();
    }
}
</script>
@endpush
