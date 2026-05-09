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
            --secondary-red: #cf2c21;
            --red-hover: #a8231a;
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
            border-right: 1px solid var(--secondary-red);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(207, 44, 33, 0.3);
            text-align: center;
        }

        .sidebar-header h2 {
            color: var(--secondary-red);
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
            background: rgba(207, 44, 33, 0.15);
            color: var(--secondary-red);
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
            border-bottom: 1px solid rgba(207, 44, 33, 0.3);
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
            color: var(--secondary-red);
            font-size: 1.5rem;
            cursor: pointer;
            margin-right: 15px;
        }

        .navbar-title {
            color: var(--secondary-red);
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
            background: var(--secondary-red);
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
            border: 1px solid rgba(207, 44, 33, 0.2);
            border-radius: 12px;
            padding: 25px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--secondary-red);
            box-shadow: 0 10px 30px rgba(207, 44, 33, 0.15);
        }

        .stat-card .card-icon {
            font-size: 2rem;
            color: var(--secondary-red);
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
            border: 1px solid rgba(207, 44, 33, 0.2);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .data-card h3 {
            color: var(--secondary-red);
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
            border-bottom: 1px solid rgba(207, 44, 33, 0.1);
        }

        .data-table th {
            color: var(--secondary-red);
            font-weight: 600;
            background: rgba(207, 44, 33, 0.05);
        }

        .data-table tr:hover {
            background: rgba(207, 44, 33, 0.05);
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
            background: rgba(207, 44, 33, 0.3);
            color: var(--secondary-red);
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
            background: var(--secondary-red);
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
            color: var(--secondary-red);
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 8px;
        }

        .feedback-card {
            background: var(--medium-gray);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid var(--secondary-red);
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
            color: var(--secondary-red);
        }

        .feedback-text {
            color: #aaa;
            line-height: 1.6;
        }

        .profile-card {
            background: var(--dark-gray);
            border: 1px solid rgba(207, 44, 33, 0.3);
            border-radius: 12px;
            padding: 30px;
            max-width: 500px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--secondary-red);
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
            color: var(--secondary-red);
            margin-bottom: 15px;
        }

        .profile-detail {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(207, 44, 33, 0.1);
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

        /* Profile Layout */
        .profile-container { max-width: 1200px; }
        .profile-layout { display: grid; grid-template-columns: 380px 1fr; gap: 30px; align-items: start; }
        .profile-left { position: sticky; top: 100px; }
        .profile-card-full {
            background: linear-gradient(145deg, var(--dark-gray), var(--medium-gray));
            border: 1px solid rgba(207, 44, 33, 0.2);
            border-radius: 16px; padding: 40px 30px; text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        .profile-avatar-large {
            width: 120px; height: 120px; border-radius: 50%;
            background: linear-gradient(135deg, #cf2c21, #a8231a);
            display: flex; align-items: center; justify-content: center;
            font-size: 3rem; color: #000; font-weight: bold;
            margin: 0 auto 20px;
            box-shadow: 0 8px 25px rgba(207, 44, 33, 0.3);
        }
        .profile-name { color: #fff; font-size: 1.5rem; margin-bottom: 8px; }
        .profile-role-badge {
            display: inline-block; padding: 6px 18px; border-radius: 20px;
            background: rgba(207, 44, 33, 0.2); color: var(--secondary-red);
            font-size: 0.85rem; font-weight: 600; margin-bottom: 25px;
        }
        .profile-details-grid { display: grid; gap: 18px; text-align: left; margin-top: 25px; }
        .detail-item {
            display: flex; align-items: center; gap: 14px;
            padding: 14px 18px; background: rgba(255,255,255,0.03);
            border-radius: 10px; border: 1px solid rgba(207, 44, 33, 0.08);
        }
        .detail-icon { font-size: 1.3rem; }
        .detail-text { display: flex; flex-direction: column; }
        .detail-label { color: #888; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .detail-value { color: #fff; font-size: 0.95rem; font-weight: 500; }
        .active-text { color: #28a745; }

        /* Edit Card */
        .edit-card, .security-card {
            background: var(--dark-gray); border: 1px solid rgba(207, 44, 33, 0.2);
            border-radius: 14px; padding: 30px; margin-bottom: 20px;
        }
        .edit-card h3, .security-card h3 {
            color: var(--secondary-red); font-size: 1.2rem; margin-bottom: 20px;
        }
        .edit-form-group { margin-bottom: 20px; }
        .edit-form-group label {
            display: block; color: #cf2c21; font-size: 0.85rem; font-weight: 600;
            margin-bottom: 8px;
        }
        .edit-form-group input {
            width: 100%; padding: 12px 15px; background: #2a2a2a;
            border: 1px solid rgba(207, 44, 33, 0.2); border-radius: 10px;
            color: #fff; font-size: 0.95rem; transition: all 0.3s ease;
        }
        .edit-form-group input:focus {
            outline: none; border-color: #cf2c21;
            box-shadow: 0 0 0 3px rgba(207, 44, 33, 0.1);
        }
        .btn-save {
            width: 100%; padding: 14px; background: linear-gradient(135deg, #cf2c21, #a8231a);
            border: none; border-radius: 10px; color: #000; font-size: 1rem;
            font-weight: 700; cursor: pointer; transition: all 0.3s ease;
        }
        .btn-save:hover {
            background: linear-gradient(135deg, #dc362a, #cf2c21);
            transform: translateY(-2px); box-shadow: 0 8px 25px rgba(207, 44, 33, 0.3);
        }

        /* Security Card */
        .security-card p { color: #888; font-size: 0.9rem; margin-bottom: 20px; }
        .btn-change-password {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 12px 24px; background: rgba(207, 44, 33, 0.1);
            border: 1px solid rgba(207, 44, 33, 0.3); border-radius: 10px;
            color: var(--secondary-red); text-decoration: none; font-size: 0.95rem;
            font-weight: 600; transition: all 0.3s ease;
        }
        .btn-change-password:hover {
            background: rgba(207, 44, 33, 0.2);
            transform: translateY(-2px); box-shadow: 0 5px 15px rgba(207, 44, 33, 0.2);
        }

        /* Alerts */
        .alert { padding: 14px 20px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; }
        .alert-success { background: rgba(40, 167, 69, 0.15); border: 1px solid rgba(40, 167, 69, 0.3); color: #28a745; }
        .alert-error { background: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.3); color: #dc3545; }

        /* Change Password Page */
        .change-password-container { max-width: 500px; }
        .change-password-card {
            background: var(--dark-gray); border: 1px solid rgba(207, 44, 33, 0.2);
            border-radius: 16px; padding: 40px; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        .change-password-card h2 { color: var(--secondary-red); margin-bottom: 8px; text-align: center; }
        .change-password-card .subtitle { color: #888; text-align: center; margin-bottom: 30px; font-size: 0.9rem; }
        .cp-form-group { margin-bottom: 22px; }
        .cp-form-group label { display: block; color: #cf2c21; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; }
        .cp-form-group input {
            width: 100%; padding: 12px 15px; background: #2a2a2a;
            border: 1px solid rgba(207, 44, 33, 0.2); border-radius: 10px;
            color: #fff; font-size: 0.95rem; transition: all 0.3s ease;
        }
        .cp-form-group input:focus {
            outline: none; border-color: #cf2c21;
            box-shadow: 0 0 0 3px rgba(207, 44, 33, 0.1);
        }
        .btn-submit {
            width: 100%; padding: 14px; background: linear-gradient(135deg, #cf2c21, #a8231a);
            border: none; border-radius: 10px; color: #000; font-size: 1rem;
            font-weight: 700; cursor: pointer; transition: all 0.3s ease; margin-top: 10px;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #dc362a, #cf2c21);
            transform: translateY(-2px); box-shadow: 0 8px 25px rgba(207, 44, 33, 0.3);
        }

        /* Real-time indicator */
        .live-indicator { display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem; color: #28a745; }
        .live-dot { width: 8px; height: 8px; border-radius: 50%; background: #28a745; animation: livePulse 1.5s ease-in-out infinite; }
        @keyframes livePulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }

        /* Notification toast */
        .notification-toast {
            position: fixed; top: 20px; right: 20px; z-index: 9999;
            background: var(--dark-gray); border: 1px solid rgba(207, 44, 33, 0.3);
            border-radius: 12px; padding: 16px 24px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            display: flex; align-items: center; gap: 12px; min-width: 300px;
            transform: translateX(120%); transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .notification-toast.show { transform: translateX(0); }
        .notification-toast .toast-icon { font-size: 1.5rem; }
        .notification-toast .toast-text { color: #fff; font-size: 0.9rem; }
        .notification-toast .toast-text strong { color: var(--secondary-red); }

        @keyframes flashCard { 0%, 100% { border-color: rgba(207, 44, 33, 0.2); } 50% { border-color: #cf2c21; box-shadow: 0 0 20px rgba(207, 44, 33, 0.4); } }

        @media (max-width: 768px) {
            .profile-layout { grid-template-columns: 1fr; }
            .profile-left { position: static; }
        }
    </style>
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
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;" id="logoutForm">
                    @csrf
                    <button type="submit" style="background: none; border: 1px solid rgba(207, 44, 33, 0.3); color: #cf2c21; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 0.85rem; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(207,44,33,0.1)'" onmouseout="this.style.background='none'">Logout</button>
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

        document.getElementById('logoutForm')?.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to logout?')) {
                e.preventDefault();
            }
        });

        function playNotificationSound() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.value = 800;
                osc.type = 'sine';
                gain.gain.value = 0.3;
                osc.start();
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.3);
                osc.stop(ctx.currentTime + 0.3);
            } catch(e) {}
        }
    </script>
    @stack('scripts')
</body>
</html>
