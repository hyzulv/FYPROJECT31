<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us — Restaurant Name</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000000;
            color: #FFFFFF;
            line-height: 1.6;
        }
        header {
            background-color: #FF0000;
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
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            padding: 0 12px;
        }
        .nav-box {
            background-color: #333333;
            color: #FFFFFF;
            padding: 15px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            border: none;
            font-size: inherit;
            font-family: inherit;
        }
        a.nav-box:hover {
            background-color: #555555;
        }
        .nav-box.nav-active {
            background-color: #222222;
            outline: 2px solid #FFFFFF;
            cursor: default;
        }
        .nav-box.nav-active:hover {
            background-color: #222222;
        }
        main {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px 40px;
        }
        .page-title {
            color: #FF0000;
            font-size: 2rem;
            margin: 0 0 8px;
        }
        .tagline {
            color: #CCCCCC;
            font-size: 1.1rem;
            margin: 0 0 28px;
        }
        .intro-card {
            background-color: #111111;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 28px;
        }
        .intro-card h2 {
            color: #FF0000;
            margin-top: 0;
            font-size: 1.35rem;
        }
        .split {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            align-items: center;
            margin-bottom: 28px;
        }
        @media (min-width: 768px) {
            .split {
                grid-template-columns: 1fr 1fr;
            }
            .split.reverse .split-text {
                order: 2;
            }
            .split.reverse .split-media {
                order: 1;
            }
        }
        .split-media {
            background-color: #1a1a1a;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #333333;
        }
        .split-media img {
            width: 100%;
            height: auto;
            display: block;
        }
        .split-text {
            background-color: #111111;
            border-radius: 8px;
            padding: 24px;
        }
        .split-text h2 {
            color: #FF0000;
            margin-top: 0;
            font-size: 1.35rem;
        }
        .values {
            background-color: #111111;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 28px;
        }
        .values h2 {
            color: #FF0000;
            margin-top: 0;
        }
        .value-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }
        @media (min-width: 600px) {
            .value-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        .value-item {
            background-color: #1a1a1a;
            padding: 18px;
            border-radius: 8px;
            border-top: 3px solid #FF0000;
        }
        .value-item h3 {
            margin: 0 0 10px;
            font-size: 1rem;
            color: #FFFFFF;
        }
        .value-item p {
            margin: 0;
            font-size: 0.95rem;
            color: #DDDDDD;
        }
        .cta-strip {
            text-align: center;
            padding: 24px;
            background-color: #1a1a1a;
            border-radius: 8px;
            border: 1px solid #333333;
        }
        .cta-strip a {
            color: #FF6666;
            font-weight: bold;
        }
        h1 {
            color: #FF0000;
        }
        p {
            color: #FFFFFF;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <a href="Homepage.php" style="text-decoration:none;color:inherit;">
                <img src="restaurant-icon.png" alt="Restaurant Icon">
                <h1>Restaurant Name</h1>
            </a>
        </div>
        <nav>
            <a class="nav-box" href="Homepage.php">Home</a>
            <a class="nav-box" href="Homepage.php">QR Code</a>
            <a class="nav-box" href="Homepage.php">Food/Drink Menu</a>
            <span class="nav-box nav-active" aria-current="page">About Us</span>
            <a class="nav-box" href="Homepage.php">Contact Us</a>
            <a class="nav-box" href="Homepage.php">Feedback</a>
        </nav>
    </header>
    <main>
        <h1 class="page-title">About Us</h1>
        <p class="tagline">Learn more about Mat Rock and what makes our restaurant special.</p>

        <section class="intro-card" aria-labelledby="our-story-heading">
            <h2 id="our-story-heading">Our story</h2>
            <p>
                Mat Rock Ayam Goreng Kunyit Skudai is a local favourite in Skudai, Johor Bahru. We opened with a simple goal: deliver tasty, affordable meals in a friendly atmosphere.
            </p>
            <p>
                Our special turmeric fried chicken, served with rice and sambal, has become a go-to meal for students, workers, and families who love authentic Malaysian flavours.
            </p>
        </section>

        <section class="split" aria-labelledby="about-photo-heading">
            <div class="split-media">
                <img src="about-kitchen.jpg" alt="Restaurant team preparing food">
            </div>
            <div class="split-text">
                <h2 id="about-photo-heading">A welcoming place</h2>
                <p>
                    We keep our restaurant simple, warm, and inviting. Whether you are stopping in for a quick lunch or dining with friends, we aim to make every meal satisfying.
                </p>
                <p>
                    Our food is made with care, using fresh ingredients and classic recipes that highlight rich, comforting Malaysian tastes.
                </p>
            </div>
        </section>

        <section class="values" aria-labelledby="values-heading">
            <h2 id="values-heading">What we stand for</h2>
            <div class="value-grid">
                <article class="value-item">
                    <h3>Fresh Flavour</h3>
                    <p>Every dish is prepared with fresh ingredients and bold seasoning.</p>
                </article>
                <article class="value-item">
                    <h3>Friendly Service</h3>
                    <p>We treat every guest like family and welcome you with warm hospitality.</p>
                </article>
                <article class="value-item">
                    <h3>Local Roots</h3>
                    <p>We serve the community with dishes that feel familiar and satisfying.</p>
                </article>
            </div>
        </section>
    </main>
</body>
</html>
