<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    # Bootstrap CSS and Google Fonts AAAAA
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFFFFF;
            color: #222222;
        }
        nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
        }
        .nav-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px 28px;
            margin: 0 8px;
            border: none;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1rem;
            color: #222222;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            background: linear-gradient(145deg, #f5f5f5, #e8e8e8);
            box-shadow: 0 4px 15px rgba(0,0,0,0.08), inset 0 1px 0 rgba(255,255,255,0.8);
        }
        .nav-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            padding: 2px;
            background: linear-gradient(135deg, #420C09, #300806, #420C09);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
        .nav-btn .nav-icon {
            font-size: 1.4rem;
            line-height: 1;
        }
        .nav-btn:hover {
            transform: translateY(-5px) scale(1.03);
            background: linear-gradient(145deg, #ffffff, #f0f0f0);
            box-shadow: 0 12px 35px rgba(66, 12, 9, 0.25), inset 0 1px 0 rgba(255,255,255,0.8);
        }
        .nav-btn:active {
            transform: translateY(0) scale(0.98);
        }
        @media (max-width: 768px) {
            .nav-btn {
                padding: 12px 20px;
                font-size: 0.85rem;
                margin: 4px;
                border-radius: 12px;
            }
            .nav-btn .nav-icon {
                font-size: 1.1rem;
            }
        }
        header {
            background-color: #420C09; /* Red header */
            padding: 20px 0;
            position: relative;
        }
        .auth-button {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #FFFFFF;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }
        .auth-button:hover {
            color: #FFDDDD;
            text-decoration: underline;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }
        .logo h1 {
            color: #FFFFFF;
            margin: 10px 0;
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            text-transform: uppercase;
        }
        .content {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #FFFFFF;
            border-radius: 8px;
        }
        .section {
            display: none;
        }
        h1 {
            color: #420C09; /* Red headings */
        }
        p {
            color: #333333;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .menu-item {
            background-color: #fafafa;
            border: 2px solid #420C09;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .menu-item:hover {
            transform: scale(1.05);
            background-color: #f0f0f0;
        }
        .menu-item img,
        .menu-item > div:first-child {
            width: 100%;
            height: 150px;
            border-radius: 5px;
            margin-bottom: 10px;
            flex-shrink: 0;
        }
        .menu-item h3 {
            color: #420C09;
            margin: 10px 0 5px 0;
            flex-shrink: 0;
        }
        .menu-item p {
            font-size: 14px;
            color: #555555;
            margin: 5px 0;
            flex-shrink: 0;
        }
        .menu-item .menu-desc {
            flex-grow: 1;
        }
        .menu-category {
            margin-top: 30px;
        }
        .menu-category h3 {
            color: #420C09;
            border-bottom: 2px solid #420C09;
            padding-bottom: 10px;
        }
        .contact-container {
            max-width: 700px;
            margin: 20px auto;
            background-color: #fafafa;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #420C09;
        }
        .contact-info {
            color: #333333;
            margin-bottom: 20px;
        }
        .contact-info p {
            margin: 10px 0;
        }
        .contact-info a {
            color: #420C09;
            text-decoration: none;
        }
        .contact-info a:hover {
            text-decoration: underline;
        }
        .contact-link {
            color: #420C09 !important;
            text-decoration: none !important;
        }
        .contact-link:hover {
            text-decoration: underline !important;
        }
        .branch {
            margin-bottom: 20px;
        }
        .branch p {
            margin: 5px 0;
            line-height: 1.6;
        }
        .branch-phone {
            color: #420C09;
            font-weight: bold;
            margin-top: 8px !important;
        }
        .branch-divider {
            height: 1px;
            background: rgba(66, 12, 9, 0.3);
            margin: 20px 0;
        }
        .contact-form label {
            display: block;
            color: #420C09;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #FFFFFF;
            border: 1px solid #420C09;
            color: #222222;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .contact-form input::placeholder,
        .contact-form textarea::placeholder {
            color: #AAAAAA;
        }
        .contact-form button {
            background-color: #420C09;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            width: 100%;
        }
        .contact-form button:hover {
            background-color: #300806;
        }
        .contact-alert {
            padding: 12px; border-radius: 5px; margin-bottom: 15px; text-align: center;
        }
        .about-container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #fafafa;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #420C09;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: center;
        }
        .about-image {
            text-align: center;
        }
        .about-image img,
        .about-image svg {
            width: 250px;
            height: 250px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #420C09;
        }
        .about-text h3 {
            color: #420C09;
            margin-top: 0;
        }
        .about-text p {
            color: #333333;
            line-height: 1.6;
            margin: 10px 0;
        }
        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: center;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
            border: 2px solid #420C09;
            margin-bottom: 20px;
        }
        .hero-img {
            width: 100%;
            border-radius: 8px;
            object-fit: cover;
            max-height: 420px;
            border: 2px solid #420C09;
        }
        .hero-text h2 {
            color: #420C09;
            margin-top: 0;
            font-size: 2.2rem;
        }
        .hero-text p {
            color: #555555;
            line-height: 1.7;
            margin: 20px 0;
        }
        .hero-button {
            display: inline-block;
            background-color: #420C09;
            color: #FFFFFF;
            padding: 12px 26px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
        .hero-button:hover {
            background-color: #300806;
        }
        .site-footer {
            background-color: #420C09;
            color: #FFFFFF;
            padding: 40px 20px 20px;
            margin-top: 40px;
        }
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        .footer-col h4 {
            color: #FFFFFF;
            font-size: 1.1rem;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .footer-col p,
        .footer-col a {
            color: #CCCCCC;
            font-size: 0.9rem;
            line-height: 1.8;
            text-decoration: none;
            display: block;
        }
        .footer-col a:hover {
            color: #FFFFFF;
        }
        .footer-social {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }
        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255,255,255,0.1);
            border-radius: 50%;
            color: #FFFFFF;
            font-size: 1.2rem;
            transition: background 0.3s;
            text-decoration: none;
        }
        .footer-social a:hover {
            background-color: rgba(255,255,255,0.25);
        }
        .footer-bottom {
            max-width: 1200px;
            margin: 30px auto 0;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.15);
            text-align: center;
            font-size: 0.85rem;
            color: #999999;
        }
        .order-table {
            width: 100%;
            border-collapse: collapse;
            background: #fafafa;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #420C09;
        }
        .order-table th {
            background: #420C09;
            color: white;
            padding: 14px 12px;
            text-align: left;
            font-size: 0.95rem;
        }
        .order-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #e0d6d5;
            color: #333;
            font-size: 0.9rem;
        }
        .order-table tr:last-child td {
            border-bottom: none;
        }
        .order-table tr:hover {
            background: #f0e8e7;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            color: white;
        }
        .status-pending { background: #f39c12; }
        .status-preparing { background: #3498db; }
        .status-ready { background: #27ae60; }
        .remove-btn {
            background: none;
            border: 1px solid #dc3545;
            color: #dc3545;
            padding: 5px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.2s;
        }
        .remove-btn:hover {
            background: #dc3545;
            color: white;
        }
        @media (max-width: 768px) {
            .auth-button {
                position: static;
                display: block;
                text-align: center;
                margin-bottom: 15px;
            }
            .hero {
                grid-template-columns: 1fr;
            }
            .about-container {
                grid-template-columns: 1fr;
            }
            .footer-container {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .footer-social {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header>
<a href="/login" class="auth-button">Staff / Admin Login</a>
        <div class="logo">
            <img src="{{ asset('images/brand/logo.jpg') }}" alt="MAT ROCK">
            <h1>MAT ROCK RESTAURANT ORDERING SYSTEM</h1>
        </div>
        <nav class="flex-wrap px-2" style="gap: 12px;">
            <button class="nav-btn" onclick="showSection('qr')"><span class="nav-icon">🛒</span> Order Now</button>
            <button class="nav-btn" onclick="showSection('order-status')"><span class="nav-icon">📋</span> Order Status</button>
            <button class="nav-btn" onclick="showSection('menu')"><span class="nav-icon">🍽️</span> Menu</button>
            <button class="nav-btn" onclick="showSection('about')"><span class="nav-icon">ℹ️</span> About Us</button>
            <button class="nav-btn" onclick="showSection('contact')"><span class="nav-icon">📞</span> Contact Us</button>
            <button class="nav-btn" onclick="showSection('feedback')"><span class="nav-icon">💬</span> Feedback</button>
        </nav>
    </header>
    <div class="content">
        <section id="about" class="section">
            <div class="about-container">
                <div class="about-image">
                    <img src="{{ asset('images/menu/ayam-goreng-kunyit.jpg') }}" alt="Ayam Goreng Kunyit" style="width:250px;height:250px;object-fit:cover;border-radius:50%;border:2px solid #420C09;">
                </div>
                <div class="about-text">
                    <h3>About Mat Rock</h3>
                    <p>Mat Rock Ayam Goreng Kunyit Skudai is a local favourite in Skudai, Johor Bahru, known for serving comforting Malaysian meals at affordable prices.</p>
                    <p>Our signature turmeric fried chicken is served with fragrant rice and spicy sambal, giving you a delicious taste of home-style dining.</p>
                    <p>We pride ourselves on friendly service, a warm atmosphere, and dishes that keep customers coming back again and again.</p>
                </div>
            </div>

        </section>
        <section id="qr" class="section">
            <div style="text-align:center; margin-bottom: 20px;">
                <img src="{{ asset('images/menu/QR.png') }}" alt="MAT ROCK" style="max-width:300px;width:100%;border-radius:8px;border:2px solid #420C09;">
            </div>
            <p style="text-align:center; margin-bottom: 16px;">Tap the button below to view our menu and place your order.</p>
            <p style="text-align:center;">
                <a href="{{ route('customer.welcome') }}" class="hero-button">Open Customer Menu Page</a>
            </p>
        </section>
        <section id="order-status" class="section">
            <h2>Order Status</h2>
            <p>Real-time view of all recent orders.</p>
            <div id="order-status-container" style="max-width: 900px; margin: 20px auto;">
                <div id="order-status-scroll" style="max-height: 500px; overflow-y: auto; padding-right: 5px;">
                    <p style="text-align: center; color: #666; padding: 20px;">Loading orders...</p>
                </div>
            </div>
        </section>
        <section id="menu" class="section">
            <h2>Food/Drink Menu</h2>
            <p>Check out our delicious food and drinks.</p>
            
            <div class="menu-category">
                <h3>Foods</h3>
                <div class="menu-grid">
                    @foreach($foods as $food)
                    @php $foodImg = \App\Helpers\MenuImageHelper::getImageFilename($food->name); @endphp
                    <div class="menu-item">
                        @if($foodImg)
                            <img src="{{ asset('images/menu/' . $foodImg) }}" alt="{{ $food->name }}" style="width:100%;height:150px;border-radius:5px;object-fit:cover;margin-bottom:10px;">
                        @elseif($food->image)
                            <img src="{{ asset('images/menu/' . $food->image) }}" alt="{{ $food->name }}" style="width:100%;height:150px;border-radius:5px;object-fit:cover;margin-bottom:10px;">
                        @else
                            <img src="{{ asset('images/menu/ayam-goreng-kunyit.jpg') }}" alt="Food" style="width:100%;height:150px;border-radius:5px;object-fit:cover;margin-bottom:10px;">
                        @endif
                        <h3>{{ $food->name }}</h3>
                        <p class="menu-desc">{{ $food->description }}</p>
                        <p><strong>Price: RM {{ number_format($food->price, 2) }}</strong></p>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="menu-category">
                <h3>Drinks</h3>
                <div class="menu-grid">
                    @foreach($drinks as $drink)
                    @php $drinkImg = \App\Helpers\MenuImageHelper::getImageFilename($drink->name); @endphp
                    <div class="menu-item">
                        @if($drinkImg)
                            <img src="{{ asset('images/menu/' . $drinkImg) }}" alt="{{ $drink->name }}" style="width:100%;height:150px;border-radius:5px;object-fit:cover;margin-bottom:10px;">
                        @elseif($drink->image)
                            <img src="{{ asset('images/menu/' . $drink->image) }}" alt="{{ $drink->name }}" style="width:100%;height:150px;border-radius:5px;object-fit:cover;margin-bottom:10px;">
                        @else
                            <img src="{{ asset('images/menu/ayam-goreng-kunyit.jpg') }}" alt="Drink" style="width:100%;height:150px;border-radius:5px;object-fit:cover;margin-bottom:10px;">
                        @endif
                        <h3>{{ $drink->name }}</h3>
                        <p class="menu-desc">{{ $drink->description }}</p>
                        <p><strong>Price: RM {{ number_format($drink->price, 2) }}</strong></p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section id="contact" class="section">
            <h2>Contact Us</h2>

            @if(session('contact_success'))
            <div style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #28a745; padding: 12px; border-radius: 5px; margin-bottom: 15px; text-align: center;">{{ session('contact_success') }}</div>
            @endif
            @if(session('contact_error'))
            <div style="background: rgba(220, 53, 69, 0.2); border: 1px solid #dc3545; color: #dc3545; padding: 12px; border-radius: 5px; margin-bottom: 15px; text-align: center;">{{ session('contact_error') }}</div>
            @endif

            <div class="contact-container">
                <div class="contact-info">
                    <div class="branch">
                        <h3 style="color: #420C09; margin-bottom: 5px;">Kuala Lumpur - Kampung Pandan</h3>
                        <p>No. 15, Jalan Kampung Pandan,<br>Maluri, 55100 Kuala Lumpur</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Kampung+Pandan+Kuala+Lumpur" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #420C09; margin-bottom: 5px;">Kuala Lumpur - Cheras</h3>
                        <p>7, Jalan Dwitasik, Dataran Dwitasik,<br>56000 Kuala Lumpur</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Cheras+Kuala+Lumpur" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #420C09; margin-bottom: 5px;">Selangor - Kota Damansara</h3>
                        <p>9-1, Jalan PJU 5/12, Dataran Sunway,<br>47810 Petaling Jaya, Selangor</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Kota+Damansara+Selangor" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #420C09; margin-bottom: 5px;">Selangor - Shah Alam</h3>
                        <p>15, Jalan Plumbum R7/R, Seksyen 7,<br>40000 Shah Alam, Selangor</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Shah+Alam+Seksyen+7" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #420C09; margin-bottom: 5px;">Selangor - Klang</h3>
                        <p>No. 52A, Lorong Batu Nilam 1B,<br>Bandar Bukit Tinggi 1, 41200 Klang, Selangor</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Klang+Selangor" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #420C09; margin-bottom: 5px;">Selangor - Cyberjaya</h3>
                        <p>Unit C-01, Container Avenue, Block 3513,<br>Jalan Teknokrat 5, 63000 Cyberjaya, Selangor</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Cyberjaya+Selangor" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #420C09; margin-bottom: 5px;">Perak - Ipoh</h3>
                        <p>54, Regat Sri Cempaka, Taman Cempaka,<br>31400 Ipoh, Perak</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Ipoh+Perak" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #420C09; margin-bottom: 5px;">Pahang - Gambang</h3>
                        <p>A11, Jalan Bandar Gambang 1,<br>Bandar Gambang, 26300 Gambang, Pahang</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Gambang+Pahang" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #420C09; margin-bottom: 5px;">Terengganu - Kemaman</h3>
                        <p>Jalan Chukai Utama, Kampung Pengkalan Pandan,<br>24000 Chukai, Terengganu</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Kemaman+Terengganu" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #420C09; margin-bottom: 5px;">Johor - Skudai</h3>
                        <p>No. 22, Jalan Impian Emas 1, Taman Impian Emas,<br>Skudai, 81300 Johor Bahru, Johor</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Skudai+Johor" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <p style="margin-top: 15px;"><strong>WhatsApp:</strong> <a href="https://wa.me/60166607314" target="_blank" class="contact-link">+60 16-660 7314</a></p>
                    <p><strong>Email:</strong> <a href="mailto:fypkumpulan31@gmail.com" class="contact-link">fypkumpulan31@gmail.com</a></p>
                </div>
                <form class="contact-form" method="POST" action="{{ route('contact.send') }}">
                    @csrf
                    <label>Name:</label>
                    <input type="text" name="name" placeholder="Your Name" required>

                    <label>Email:</label>
                    <input type="email" name="email" placeholder="Your Email" required>

                    <label>Message:</label>
                    <textarea name="message" rows="5" placeholder="Your Message" required></textarea>

                    <button type="submit">Send Message</button>
                </form>
            </div>
        </section>
        <section id="feedback" class="section">
            <h2>Feedback</h2>

            @if(session('feedback_success'))
            <div style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #28a745; padding: 12px; border-radius: 5px; margin-bottom: 15px; text-align: center;">{{ session('feedback_success') }}</div>
            @endif
            @if(session('feedback_error'))
            <div style="background: rgba(220, 53, 69, 0.2); border: 1px solid #dc3545; color: #dc3545; padding: 12px; border-radius: 5px; margin-bottom: 15px; text-align: center;">{{ session('feedback_error') }}</div>
            @endif

            <div style="max-width: 700px; margin: 20px auto; background-color: #fafafa; padding: 20px; border-radius: 8px; border: 2px solid #420C09;">
                <form method="POST" action="{{ route('feedback.send') }}">
                    @csrf
                    <label style="display: block; color: #420C09; margin-top: 15px; margin-bottom: 5px; font-weight: bold;">Name:</label>
                    <input type="text" name="customer_name" placeholder="Your Name" required style="width: 100%; padding: 10px; margin-bottom: 15px; background-color: #FFFFFF; border: 1px solid #420C09; color: #222222; border-radius: 5px; box-sizing: border-box;">

                    <label style="display: block; color: #420C09; margin-top: 15px; margin-bottom: 5px; font-weight: bold;">Rating:</label>
                    <div class="star-rating" style="margin-bottom: 15px; font-size: 2rem; cursor: pointer;">
                        <span class="star" data-value="1" style="color: #ddd;">&#9733;</span>
                        <span class="star" data-value="2" style="color: #ddd;">&#9733;</span>
                        <span class="star" data-value="3" style="color: #ddd;">&#9733;</span>
                        <span class="star" data-value="4" style="color: #ddd;">&#9733;</span>
                        <span class="star" data-value="5" style="color: #ddd;">&#9733;</span>
                        <input type="hidden" name="rating" id="rating-value" value="0">
                    </div>

                    <label style="display: block; color: #420C09; margin-top: 15px; margin-bottom: 5px; font-weight: bold;">Message:</label>
                    <textarea name="message" rows="5" placeholder="Share your feedback..." required style="width: 100%; padding: 10px; margin-bottom: 15px; background-color: #FFFFFF; border: 1px solid #420C09; color: #222222; border-radius: 5px; box-sizing: border-box;"></textarea>

                    <button type="submit" style="background-color: #420C09; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 16px; width: 100%;">Submit Feedback</button>
                </form>
            </div>

            @if(isset($feedbacks) && count($feedbacks) > 0)
            <div style="max-width: 700px; margin: 30px auto;">
                <h3 style="color: #420C09; margin-bottom: 20px;">Recent Feedback</h3>
                <div style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                @foreach($feedbacks as $fb)
                @php $isOwner = in_array($fb->id, $ownedFeedbackIds); @endphp
                <div id="fb-card-{{ $fb->id }}" style="background-color: #fafafa; border: 1px solid #420C09; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <strong style="color: #420C09;">{{ $fb->customer_name }}</strong>
                        <span style="color: #FFD700;">{!! str_repeat('&#9733;', $fb->rating) !!}{!! str_repeat('&#9734;', 5 - $fb->rating) !!}</span>
                    </div>
                    <p style="color: #333333; margin: 0;">{{ $fb->message }}</p>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                        <span style="color: #666; font-size: 0.85rem;">{{ $fb->feedback_date->format('F j, Y') }}</span>
                        @if($isOwner)
                        <div style="display: flex; gap: 8px;">
                            <button onclick="showEditForm({{ $fb->id }})" style="background: none; border: 1px solid #420C09; color: #420C09; padding: 4px 12px; border-radius: 4px; cursor: pointer; font-size: 0.8rem;">Edit</button>
                            <button onclick="confirmDelete({{ $fb->id }})" style="background: none; border: 1px solid #dc3545; color: #dc3545; padding: 4px 12px; border-radius: 4px; cursor: pointer; font-size: 0.8rem;">Delete</button>
                        </div>
                        @endif
                    </div>
                </div>

                @if($isOwner)
                <div id="fb-edit-{{ $fb->id }}" style="display: none; max-width: 700px; margin-bottom: 15px; background-color: #fafafa; padding: 20px; border-radius: 8px; border: 2px solid #420C09;">
                    <form method="POST" action="{{ route('feedback.update', $fb->id) }}">
                        @csrf
                        @method('PUT')
                        <label style="display: block; color: #420C09; margin-top: 10px; margin-bottom: 5px; font-weight: bold;">Name:</label>
                        <input type="text" name="customer_name" value="{{ $fb->customer_name }}" required style="width: 100%; padding: 10px; margin-bottom: 12px; background-color: #FFFFFF; border: 1px solid #420C09; color: #222222; border-radius: 5px; box-sizing: border-box;">

                        <label style="display: block; color: #420C09; margin-top: 10px; margin-bottom: 5px; font-weight: bold;">Rating:</label>
                        <div class="edit-star-rating" data-fb-id="{{ $fb->id }}" style="margin-bottom: 12px; font-size: 2rem; cursor: pointer;">
                            @for($s = 1; $s <= 5; $s++)
                            <span class="estar" data-fb-id="{{ $fb->id }}" data-value="{{ $s }}" style="color: {{ $s <= $fb->rating ? '#FFD700' : '#ddd' }};">&#9733;</span>
                            @endfor
                            <input type="hidden" name="rating" id="edit-rating-{{ $fb->id }}" value="{{ $fb->rating }}">
                        </div>

                        <label style="display: block; color: #420C09; margin-top: 10px; margin-bottom: 5px; font-weight: bold;">Message:</label>
                        <textarea name="message" rows="5" required style="width: 100%; padding: 10px; margin-bottom: 12px; background-color: #FFFFFF; border: 1px solid #420C09; color: #222222; border-radius: 5px; box-sizing: border-box;">{{ $fb->message }}</textarea>

                        <div style="display: flex; gap: 10px;">
                            <button type="submit" style="background-color: #420C09; color: white; padding: 10px 24px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Save</button>
                            <button type="button" onclick="hideEditForm({{ $fb->id }})" style="background: #eee; color: #555; padding: 10px 24px; border: 1px solid #ccc; border-radius: 5px; cursor: pointer; font-weight: bold;">Cancel</button>
                        </div>
                    </form>
                </div>

                <div id="fb-delete-{{ $fb->id }}" style="display: none; max-width: 700px; margin-bottom: 15px; background-color: #fff3f3; padding: 20px; border-radius: 8px; border: 2px solid #dc3545;">
                    <p style="color: #dc3545; font-weight: bold; margin: 0 0 10px 0;">Delete this feedback?</p>
                    <form method="POST" action="{{ route('feedback.delete', $fb->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background-color: #dc3545; color: white; padding: 8px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Yes, Delete</button>
                        <button type="button" onclick="hideDeleteForm({{ $fb->id }})" style="background: #eee; color: #555; padding: 8px 20px; border: 1px solid #ccc; border-radius: 5px; cursor: pointer; font-weight: bold;">Cancel</button>
                    </form>
                </div>
                @endif
                @endforeach
                </div>
            </div>
            @endif
        </section>
    </div>
    <script>
        function showSection(sectionId) {
            // Hide all sections
            var sections = document.querySelectorAll('.section');
            sections.forEach(function(section) {
                section.style.display = 'none';
            });
            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';
        }

        // Edit / Delete toggle functions
        function showEditForm(id) {
            document.getElementById('fb-card-' + id).style.display = 'none';
            document.getElementById('fb-edit-' + id).style.display = 'block';
        }
        function hideEditForm(id) {
            document.getElementById('fb-card-' + id).style.display = 'block';
            document.getElementById('fb-edit-' + id).style.display = 'none';
        }
        function confirmDelete(id) {
            document.getElementById('fb-card-' + id).style.display = 'none';
            document.getElementById('fb-delete-' + id).style.display = 'block';
        }
        function hideDeleteForm(id) {
            document.getElementById('fb-card-' + id).style.display = 'block';
            document.getElementById('fb-delete-' + id).style.display = 'none';
        }

        // Edit form star rating interaction
        document.querySelectorAll('.edit-star-rating .estar').forEach(function(star) {
            star.addEventListener('click', function() {
                var fbId = this.getAttribute('data-fb-id');
                var value = this.getAttribute('data-value');
                document.getElementById('edit-rating-' + fbId).value = value;
                document.querySelectorAll('.edit-star-rating[data-fb-id="' + fbId + '"] .estar').forEach(function(s) {
                    s.style.color = s.getAttribute('data-value') <= value ? '#FFD700' : '#ddd';
                });
            });
            star.addEventListener('mouseenter', function() {
                var fbId = this.getAttribute('data-fb-id');
                var value = this.getAttribute('data-value');
                document.querySelectorAll('.edit-star-rating[data-fb-id="' + fbId + '"] .estar').forEach(function(s) {
                    s.style.color = s.getAttribute('data-value') <= value ? '#FFD700' : '#ddd';
                });
            });
            star.addEventListener('mouseleave', function() {
                var fbId = this.getAttribute('data-fb-id');
                var selected = document.getElementById('edit-rating-' + fbId).value;
                document.querySelectorAll('.edit-star-rating[data-fb-id="' + fbId + '"] .estar').forEach(function(s) {
                    s.style.color = s.getAttribute('data-value') <= selected ? '#FFD700' : '#ddd';
                });
            });
        });

        // Star rating interaction
        document.querySelectorAll('.star-rating .star').forEach(function(star) {
            star.addEventListener('click', function() {
                var value = this.getAttribute('data-value');
                document.getElementById('rating-value').value = value;
                document.querySelectorAll('.star-rating .star').forEach(function(s) {
                    s.style.color = s.getAttribute('data-value') <= value ? '#FFD700' : '#ddd';
                });
            });
            star.addEventListener('mouseenter', function() {
                var value = this.getAttribute('data-value');
                document.querySelectorAll('.star-rating .star').forEach(function(s) {
                    s.style.color = s.getAttribute('data-value') <= value ? '#FFD700' : '#ddd';
                });
            });
            star.addEventListener('mouseleave', function() {
                var selected = document.getElementById('rating-value').value;
                document.querySelectorAll('.star-rating .star').forEach(function(s) {
                    s.style.color = s.getAttribute('data-value') <= selected ? '#FFD700' : '#ddd';
                });
            });
        });

        // Show Contact section if success/error message exists, else show Feedback, else show About
        window.onload = function() {
            var contactSection = document.getElementById('contact');
            var feedbackSection = document.getElementById('feedback');
            var hasContactAlert = contactSection && contactSection.querySelector('div[style*="rgba(40, 167, 69"], div[style*="rgba(220, 53, 69"]');
            var hasFeedbackAlert = feedbackSection && feedbackSection.querySelector('div[style*="rgba(40, 167, 69"], div[style*="rgba(220, 53, 69"]');
            if (hasContactAlert) {
                showSection('contact');
            } else if (hasFeedbackAlert) {
                showSection('feedback');
            } else {
                showSection('about');
            }
        };

        // Equalize menu item heights
        function equalizeMenuHeights() {
            var grids = document.querySelectorAll('.menu-grid');
            grids.forEach(function(grid) {
                var items = grid.querySelectorAll('.menu-item');
                var maxHeight = 0;
                items.forEach(function(item) {
                    item.style.height = 'auto';
                    var h = item.offsetHeight;
                    if (h > maxHeight) maxHeight = h;
                });
                if (maxHeight > 0) {
                    items.forEach(function(item) {
                        item.style.height = maxHeight + 'px';
                    });
                }
            });
        }

        // Run on load and on resize
        window.addEventListener('load', equalizeMenuHeights);
        window.addEventListener('resize', equalizeMenuHeights);

        // Order Status - Live all orders feed
        function renderOrders(orders) {
            var scrollDiv = document.getElementById('order-status-scroll');
            if (!scrollDiv) return;

            if (!orders || orders.length === 0) {
                scrollDiv.innerHTML = '<p style="text-align: center; color: #666; padding: 20px;">No orders yet.</p>';
                return;
            }

            var html = '<table class="order-table"><thead><tr>';
            html += '<th>Order ID</th><th>Items</th><th>Status</th><th>Time</th>';
            html += '</tr></thead><tbody>';

            orders.forEach(function(order) {
                var badgeClass = 'status-badge status-' + order.status;
                var statusLabel = order.status.charAt(0).toUpperCase() + order.status.slice(1);

                html += '<tr>';
                html += '<td><strong>' + order.id + '</strong></td>';
                html += '<td>' + order.items + '</td>';
                html += '<td><span class="' + badgeClass + '">' + statusLabel + '</span></td>';
                html += '<td>' + order.time + '</td>';
                html += '</tr>';
            });

            html += '</tbody></table>';
            scrollDiv.innerHTML = html;
        }

        function fetchOrders() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/api/orders/recent', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    renderOrders(data.orders);
                }
            };
            xhr.send();
        }

        // Auto-fetch on load and poll every 5 seconds
        window.addEventListener('load', function() {
            fetchOrders();
            setInterval(fetchOrders, 5000);
        });
    </script>
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-col">
                <h4>MAT ROCK</h4>
                <p>Mat Rock Ayam Goreng Kunyit Skudai is a local favourite in Skudai, Johor Bahru, known for serving comforting Malaysian meals at affordable prices.</p>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <p>Phone: +60 16-660 7314</p>
                <p>Email: fypkumpulan31@gmail.com</p>
                <p>WhatsApp: +60 16-660 7314</p>
            </div>
            <div class="footer-col">
                <h4>Follow Us</h4>
                <p>Stay connected on social media</p>
                <div class="footer-social">
                    <a href="https://www.facebook.com/matrocksunway" target="_blank" aria-label="Facebook">f</a>
                    <a href="https://www.instagram.com/officialmatrock?igsh=MWVibzR5NnlubmticQ%3D%3D" target="_blank" aria-label="Instagram"><img src="{{ asset('images/icons/ig-logo.png') }}" alt="Instagram" style="width:24px;height:24px;"></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Mat Rock Restaurant. All rights reserved.
        </div>
    </footer>
</body>
</html>