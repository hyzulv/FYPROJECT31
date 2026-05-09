<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000000;
            color: #FFFFFF;
        }
        header {
            background-color: #d1986a;
            padding: 20px 0;
            position: relative;
        }
        .auth-button {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #222222;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }
        .auth-button:hover {
            color: #000000;
            text-decoration: underline;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 150px;
            height: 150px;
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
            color: #fff;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            background: linear-gradient(145deg, #2a2a2a, #1a1a1a);
            box-shadow: 0 4px 15px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.05);
        }
        .nav-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            padding: 2px;
            background: linear-gradient(135deg, #cf2c21, #a8231a, #cf2c21);
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
            background: linear-gradient(145deg, #333333, #222222);
            box-shadow: 0 12px 35px rgba(207, 44, 33, 0.35), inset 0 1px 0 rgba(255,255,255,0.1);
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
            background-color: #cf2c21; /* Red header */
            padding: 20px 0;
            position: relative;
        }
        .auth-button {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #222222;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }
        .auth-button:hover {
            color: #000000;
            text-decoration: underline;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 150px;
            height: 150px;
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
            background-color: #111111;
            border-radius: 8px;
        }
        .section {
            display: none;
        }
        h1 {
            color: #cf2c21; /* Red headings */
        }
        p {
            color: #FFFFFF;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .menu-item {
            background-color: #222222;
            border: 2px solid #cf2c21;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .menu-item:hover {
            transform: scale(1.05);
            background-color: #333333;
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
            color: #cf2c21;
            margin: 10px 0 5px 0;
            flex-shrink: 0;
        }
        .menu-item p {
            font-size: 14px;
            color: #CCCCCC;
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
            color: #cf2c21;
            border-bottom: 2px solid #cf2c21;
            padding-bottom: 10px;
        }
        .contact-container {
            max-width: 700px;
            margin: 20px auto;
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #cf2c21;
        }
        .contact-info {
            color: #FFFFFF;
            margin-bottom: 20px;
        }
        .contact-info p {
            margin: 10px 0;
        }
        .contact-info a {
            color: #cf2c21;
            text-decoration: none;
        }
        .contact-info a:hover {
            text-decoration: underline;
        }
        .contact-link {
            color: #cf2c21 !important;
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
            color: #cf2c21;
            font-weight: bold;
            margin-top: 8px !important;
        }
        .branch-divider {
            height: 1px;
            background: rgba(207, 44, 33, 0.3);
            margin: 20px 0;
        }
        .contact-form label {
            display: block;
            color: #cf2c21;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #333333;
            border: 1px solid #cf2c21;
            color: #FFFFFF;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .contact-form input::placeholder,
        .contact-form textarea::placeholder {
            color: #999999;
        }
        .contact-form button {
            background-color: #cf2c21;
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
            background-color: #a8231a;
        }
        .contact-alert {
            padding: 12px; border-radius: 5px; margin-bottom: 15px; text-align: center;
        }
        .about-container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #cf2c21;
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
            width: 100%;
            max-width: 300px;
            height: auto;
            border-radius: 8px;
            border: 2px solid #cf2c21;
        }
        .about-text h3 {
            color: #cf2c21;
            margin-top: 0;
        }
        .about-text p {
            color: #FFFFFF;
            line-height: 1.6;
            margin: 10px 0;
        }
        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: center;
            padding: 20px;
            background-color: #1a1a1a;
            border-radius: 8px;
            border: 2px solid #cf2c21;
            margin-bottom: 20px;
        }
        .hero-img {
            width: 100%;
            border-radius: 8px;
            object-fit: cover;
            max-height: 420px;
            border: 2px solid #cf2c21;
        }
        .hero-text h2 {
            color: #cf2c21;
            margin-top: 0;
            font-size: 2.2rem;
        }
        .hero-text p {
            color: #CCCCCC;
            line-height: 1.7;
            margin: 20px 0;
        }
        .hero-button {
            display: inline-block;
            background-color: #cf2c21;
            color: #FFFFFF;
            padding: 12px 26px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
        .hero-button:hover {
            background-color: #b8864e;
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
        }
    </style>
</head>
<body>
    <header>
<a href="/login" class="auth-button">Staff / Admin Login</a>
        <div class="logo">
            <img src="{{ asset('restaurant-icon.png') }}" alt="MAT ROCK">
            <h1>MAT ROCK RESTAURANT ORDERING SYSTEM</h1>
        </div>
        <nav class="flex-wrap px-2" style="gap: 12px;">
            <button class="nav-btn" onclick="showSection('qr')"><span class="nav-icon">🛒</span> Order Now</button>
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
                    <svg viewBox="0 0 300 300" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:300px;border-radius:8px;">
                        <rect width="300" height="300" fill="#1a1a1a"/>
                        <circle cx="150" cy="120" r="60" stroke="#cf2c21" stroke-width="2" fill="rgba(207,44,33,0.1)"/>
                        <path d="M110 140 Q150 80 190 140" stroke="#cf2c21" stroke-width="2" fill="none"/>
                        <circle cx="150" cy="105" r="5" fill="#cf2c21"/>
                        <text x="150" y="220" text-anchor="middle" fill="#cf2c21" font-size="24" font-weight="bold">MAT ROCK</text>
                        <text x="150" y="250" text-anchor="middle" fill="#999999" font-size="14">Ayam Goreng Kunyit</text>
                    </svg>
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
            <p style="text-align:center; margin-bottom: 16px;">Tap the link below to view our menu and place your order.</p>
            <p style="text-align:center;">
                <a href="{{ route('customer.welcome') }}" style="color:#cf2c21;font-weight:bold;font-size:18px;">Open Customer Menu Page</a>
            </p>
        </section>
        <section id="menu" class="section">
            <h2>Food/Drink Menu</h2>
            <p>Check out our delicious food and drinks.</p>
            
            <div class="menu-category">
                <h3>Foods</h3>
                <div class="menu-grid">
                    @foreach($foods as $food)
                    <div class="menu-item">
                        <div style="width:100%;height:150px;background:#333;border-radius:5px;display:flex;align-items:center;justify-content:center;">
                            <svg viewBox="0 0 60 60" width="50" height="50" fill="none"><ellipse cx="30" cy="40" rx="20" ry="8" stroke="#cf2c21" stroke-width="2"/><path d="M15 35 Q30 15 45 35" stroke="#cf2c21" stroke-width="2" fill="rgba(207,44,33,0.1)"/></svg>
                        </div>
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
                    <div class="menu-item">
                        <div style="width:100%;height:150px;background:#333;border-radius:5px;display:flex;align-items:center;justify-content:center;">
                            <svg viewBox="0 0 60 60" width="50" height="50" fill="none"><path d="M20 15 L20 45 Q20 50 30 50 Q40 50 40 45 L40 15" stroke="#cf2c21" stroke-width="2"/><ellipse cx="30" cy="15" rx="10" ry="4" stroke="#cf2c21" stroke-width="2"/></svg>
                        </div>
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
                        <h3 style="color: #cf2c21; margin-bottom: 5px;">Kuala Lumpur - Kampung Pandan</h3>
                        <p>No. 15, Jalan Kampung Pandan,<br>Maluri, 55100 Kuala Lumpur</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Kampung+Pandan+Kuala+Lumpur" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #cf2c21; margin-bottom: 5px;">Kuala Lumpur - Cheras</h3>
                        <p>7, Jalan Dwitasik, Dataran Dwitasik,<br>56000 Kuala Lumpur</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Cheras+Kuala+Lumpur" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #cf2c21; margin-bottom: 5px;">Selangor - Kota Damansara</h3>
                        <p>9-1, Jalan PJU 5/12, Dataran Sunway,<br>47810 Petaling Jaya, Selangor</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Kota+Damansara+Selangor" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #cf2c21; margin-bottom: 5px;">Selangor - Shah Alam</h3>
                        <p>15, Jalan Plumbum R7/R, Seksyen 7,<br>40000 Shah Alam, Selangor</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Shah+Alam+Seksyen+7" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #cf2c21; margin-bottom: 5px;">Selangor - Klang</h3>
                        <p>No. 52A, Lorong Batu Nilam 1B,<br>Bandar Bukit Tinggi 1, 41200 Klang, Selangor</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Klang+Selangor" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #cf2c21; margin-bottom: 5px;">Selangor - Cyberjaya</h3>
                        <p>Unit C-01, Container Avenue, Block 3513,<br>Jalan Teknokrat 5, 63000 Cyberjaya, Selangor</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Cyberjaya+Selangor" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #cf2c21; margin-bottom: 5px;">Perak - Ipoh</h3>
                        <p>54, Regat Sri Cempaka, Taman Cempaka,<br>31400 Ipoh, Perak</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Ipoh+Perak" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #cf2c21; margin-bottom: 5px;">Pahang - Gambang</h3>
                        <p>A11, Jalan Bandar Gambang 1,<br>Bandar Gambang, 26300 Gambang, Pahang</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Gambang+Pahang" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #cf2c21; margin-bottom: 5px;">Terengganu - Kemaman</h3>
                        <p>Jalan Chukai Utama, Kampung Pengkalan Pandan,<br>24000 Chukai, Terengganu</p>
                        <p><a href="https://maps.google.com/?q=Mat+Rock+Kemaman+Terengganu" target="_blank" class="contact-link">📍 Map and Driving Directions</a></p>
                        <p class="branch-phone">Phone: +60 16-660 7314</p>
                    </div>

                    <div class="branch-divider"></div>

                    <div class="branch">
                        <h3 style="color: #cf2c21; margin-bottom: 5px;">Johor - Skudai</h3>
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
            <p>Share your feedback.</p>
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

        // Show About section by default when page loads
        window.onload = function() {
            showSection('about');
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
    </script>
</body>
</html>