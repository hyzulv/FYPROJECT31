<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAT ROCK - Dashboard Selection</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #FFFFFF;
            color: #222222;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .container {
            text-align: center;
            padding: 40px 20px;
        }

        .logo {
            margin-bottom: 30px;
        }

        .logo h1 {
            color: #420C09;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .logo p {
            color: #666;
            font-size: 1.1rem;
        }

        .selection-title {
            color: #420C09;
            font-size: 1.5rem;
            margin-bottom: 40px;
        }

        .role-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 700px;
            margin: 0 auto;
        }

        .role-card {
            background: #fafafa;
            border: 2px solid #420C09;
            border-radius: 16px;
            padding: 40px 30px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .role-card:hover {
            transform: translateY(-10px);
            border-color: #420C09;
            box-shadow: 0 15px 40px rgba(66, 12, 9, 0.15);
        }

        .role-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .role-card h2 {
            color: #420C09;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .role-card p {
            color: #666;
            line-height: 1.6;
        }

        .role-card .btn {
            margin-top: 25px;
            background: #420C09;
            color: #fff;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .role-card:hover .btn {
            background: #300806;
        }

        @media (max-width: 640px) {
            .logo h1 {
                font-size: 2rem;
            }

            .role-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>MAT ROCK</h1>
            <p>Restaurant Ordering System</p>
        </div>

        <h2 class="selection-title">Select Dashboard Role</h2>

        <div class="role-cards">
            <a href="/staff/dashboard" class="role-card">
                <div class="role-icon">👨‍🍳</div>
                <h2>Staff Dashboard</h2>
                <p>View orders, menu, feedback, and manage your profile</p>
                <span class="btn">Enter as Staff</span>
            </a>

            <a href="/admin/dashboard" class="role-card">
                <div class="role-icon">👨‍💼</div>
                <h2>Admin Dashboard</h2>
                <p>All staff features plus staff management capabilities</p>
                <span class="btn">Enter as Admin</span>
            </a>
        </div>
    </div>
</body>
</html>
