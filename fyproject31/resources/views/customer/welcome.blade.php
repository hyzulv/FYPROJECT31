@extends('layouts.customer')

@section('title', 'Welcome - MAT ROCK Restaurant')

@section('content')
<div class="homepage-container">
    <div class="hero-section">
        <div class="glass-overlay">
            <div class="logo-section">
                <div class="logo-icon">
                    <img src="{{ asset('restaurant-icon.png') }}" alt="MAT ROCK">
                </div>
                <h1 class="restaurant-name">MAT ROCK</h1>
                <p class="restaurant-tagline">Ayam Goreng Kunyit Skudai</p>
            </div>

            <div class="welcome-text">
                <h2>Welcome to Our Restaurant</h2>
                <p>Experience authentic Malaysian flavors with our signature dishes</p>
            </div>

            <div class="qr-section">
                <div class="qr-card">
                    <div class="qr-icon">
                        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="40" cy="40" r="30" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.05)"/>
                            <path d="M28 40h24M40 28v24" stroke="#d1986a" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h3>Ready to Order?</h3>
                    <p>Explore our delicious menu and place your order directly from your phone</p>
                    <a href="{{ route('customer.menu') }}" class="btn-primary">
                        Browse Menu
                        <svg class="btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="features-section">
        <div class="feature-card">
            <div class="feature-icon">
                <svg viewBox="0 0 48 48" fill="none" stroke="#d1986a" stroke-width="2">
                    <circle cx="24" cy="24" r="20"/>
                    <path d="M24 14v10l7 7"/>
                </svg>
            </div>
            <h4>Quick Service</h4>
            <p>Fresh food prepared fast</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <svg viewBox="0 0 48 48" fill="none" stroke="#d1986a" stroke-width="2">
                    <path d="M24 4l6 12h14l-11 8 4 14-13-9-13 9 4-14L4 16h14z"/>
                </svg>
            </div>
            <h4>Premium Quality</h4>
            <p>Authentic Malaysian flavors</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <svg viewBox="0 0 48 48" fill="none" stroke="#d1986a" stroke-width="2">
                    <path d="M24 44c11 0 20-9 20-20S35 4 24 4 4 13 4 24s9 20 20 20z"/>
                    <path d="M16 24l6 6 12-12"/>
                </svg>
            </div>
            <h4>Easy Ordering</h4>
            <p>Order directly from your phone</p>
        </div>
    </div>

    <div class="footer-section">
        <p>&copy; 2026 MAT ROCK Restaurant. All rights reserved.</p>
        <p class="footer-location">Skudai, Johor Bahru</p>
    </div>
</div>
@endsection
