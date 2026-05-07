<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Example (you can connect this to email or database)
    echo "<script>alert('Thank you, $name! Your message has been sent.');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000000; /* Black background */
            color: #FFFFFF; /* White text */
        }
        header {
            background-color: #d1986a; /* Gold header */
            padding: 20px 0;
            position: relative;
        }
        .auth-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #222222;
            color: #FFFFFF;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .auth-button:hover {
            background-color: #FFFFFF;
            color: #d1986a;
            border-color: #FFFFFF;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 100px;
            height: 100px;
        }
        .logo h1 {
            color: #FFFFFF;
            margin: 10px 0;
        }
        nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
        }
        .nav-box {
            background-color: #333333;
            color: #FFFFFF;
            padding: 15px 20px;
            margin: 0 10px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
        }
        .nav-box:hover {
            background-color: #555555;
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
            color: #d1986a; /* Red headings */
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
            border: 2px solid #d1986a;
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
        }
        .menu-item h3 {
            color: #d1986a;
            margin: 10px 0 5px 0;
        }
        .menu-item p {
            font-size: 14px;
            color: #CCCCCC;
            margin: 5px 0;
        }
        .menu-category {
            margin-top: 30px;
        }
        .menu-category h3 {
            color: #d1986a;
            border-bottom: 2px solid #d1986a;
            padding-bottom: 10px;
        }
        .contact-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #d1986a;
        }
        .contact-info {
            color: #FFFFFF;
            margin-bottom: 20px;
        }
        .contact-info p {
            margin: 10px 0;
        }
        .contact-form label {
            display: block;
            color: #d1986a;
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
            border: 1px solid #d1986a;
            color: #FFFFFF;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .contact-form input::placeholder,
        .contact-form textarea::placeholder {
            color: #999999;
        }
        .contact-form button {
            background-color: #d1986a;
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
            background-color: #b8864e;
        }
        .about-container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #d1986a;
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
            border: 2px solid #d1986a;
        }
        .about-text h3 {
            color: #d1986a;
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
            border: 2px solid #d1986a;
            margin-bottom: 20px;
        }
        .hero-img {
            width: 100%;
            border-radius: 8px;
            object-fit: cover;
            max-height: 420px;
            border: 2px solid #d1986a;
        }
        .hero-text h2 {
            color: #d1986a;
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
            background-color: #d1986a;
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
<a href="/login" class="auth-button">Login</a>
        <div class="logo">
            <img src="{{ asset('restaurant-icon.png') }}" alt="MAT ROCK">
            <h1>MAT ROCK Restaurant Ordering System</h1>
        </div>
        <nav>
            <div class="nav-box" onclick="showSection('qr')">QR Code</div>
            <div class="nav-box" onclick="showSection('menu')">Menu</div>
            <div class="nav-box" onclick="showSection('about')">About Us</div>
            <div class="nav-box" onclick="showSection('contact')">Contact Us</div>
            <div class="nav-box" onclick="showSection('feedback')">Feedback</div>
        </nav>
    </header>
    <div class="content">
        <section id="about" class="section">
            <div class="about-container">
                <div class="about-image">
                    <svg viewBox="0 0 300 300" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:300px;border-radius:8px;">
                        <rect width="300" height="300" fill="#1a1a1a"/>
                        <circle cx="150" cy="120" r="60" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/>
                        <path d="M110 140 Q150 80 190 140" stroke="#d1986a" stroke-width="2" fill="none"/>
                        <circle cx="150" cy="105" r="5" fill="#d1986a"/>
                        <text x="150" y="220" text-anchor="middle" fill="#d1986a" font-size="24" font-weight="bold">MAT ROCK</text>
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
            <h2>QR Code</h2>
            <p>Customer scan QR table number guna phone untuk buka menu order page khas.</p>
            <!-- Placeholder for QR code image -->
            <div style="text-align:center;padding:20px;">
                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:200px;height:200px;background:#222;border-radius:8px;">
                    <rect x="20" y="20" width="50" height="50" rx="5" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/>
                    <rect x="130" y="20" width="50" height="50" rx="5" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/>
                    <rect x="20" y="130" width="50" height="50" rx="5" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/>
                    <rect x="90" y="90" width="20" height="20" fill="#d1986a"/>
                    <rect x="130" y="130" width="50" height="50" rx="5" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/>
                    <rect x="35" y="35" width="20" height="20" fill="#d1986a"/>
                    <rect x="145" y="35" width="20" height="20" fill="#d1986a"/>
                    <rect x="35" y="145" width="20" height="20" fill="#d1986a"/>
                    <rect x="145" y="145" width="20" height="20" fill="#d1986a"/>
                    <text x="100" y="195" text-anchor="middle" fill="#999" font-size="12">Scan to Order</text>
                </svg>
            </div>
            <p style="margin-top:16px;">
                Demo link (Table T01):
                <a href="{{ route('customer.welcome') }}" style="color:#d1986a;font-weight:bold;">Open Customer Menu Page</a>
            </p>
        </section>
        <section id="menu" class="section">
            <h2>Food/Drink Menu</h2>
            <p>Check out our delicious food and drinks.</p>
            
            <!-- FOODS SECTION -->
            <div class="menu-category">
                <h3>Foods</h3>
                <div class="menu-grid">
                    <!-- Food Item 1 -->
                    <div class="menu-item">
                        <div style="width:100%;height:150px;background:#333;border-radius:5px;display:flex;align-items:center;justify-content:center;">
                            <svg viewBox="0 0 60 60" width="50" height="50" fill="none"><ellipse cx="30" cy="40" rx="20" ry="8" stroke="#d1986a" stroke-width="2"/><path d="M15 35 Q30 15 45 35" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/></svg>
                        </div>
                        <h3>Dish Name 1</h3>
                        <p>Brief description of the dish</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                    <!-- Food Item 2 -->
                    <div class="menu-item">
                        <div style="width:100%;height:150px;background:#333;border-radius:5px;display:flex;align-items:center;justify-content:center;">
                            <svg viewBox="0 0 60 60" width="50" height="50" fill="none"><ellipse cx="30" cy="40" rx="20" ry="8" stroke="#d1986a" stroke-width="2"/><path d="M15 35 Q30 15 45 35" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/></svg>
                        </div>
                        <h3>Dish Name 2</h3>
                        <p>Brief description of the dish</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                    <!-- Food Item 3 -->
                    <div class="menu-item">
                        <div style="width:100%;height:150px;background:#333;border-radius:5px;display:flex;align-items:center;justify-content:center;">
                            <svg viewBox="0 0 60 60" width="50" height="50" fill="none"><ellipse cx="30" cy="40" rx="20" ry="8" stroke="#d1986a" stroke-width="2"/><path d="M15 35 Q30 15 45 35" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/></svg>
                        </div>
                        <h3>Dish Name 3</h3>
                        <p>Brief description of the dish</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                    <!-- Food Item 4 -->
                    <div class="menu-item">
                        <div style="width:100%;height:150px;background:#333;border-radius:5px;display:flex;align-items:center;justify-content:center;">
                            <svg viewBox="0 0 60 60" width="50" height="50" fill="none"><ellipse cx="30" cy="40" rx="20" ry="8" stroke="#d1986a" stroke-width="2"/><path d="M15 35 Q30 15 45 35" stroke="#d1986a" stroke-width="2" fill="rgba(209,152,106,0.1)"/></svg>
                        </div>
                        <h3>Dish Name 4</h3>
                        <p>Brief description of the dish</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                </div>
            </div>
            
            <!-- DRINKS SECTION -->
            <div class="menu-category">
                <h3>Drinks</h3>
                <div class="menu-grid">
                    <!-- Drink Item 1 -->
                    <div class="menu-item">
                        <div style="width:100%;height:150px;background:#333;border-radius:5px;display:flex;align-items:center;justify-content:center;">
                            <svg viewBox="0 0 60 60" width="50" height="50" fill="none"><path d="M20 15 L20 45 Q20 50 30 50 Q40 50 40 45 L40 15" stroke="#d1986a" stroke-width="2"/><ellipse cx="30" cy="15" rx="10" ry="4" stroke="#d1986a" stroke-width="2"/></svg>
                        </div>
                        <h3>Drink Name 1</h3>
                        <p>Brief description of the drink</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                    <!-- Drink Item 2 -->
                    <div class="menu-item">
                        <div style="width:100%;height:150px;background:#333;border-radius:5px;display:flex;align-items:center;justify-content:center;">
                            <svg viewBox="0 0 60 60" width="50" height="50" fill="none"><path d="M20 15 L20 45 Q20 50 30 50 Q40 50 40 45 L40 15" stroke="#d1986a" stroke-width="2"/><ellipse cx="30" cy="15" rx="10" ry="4" stroke="#d1986a" stroke-width="2"/></svg>
                        </div>
                        <h3>Drink Name 2</h3>
                        <p>Brief description of the drink</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                    <!-- Drink Item 3 -->
                    <div class="menu-item">
                        <div style="width:100%;height:150px;background:#333;border-radius:5px;display:flex;align-items:center;justify-content:center;">
                            <svg viewBox="0 0 60 60" width="50" height="50" fill="none"><path d="M20 15 L20 45 Q20 50 30 50 Q40 50 40 45 L40 15" stroke="#d1986a" stroke-width="2"/><ellipse cx="30" cy="15" rx="10" ry="4" stroke="#d1986a" stroke-width="2"/></svg>
                        </div>
                        <h3>Drink Name 3</h3>
                        <p>Brief description of the drink</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                    <!-- Drink Item 4 -->
                    <div class="menu-item">
                        <div style="width:100%;height:150px;background:#333;border-radius:5px;display:flex;align-items:center;justify-content:center;">
                            <svg viewBox="0 0 60 60" width="50" height="50" fill="none"><path d="M20 15 L20 45 Q20 50 30 50 Q40 50 40 45 L40 15" stroke="#d1986a" stroke-width="2"/><ellipse cx="30" cy="15" rx="10" ry="4" stroke="#d1986a" stroke-width="2"/></svg>
                        </div>
                        <h3>Drink Name 4</h3>
                        <p>Brief description of the drink</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                </div>
            </div>
        </section>
        <section id="contact" class="section">
            <h2>Contact Us</h2>
            <div class="contact-container">
                <div class="contact-info">
                    <p><strong>Restaurant:</strong> Mat Rock Ayam Goreng Kunyit Skudai</p>
                    <p><strong>Location:</strong> Skudai, Johor Bahru</p>
                    <p><strong>Phone:</strong> +60 16-660 7314</p>
                </div>
                <form class="contact-form" method="POST">
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
    </script>
</body>
</html>