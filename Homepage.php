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
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="restaurant-icon.png" alt="Restaurant Icon">
            <h1>Restaurant Name</h1>
        </div>
        <nav>
            <div class="nav-box" onclick="showSection('qr')">QR Code</div>
            <div class="nav-box" onclick="showSection('menu')">Food/Drink Menu</div>
            <div class="nav-box" onclick="showSection('about')">About Us</div>
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
        </section>
        <section id="about" class="section">
            <h2>About Us</h2>
            <p>Learn more about our company.</p>
        </section>
        <section id="contact" class="section">
            <h2>Contact Us</h2>
            <p>Get in touch with us.</p>
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
    </script>
</body>
</html>