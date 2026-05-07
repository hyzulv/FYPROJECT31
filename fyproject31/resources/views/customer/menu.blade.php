@extends('layouts.customer')

@section('title', 'Menu - MAT ROCK Restaurant')

@section('content')
<div class="menu-container">
    <header class="menu-header">
        <button class="back-btn" onclick="window.history.back()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
        </button>
        <h1>Our Menu</h1>
        <button class="cart-btn" onclick="window.location.href='{{ route('customer.cart') }}'">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="9" cy="21" r="1"/>
                <circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
            </svg>
            <span class="cart-count" id="cartCount">0</span>
        </button>
    </header>

    <div class="category-filter">
        <button class="category-btn active" data-category="all">All</button>
        <button class="category-btn" data-category="food">Food</button>
        <button class="category-btn" data-category="drink">Drinks</button>
    </div>

    <div class="menu-grid" id="menuGrid">
        @forelse($menuItems as $item)
        <div class="menu-item-card" data-category="{{ $item['category'] }}">
            <div class="menu-item-image">
                @if($item['image'])
                    <img src="{{ asset('images/menu/' . $item['image']) }}" alt="{{ $item['name'] }}" loading="lazy">
                @else
                    <div class="placeholder-image">
                        @if($item['category'] === 'food')
                            <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <ellipse cx="40" cy="50" rx="28" ry="12" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/>
                                <path d="M25 45 Q40 20 55 45" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/>
                                <circle cx="40" cy="30" r="3" fill="#d1986a"/>
                            </svg>
                        @else
                            <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M30 20 L30 55 Q30 65 40 65 Q50 65 50 55 L50 20" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/>
                                <ellipse cx="40" cy="20" rx="10" ry="4" stroke="#d1986a" stroke-width="2"/>
                                <path d="M35 35 Q40 30 45 35" stroke="#d1986a" stroke-width="1.5" fill="none"/>
                            </svg>
                        @endif
                    </div>
                @endif
            </div>
            <div class="menu-item-info">
                <h3 class="menu-item-name">{{ $item['name'] }}</h3>
                <p class="menu-item-desc">{{ Str::limit($item['description'], 60) }}</p>
                <div class="menu-item-footer">
                    <span class="menu-item-price">RM {{ $item['price'] }}</span>
                    <button class="add-to-cart-btn" 
                            data-id="{{ $item['id'] }}" 
                            data-name="{{ $item['name'] }}" 
                            data-price="{{ $item['price'] }}"
                            onclick="addToCart(this)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Add
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-menu">
            <p>No menu items available</p>
        </div>
        @endforelse
    </div>

    <div class="floating-cart-btn" id="floatingCartBtn" onclick="window.location.href='{{ route('customer.cart') }}'">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="9" cy="21" r="1"/>
            <circle cx="20" cy="21" r="1"/>
            <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
        </svg>
        <span class="cart-badge" id="floatingCartCount">0</span>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    updateCartDisplay();

    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterMenu(this.dataset.category);
        });
    });
});

function filterMenu(category) {
    const items = document.querySelectorAll('.menu-item-card');
    items.forEach(item => {
        if (category === 'all' || item.dataset.category === category) {
            item.style.display = 'flex';
            item.style.animation = 'fadeIn 0.3s ease';
        } else {
            item.style.display = 'none';
        }
    });
}

function addToCart(btn) {
    const item = {
        id: parseInt(btn.dataset.id),
        name: btn.dataset.name,
        price: parseFloat(btn.dataset.price),
        quantity: 1
    };
    window.cartManager.addItem(item);
    btn.classList.add('added');
    setTimeout(() => btn.classList.remove('added'), 600);
}
</script>
@endpush
