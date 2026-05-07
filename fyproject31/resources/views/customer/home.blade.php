@extends('layouts.customer')

@section('title', 'MAT ROCK Restaurant')

@section('content')
<div class="homepage-container">
    <div class="hero-section">
        <div class="glass-overlay">
            <div class="logo-section">
                <div class="logo-icon">
                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="45" stroke="#d1986a" stroke-width="3" fill="rgba(209,152,106,0.1)"/>
                        <path d="M30 60 Q50 25 70 60" stroke="#d1986a" stroke-width="3" fill="none" stroke-linecap="round"/>
                        <path d="M35 60 L65 60" stroke="#d1986a" stroke-width="2" stroke-linecap="round"/>
                        <path d="M40 65 L60 65" stroke="#d1986a" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="50" cy="38" r="3" fill="#d1986a"/>
                    </svg>
                </div>
                <h1 class="restaurant-name">MAT ROCK</h1>
                <p class="restaurant-tagline">Ayam Goreng Kunyit Skudai</p>
            </div>

            <div class="qr-section">
                <div class="qr-card">
                    <div class="qr-icon">
                        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="8" y="8" width="20" height="20" rx="2" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/>
                            <rect x="36" y="8" width="20" height="20" rx="2" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/>
                            <rect x="8" y="36" width="20" height="20" rx="2" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/>
                            <rect x="12" y="12" width="12" height="12" rx="1" fill="#d1986a"/>
                            <rect x="40" y="12" width="12" height="12" rx="1" fill="#d1986a"/>
                            <rect x="12" y="40" width="12" height="12" rx="1" fill="#d1986a"/>
                            <rect x="36" y="36" width="4" height="4" fill="#d1986a"/>
                            <rect x="44" y="36" width="4" height="4" fill="#d1986a"/>
                            <rect x="52" y="36" width="4" height="4" fill="#d1986a"/>
                            <rect x="36" y="44" width="4" height="4" fill="#d1986a"/>
                            <rect x="44" y="44" width="4" height="4" fill="#d1986a"/>
                            <rect x="52" y="44" width="4" height="4" fill="#d1986a"/>
                            <rect x="36" y="52" width="4" height="4" fill="#d1986a"/>
                            <rect x="52" y="52" width="4" height="4" fill="#d1986a"/>
                        </svg>
                    </div>
                    <a href="{{ route('customer.welcome') }}" class="btn-primary">
                        Open Menu
                        <svg class="btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 18l6-6-6-6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-section">
        <p>&copy; 2026 MAT ROCK Restaurant. All rights reserved.</p>
        <p class="footer-location">Skudai, Johor Bahru</p>
    </div>
</div>
@endsection
