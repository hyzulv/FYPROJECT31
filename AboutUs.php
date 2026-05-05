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
        <p class="tagline">Our story, our kitchen, and the people who welcome you every day.</p>

        <section class="intro-card" aria-labelledby="our-story-heading">
            <h2 id="our-story-heading">Our story</h2>
            <p>
                Restaurant Name opened its doors with one idea: serve honest food in a warm space where neighbours feel like regulars from day one.
                What began as a small family kitchen has grown into a gathering place for celebrations, quiet dinners, and everything in between.
            </p>
            <p>
                We source fresh ingredients locally when we can, prepare dishes with care, and never rush the details—from our signature recipes to the way we greet you at the door.
            </p>
        </section>

        <section class="split" aria-labelledby="kitchen-heading">
            <div class="split-media">
                <img src="about-kitchen.jpg" alt="Chefs preparing food in the restaurant kitchen">
            </div>
            <div class="split-text">
                <h2 id="kitchen-heading">The kitchen</h2>
                <p>
                    Our chefs blend classic comfort with seasonal specials. Each plate is meant to be shared, savoured, and remembered—whether it is a slow-cooked favourite or something new on the menu this month.
                </p>
                <p>
                    Have dietary needs? Tell our team and we will do our best to accommodate with clear, friendly guidance.
                </p>
            </div>
        </section>

        <section class="split reverse" aria-labelledby="dining-heading">
            <div class="split-media">
                <img src="about-dining.jpg" alt="Guests enjoying a meal in the dining area">
            </div>
            <div class="split-text">
                <h2 id="dining-heading">The dining room</h2>
                <p>
                    We designed our space to feel inviting: soft lighting, comfortable seating, and room for both intimate tables and larger groups.
                </p>
                <p>
                    Drop in for lunch, reserve a table for dinner, or ask about private events—we love being part of your milestones.
                </p>
            </div>
        </section>

        <section class="values" aria-labelledby="values-heading">
            <h2 id="values-heading">What we stand for</h2>
            <div class="value-grid">
                <article class="value-item">
                    <h3>Quality</h3>
                    <p>Thoughtful recipes, consistent preparation, and attention to every plate that leaves the pass.</p>
                </article>
                <article class="value-item">
                    <h3>Hospitality</h3>
                    <p>Friendly service that treats every guest like part of our extended restaurant family.</p>
                </article>
                <article class="value-item">
                    <h3>Community</h3>
                    <p>Supporting local suppliers and giving back to the neighbourhood that supports us.</p>
                </article>
            </div>
        </section>

        <aside class="cta-strip">
            <p style="margin:0;">Questions or ready to visit? Head back to the homepage for our menu, contact details, and feedback form.</p>
            <p style="margin:12px 0 0;"><a href="Homepage.php">Return to homepage</a></p>
        </aside>
    </main>
</body>
</html>
