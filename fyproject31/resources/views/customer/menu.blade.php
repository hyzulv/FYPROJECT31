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

    <div class="category-filter" id="categoryFilter">
        <button class="category-btn active" data-category="all">All</button>
        @foreach($categories as $catKey)
            @if(isset($categoryLabels[$catKey]))
                <a href="#{{ $catKey }}" class="category-btn" data-category="{{ $catKey }}">{{ $categoryLabels[$catKey] }}</a>
            @endif
        @endforeach
    </div>

    <div class="menu-content" id="menuContent" style="scroll-padding-top: 60px;">
        @foreach($categories as $catKey)
            @if(isset($categoryLabels[$catKey]) && $menuItems->has($catKey))
            <div class="menu-section" data-category="{{ $catKey }}" id="{{ $catKey }}">
                <h2 class="menu-section-title">{{ $categoryLabels[$catKey] }}</h2>
                <div class="menu-grid">
                    @foreach($menuItems[$catKey] as $item)
                    <div class="menu-item-card">
                        <a href="{{ route('customer.item.detail', $item['id']) }}" class="menu-item-image-link">
                            <div class="menu-item-image">
                                @if($item['image'])
                                    <img src="{{ asset('images/menu/' . $item['image']) }}" alt="{{ $item['name'] }}" loading="lazy">
                                @else
                                    <div class="placeholder-image">
                                        @if(in_array($catKey, ['ala_carte', 'combo_set', 'mix', 'nasi_lemak', 'kicap', 'set_family']))
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
                        </a>
                        <div class="menu-item-info">
                            <a href="{{ route('customer.item.detail', $item['id']) }}" class="menu-item-name-link">{{ $item['name'] }}</a>
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
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
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

    var filter = document.getElementById('categoryFilter');
    var menuContent = document.getElementById('menuContent');

    filter.addEventListener('click', function(e) {
        var btn = e.target.closest('.category-btn');
        if (!btn) return;

        var cat = btn.getAttribute('data-category');

        if (cat === 'all') {
            e.preventDefault();
            menuContent.scrollTo({ top: 0, behavior: 'smooth' });
            filter.querySelectorAll('.category-btn').forEach(function(b) {
                b.classList.remove('active');
            });
            btn.classList.add('active');
        }
    });

    var sections = menuContent.querySelectorAll('.menu-section');
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var cat = entry.target.getAttribute('data-category');
                filter.querySelectorAll('.category-btn').forEach(function(b) {
                    b.classList.toggle('active', b.getAttribute('data-category') === cat);
                });
            }
        });
    }, { root: menuContent, rootMargin: '-10% 0px -70% 0px', threshold: 0 });

    sections.forEach(function(section) {
        observer.observe(section);
    });
});

function addToCart(btn) {
    var item = {
        id: parseInt(btn.getAttribute('data-id')),
        name: btn.getAttribute('data-name'),
        price: parseFloat(btn.getAttribute('data-price')),
        quantity: 1
    };
    window.cartManager.addItem(item);
    btn.classList.add('added');
    setTimeout(function() { btn.classList.remove('added'); }, 600);
}
</script>
@endpush
