@extends('layouts.customer')

@section('title', 'Checkout - MAT ROCK Restaurant')

@section('content')
<div class="checkout-container">
    <header class="checkout-header">
        <button class="back-btn" onclick="window.history.back()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </button>
        <h1>Checkout</h1>
        <div class="checkout-header-spacer"></div>
    </header>

    <div class="checkout-order-summary">
        <h2>Order Summary</h2>
        <div class="order-items" id="orderItems"></div>
        <div class="order-totals">
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="checkoutSubtotal">RM 0.00</span>
            </div>
            <div class="summary-row">
                <span>Service Tax (6%)</span>
                <span id="checkoutTax">RM 0.00</span>
            </div>
            <div class="summary-divider"></div>
            <div class="summary-row total">
                <span>Total</span>
                <span id="checkoutTotal">RM 0.00</span>
            </div>
        </div>
    </div>

    <form id="checkoutForm" class="checkout-form">
        <div class="form-group">
            <label for="table_number">Table Number <span class="required">*</span></label>
            <input type="text" id="table_number" name="table_number" placeholder="e.g., T01, 5, A12" required>
            <span class="error-message" id="tableError"></span>
        </div>

        <input type="hidden" name="items" id="checkoutItems">
        <input type="hidden" name="total" id="checkoutTotalValue">

        <button type="submit" class="btn-place-order" id="placeOrderBtn">
            <span class="btn-text">Place Order</span>
            <span class="btn-loader" style="display: none;">
                <svg class="spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" stroke-opacity="0.25"/>
                    <path d="M12 2a10 10 0 019.95 8.5"/>
                </svg>
                Processing...
            </span>
        </button>
    </form>
</div>

<div class="success-modal" id="successModal" style="display: none;">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <div class="success-icon">
            <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="40" cy="40" r="35" stroke="#cf2c21" stroke-width="3" fill="rgba(207,44,33,0.1)"/>
                <path d="M25 40l10 10 20-20" stroke="#cf2c21" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h2>Order Placed!</h2>
        <p class="order-number" id="modalOrderId"></p>
        <p>Your food is being prepared</p>
        <a href="{{ route('homepage') }}" class="btn-primary">Back to Home</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    renderCheckout();

    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        e.preventDefault();
        placeOrder();
    });
});

function renderCheckout() {
    const cart = window.cartManager.getCart();
    const orderItemsEl = document.getElementById('orderItems');

    if (!orderItemsEl) return;

    if (cart.length === 0) {
        window.location.href = "{{ route('customer.menu') }}";
        return;
    }

    let html = '';
    let subtotal = 0;

    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;

        let addonsHtml = '';
        if (item.addons && item.addons.length > 0) {
            addonsHtml = '<div class="checkout-item-addons">';
            item.addons.forEach(addon => {
                addonsHtml += `<span class="addon-tag">+ ${addon.name}</span>`;
            });
            addonsHtml += '</div>';
        }

        html += `
            <div class="checkout-item">
                <div class="checkout-item-main">
                    <div class="checkout-item-info">
                        <span class="checkout-item-name">${item.name}</span>
                        ${addonsHtml}
                    </div>
                    <span class="checkout-item-qty">x${item.quantity}</span>
                </div>
                <span class="checkout-item-price">RM ${itemTotal.toFixed(2)}</span>
            </div>
        `;
    });

    orderItemsEl.innerHTML = html;

    const tax = subtotal * 0.06;
    const total = subtotal + tax;

    document.getElementById('checkoutSubtotal').textContent = `RM ${subtotal.toFixed(2)}`;
    document.getElementById('checkoutTax').textContent = `RM ${tax.toFixed(2)}`;
    document.getElementById('checkoutTotal').textContent = `RM ${total.toFixed(2)}`;
    document.getElementById('checkoutTotalValue').value = total.toFixed(2);
    document.getElementById('checkoutItems').value = JSON.stringify(cart);
}

async function placeOrder() {
    const tableInput = document.getElementById('table_number');
    const tableError = document.getElementById('tableError');
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    const btnText = placeOrderBtn.querySelector('.btn-text');
    const btnLoader = placeOrderBtn.querySelector('.btn-loader');

    tableError.textContent = '';

    if (!tableInput.value.trim()) {
        tableError.textContent = 'Please enter your table number';
        tableInput.focus();
        return;
    }

    placeOrderBtn.disabled = true;
    btnText.style.display = 'none';
    btnLoader.style.display = 'flex';

    const formData = new FormData(document.getElementById('checkoutForm'));
    const data = {
        table_number: formData.get('table_number'),
        items: JSON.parse(formData.get('items')),
        total: parseFloat(formData.get('total'))
    };

    try {
        const response = await fetch("{{ route('customer.order.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (!response.ok) {
            console.error('Order error:', result);
            if (result.errors) {
                const errorMessages = Object.values(result.errors).flat().join('\n');
                tableError.textContent = errorMessages;
            } else {
                tableError.textContent = result.message || 'Something went wrong. Please try again.';
            }
            return;
        }

        if (result.success) {
            window.cartManager.clearCart();
            document.getElementById('modalOrderId').textContent = `Order ${result.order_id}`;
            document.getElementById('successModal').style.display = 'flex';
        } else {
            tableError.textContent = result.message || 'Something went wrong. Please try again.';
        }
    } catch (error) {
        console.error('Network error:', error);
        tableError.textContent = 'Network error: ' + error.message;
    } finally {
        placeOrderBtn.disabled = false;
        btnText.style.display = 'inline';
        btnLoader.style.display = 'none';
    }
}
</script>
@endpush
