@extends('layouts.customer')

@section('title', $item['name'] . ' - MAT ROCK Restaurant')

@section('content')
<div class="item-detail-container">
    <header class="item-detail-header">
        <button class="back-btn" onclick="window.history.back()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </button>
        <h1>Item Detail</h1>
        <button class="cart-btn" onclick="window.location.href='{{ route('customer.cart') }}'">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="9" cy="21" r="1"/>
                <circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
            </svg>
            <span class="cart-count" id="cartCount">0</span>
        </button>
    </header>

    <div class="item-detail-content">
        <div class="item-detail-image">
            @php $imgFile = \App\Helpers\MenuImageHelper::getImageFilename($item['name']); @endphp
            @if($imgFile)
                <img src="{{ asset('images/' . $imgFile) }}" alt="{{ $item['name'] }}">
            @elseif($item['image'])
                <img src="{{ asset('images/menu/' . $item['image']) }}" alt="{{ $item['name'] }}">
            @else
                <div class="placeholder-image-large">
                    <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="60" cy="75" rx="42" ry="18" stroke="#cf2c21" stroke-width="2" fill="rgba(207,44,33,0.1)"/>
                        <path d="M38 68 Q60 30 82 68" stroke="#cf2c21" stroke-width="2" fill="rgba(207,44,33,0.1)"/>
                        <circle cx="60" cy="45" r="4" fill="#cf2c21"/>
                    </svg>
                </div>
            @endif
        </div>

        <div class="item-detail-info">
            <h2 class="item-detail-name">{{ $item['name'] }}</h2>
            <p class="item-detail-desc">{{ $item['description'] }}</p>
            <span class="item-detail-price">RM {{ $item['price'] }}</span>
        </div>

        @if($addOns->count() > 0)
        <div class="item-detail-addons">
            <h3>Add-Ons</h3>
            @foreach($addOns as $addonGroup)
                <div class="addon-group">
                    @if($addonGroup['group_name'])
                        <h4 class="addon-group-title">{{ $addonGroup['group_name'] }}</h4>
                    @endif
                    <div class="addon-list">
                        @foreach($addonGroup['items'] as $addOn)
                        <label class="addon-item">
                            @if($addonGroup['selection_type'] === 'single')
                                <input type="radio" name="addon_group_{{ $addonGroup['group_name'] ?? $addOn['id'] }}" value="{{ $addOn['id'] }}" data-id="{{ $addOn['id'] }}" data-name="{{ $addOn['name'] }}" data-price="{{ $addOn['price'] }}" onchange="updateTotal()">
                            @else
                                <input type="checkbox" name="addons[]" value="{{ $addOn['id'] }}" data-id="{{ $addOn['id'] }}" data-name="{{ $addOn['name'] }}" data-price="{{ $addOn['price'] }}" onchange="updateTotal()">
                            @endif
                            <div class="addon-info">
                                <div class="addon-image">
                                    @php $addOnImg = \App\Helpers\MenuImageHelper::getImageFilename($addOn['name']); @endphp
                                    @if($addOnImg)
                                        <img src="{{ asset('images/' . $addOnImg) }}" alt="{{ $addOn['name'] }}">
                                    @elseif($addOn['image'])
                                        <img src="{{ asset('images/menu/' . $addOn['image']) }}" alt="{{ $addOn['name'] }}">
                                    @else
                                        <div class="addon-placeholder">
                                            <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="20" cy="20" r="12" stroke="#cf2c21" stroke-width="1.5" fill="rgba(207,44,33,0.1)"/>
                                                <path d="M14 20h12M20 14v12" stroke="#cf2c21" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <span class="addon-name">{{ $addOn['name'] }}</span>
                            </div>
                            <span class="addon-price">@if($addOn['price'] > 0)+RM {{ $addOn['price'] }}@else &nbsp; @endif</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        @endif

        <div class="item-detail-quantity">
            <h3>Quantity</h3>
            <div class="qty-control">
                <button class="qty-btn" onclick="changeQty(-1)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14"/>
                    </svg>
                </button>
                <span class="qty-display" id="qtyDisplay">1</span>
                <button class="qty-btn" onclick="changeQty(1)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="item-detail-bottom">
        <div class="item-total-row">
            <span class="item-total-label">Total</span>
            <span class="item-total-value" id="itemTotal">RM {{ $item['price'] }}</span>
        </div>
        <button class="btn-add-cart" onclick="addItemToCart()" style="width:100%;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="9" cy="21" r="1"/>
                <circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
            </svg>
            Add to Cart
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
const itemBasePrice = {{ $item['price'] }};
const itemId = {{ $item['id'] }};
const itemName = '{{ addslashes($item['name']) }}';
let quantity = 1;

document.addEventListener('DOMContentLoaded', function() {
    window.cartManager.updateCartDisplay();
});

function changeQty(delta) {
    quantity = Math.max(1, quantity + delta);
    document.getElementById('qtyDisplay').textContent = quantity;
    updateTotal();
}

function getSelectedAddons() {
    const addons = [];

    document.querySelectorAll('input[name="addons[]"]:checked').forEach(cb => {
        addons.push({
            id: parseInt(cb.dataset.id),
            name: cb.dataset.name,
            price: parseFloat(cb.dataset.price)
        });
    });

    document.querySelectorAll('input[type="radio"]:checked').forEach(rb => {
        addons.push({
            id: parseInt(rb.dataset.id),
            name: rb.dataset.name,
            price: parseFloat(rb.dataset.price)
        });
    });

    return addons;
}

function updateTotal() {
    const addons = getSelectedAddons();
    const addonsTotal = addons.reduce((sum, a) => sum + a.price, 0);
    const total = (itemBasePrice + addonsTotal) * quantity;
    document.getElementById('itemTotal').textContent = 'RM ' + total.toFixed(2);
}

function addItemToCart() {
    const addons = getSelectedAddons();
    const addonsTotal = addons.reduce((sum, a) => sum + a.price, 0);
    const pricePerItem = itemBasePrice + addonsTotal;

    const item = {
        id: itemId,
        name: itemName,
        price: parseFloat(pricePerItem.toFixed(2)),
        quantity: quantity,
        addons: addons
    };

    window.cartManager.addItem(item);

    const btn = document.querySelector('.btn-add-cart');
    btn.classList.add('added');
    btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg> Added!';
    setTimeout(() => {
        btn.classList.remove('added');
        btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg> Add to Cart';
    }, 1500);
}
</script>
@endpush
