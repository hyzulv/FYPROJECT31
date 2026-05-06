<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - MAT ROCK Restaurant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-black: #000000;
            --secondary-gold: #d1986a;
            --gold-hover: #b8834f;
            --dark-gray: #1a1a1a;
            --medium-gray: #2a2a2a;
            --light-gray: #3a3a3a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--primary-black);
            color: #ffffff;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, var(--dark-gray) 0%, var(--primary-black) 100%);
            border-right: 1px solid var(--secondary-gold);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(209, 152, 106, 0.3);
            text-align: center;
        }

        .sidebar-header h2 {
            color: var(--secondary-gold);
            font-size: 1.3rem;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            color: #888;
            font-size: 0.85rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 15px 0;
        }

        .sidebar-menu li {
            margin: 5px 10px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #ccc;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(209, 152, 106, 0.15);
            color: var(--secondary-gold);
        }

        .sidebar-menu a .icon {
            margin-right: 12px;
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .navbar {
            background-color: var(--dark-gray);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(209, 152, 106, 0.3);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--secondary-gold);
            font-size: 1.5rem;
            cursor: pointer;
            margin-right: 15px;
        }

        .navbar-title {
            color: var(--secondary-gold);
            font-size: 1.2rem;
            font-weight: 600;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--secondary-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: bold;
        }

        .content-area {
            padding: 30px;
        }

        .stat-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(145deg, var(--dark-gray), var(--medium-gray));
            border: 1px solid rgba(209, 152, 106, 0.2);
            border-radius: 12px;
            padding: 25px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--secondary-gold);
            box-shadow: 0 10px 30px rgba(209, 152, 106, 0.15);
        }

        .stat-card .card-icon {
            font-size: 2rem;
            color: var(--secondary-gold);
            margin-bottom: 15px;
        }

        .stat-card .card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 5px;
        }

        .stat-card .card-label {
            color: #888;
            font-size: 0.9rem;
        }

        .data-card {
            background: var(--dark-gray);
            border: 1px solid rgba(209, 152, 106, 0.2);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .data-card h3 {
            color: var(--secondary-gold);
            margin-bottom: 20px;
            font-size: 1.2rem;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(209, 152, 106, 0.1);
        }

        .data-table th {
            color: var(--secondary-gold);
            font-weight: 600;
            background: rgba(209, 152, 106, 0.05);
        }

        .data-table tr:hover {
            background: rgba(209, 152, 106, 0.05);
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-pending {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .badge-completed {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .badge-processing {
            background: rgba(0, 123, 255, 0.2);
            color: #007bff;
        }

        .badge-admin {
            background: rgba(209, 152, 106, 0.3);
            color: var(--secondary-gold);
        }

        .badge-staff {
            background: rgba(108, 117, 125, 0.3);
            color: #adb5bd;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999;
        }

        .menu-item-card {
            display: flex;
            gap: 20px;
            padding: 15px;
            background: var(--medium-gray);
            border-radius: 10px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .menu-item-card:hover {
            background: var(--light-gray);
            transform: translateX(5px);
        }

        .menu-item-img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            background: var(--secondary-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .menu-item-info h4 {
            color: #fff;
            margin-bottom: 5px;
        }

        .menu-item-info p {
            color: #888;
            font-size: 0.9rem;
        }

        .menu-item-info .price {
            color: var(--secondary-gold);
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 8px;
        }

        .feedback-card {
            background: var(--medium-gray);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid var(--secondary-gold);
            transition: all 0.3s ease;
        }

        .feedback-card:hover {
            transform: translateX(5px);
        }

        .feedback-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .feedback-header h4 {
            color: #fff;
        }

        .feedback-rating {
            color: var(--secondary-gold);
        }

        .feedback-text {
            color: #aaa;
            line-height: 1.6;
        }

        .profile-card {
            background: var(--dark-gray);
            border: 1px solid rgba(209, 152, 106, 0.3);
            border-radius: 12px;
            padding: 30px;
            max-width: 500px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--secondary-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #000;
            margin: 0 auto 20px;
        }

        .profile-info {
            text-align: center;
        }

        .profile-info h3 {
            color: var(--secondary-gold);
            margin-bottom: 15px;
        }

        .profile-detail {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(209, 152, 106, 0.1);
        }

        .profile-detail:last-child {
            border-bottom: none;
        }

        .profile-detail .label {
            color: #888;
        }

        .profile-detail .value {
            color: #fff;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .overlay.active {
                display: block;
            }

            .content-area {
                padding: 20px;
            }

            .stat-cards {
                grid-template-columns: 1fr;
            }

            .data-table {
                display: block;
                overflow-x: auto;
            }

            .menu-item-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>
    
    <aside class="sidebar" id="sidebar">
        @include('layouts.sidebar')
    </aside>

    <div class="main-content">
        <nav class="navbar">
            <div class="navbar-left">
                <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
                <span class="navbar-title">@yield('page-title', 'Dashboard')</span>
            </div>
            <div class="navbar-right">
                <div class="user-info">
                    <div class="user-avatar">{{ substr($userName ?? 'U', 0, 1) }}</div>
                    <span>{{ $userName ?? 'User' }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: 1px solid rgba(209, 152, 106, 0.3); color: #d1986a; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 0.85rem; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(209,152,106,0.1)'" onmouseout="this.style.background='none'">Logout</button>
                </form>
            </div>
        </nav>

        <main class="content-area">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
        }
    </script>
    @stack('scripts')
</body>
</html>
