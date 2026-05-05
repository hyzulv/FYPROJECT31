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
            background-color: #FF0000; /* Red header */
            padding: 20px 0;
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
            color: #FF0000; /* Red headings */
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
            border: 2px solid #FF0000;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .menu-item:hover {
            transform: scale(1.05);
            background-color: #333333;
        }
        .menu-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .menu-item h3 {
            color: #FF0000;
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
            color: #FF0000;
            border-bottom: 2px solid #FF0000;
            padding-bottom: 10px;
        }
        .contact-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #FF0000;
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
            color: #FF0000;
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
            border: 1px solid #FF0000;
            color: #FFFFFF;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .contact-form input::placeholder,
        .contact-form textarea::placeholder {
            color: #999999;
        }
        .contact-form button {
            background-color: #FF0000;
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
            background-color: #CC0000;
        }
        .about-container {
            max-width: 900px;
            margin: 20px auto;
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #FF0000;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: center;
        }
        .about-image {
            text-align: center;
        }
        .about-image img {
            width: 100%;
            max-width: 300px;
            height: auto;
            border-radius: 8px;
            border: 2px solid #FF0000;
        }
        .about-image .placeholder {
            width: 100%;
            max-width: 300px;
            height: 300px;
            background-color: #333333;
            border: 2px dashed #FF0000;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999999;
            font-size: 14px;
        }
        .about-text h3 {
            color: #FF0000;
            margin-top: 0;
        }
        .about-text p {
            color: #FFFFFF;
            line-height: 1.6;
            margin: 10px 0;
        }
        @media (max-width: 768px) {
            .about-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="restaurant-icon.png" alt="Restaurant Icon">
            <h1>MAT ROCK Restaurant Ordering System</h1>
        </div>
        <nav>
            <div class="nav-box" onclick="showSection('qr')">QR Code</div>
            <div class="nav-box" onclick="showSection('menu')">Menu</div>
            <a class="nav-box" href="AboutUs.php">About Us</a>
            <div class="nav-box" onclick="showSection('contact')">Contact Us</div>
            <div class="nav-box" onclick="showSection('feedback')">Feedback</div>
        </nav>
    </header>
    <div class="content">
        <section id="qr" class="section">
            <h2>QR Code</h2>
            <p>Scan the QR code here.</p>
            <!-- Placeholder for QR code image -->
            <img src="placeholder-qr.png" alt="QR Code" style="width: 200px; height: 200px;">
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
                        <img src="food1.jpg" alt="Food Item 1">
                        <h3>Dish Name 1</h3>
                        <p>Brief description of the dish</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                    <!-- Food Item 2 -->
                    <div class="menu-item">
                        <img src="food2.jpg" alt="Food Item 2">
                        <h3>Dish Name 2</h3>
                        <p>Brief description of the dish</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                    <!-- Food Item 3 -->
                    <div class="menu-item">
                        <img src="food3.jpg" alt="Food Item 3">
                        <h3>Dish Name 3</h3>
                        <p>Brief description of the dish</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                    <!-- Food Item 4 -->
                    <div class="menu-item">
                        <img src="food4.jpg" alt="Food Item 4">
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
                        <img src="drink1.jpg" alt="Drink Item 1">
                        <h3>Drink Name 1</h3>
                        <p>Brief description of the drink</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                    <!-- Drink Item 2 -->
                    <div class="menu-item">
                        <img src="drink2.jpg" alt="Drink Item 2">
                        <h3>Drink Name 2</h3>
                        <p>Brief description of the drink</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                    <!-- Drink Item 3 -->
                    <div class="menu-item">
                        <img src="drink3.jpg" alt="Drink Item 3">
                        <h3>Drink Name 3</h3>
                        <p>Brief description of the drink</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                    <!-- Drink Item 4 -->
                    <div class="menu-item">
                        <img src="drink4.jpg" alt="Drink Item 4">
                        <h3>Drink Name 4</h3>
                        <p>Brief description of the drink</p>
                        <p><strong>Price: $X.XX</strong></p>
                    </div>
                </div>
            </div>
        </section>
        <section id="about" class="section">
            <h2>About Us</h2>
            <div class="about-container">
                <div class="about-image">
                    <!-- Replace "restaurant-photo.jpg" with your actual restaurant image -->
                    <img src="restaurant-photo.jpg" alt="Mat Rock Restaurant">
                    <!-- Uncomment the placeholder below if you don't have an image yet -->
                    <!-- <div class="placeholder">Restaurant Photo</div> -->
                </div>
                <div class="about-text">
                    <h3>Mat Rock Ayam Goreng Kunyit Skudai</h3>
                    <p><strong>A Popular Local Eatery</strong></p>
                    <p>Mat Rock is located in the Skudai area of Johor Bahru, known for serving affordable and authentic Malaysian food.</p>
                    
                    <p><strong>Signature Dish:</strong> Nasi Ayam Kunyit</p>
                    <p>Features crispy fried turmeric chicken served with rice and sambal.</p>
                    
                    <p><strong>Atmosphere:</strong></p>
                    <p>The restaurant has a simple, no-frills setting and is often crowded during peak hours, particularly among students and locals looking for a quick and budget-friendly meal.</p>
                    
                    <p><strong>Why Choose Us:</strong></p>
                    <p>While the menu is limited, the food is flavorful and satisfying, making it a go-to spot for those who enjoy casual street-style dining.</p>
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

        // Show About Us section by default when page loads
        window.onload = function() {
            showSection('about');
        };
    </script>
</body>
</html>