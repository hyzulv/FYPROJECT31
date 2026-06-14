<div class="sidebar-header">
    <div class="sidebar-brand">
        <img src="{{ asset('images/icons/logo-circle.png') }}" alt="MAT ROCK" class="sidebar-logo">
        <div class="sidebar-brand-text">
            <h2>MAT ROCK</h2>
            <p>{{ ucfirst($userRole ?? 'staff') }} Dashboard</p>
        </div>
    </div>
</div>

<ul class="sidebar-menu">
    <li>
        <a href="{{ route($userRole === 'admin' ? 'admin.dashboard' : 'staff.dashboard') }}" class="{{ request()->routeIs($userRole === 'admin' ? 'admin.dashboard' : 'staff.dashboard') ? 'active' : '' }}">
            <span class="icon">📊</span>
            <span>Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ route($userRole === 'admin' ? 'admin.profile' : 'staff.profile') }}" class="{{ request()->routeIs($userRole === 'admin' ? 'admin.profile' : 'staff.profile') ? 'active' : '' }}">
            <span class="icon">👤</span>
            <span>View Profile</span>
        </a>
    </li>
    <li>
        <a href="{{ route($userRole === 'admin' ? 'admin.orders' : 'staff.orders') }}" class="{{ request()->routeIs($userRole === 'admin' ? 'admin.orders' : 'staff.orders') ? 'active' : '' }}">
            <span class="icon">📋</span>
            <span>View Orders</span>
        </a>
    </li>
    <li>
        <a href="{{ route($userRole === 'admin' ? 'admin.menu' : 'staff.menu') }}" class="{{ request()->routeIs($userRole === 'admin' ? 'admin.menu' : 'staff.menu') ? 'active' : '' }}">
            <span class="icon">🍽️</span>
            <span>View Menu</span>
        </a>
    </li>
    <li>
        <a href="{{ route($userRole === 'admin' ? 'admin.feedback' : 'staff.feedback') }}" class="{{ request()->routeIs($userRole === 'admin' ? 'admin.feedback' : 'staff.feedback') ? 'active' : '' }}">
            <span class="icon">💬</span>
            <span>View Feedback</span>
        </a>
    </li>
    @if($userRole === 'admin')
    <li>
        <a href="{{ route('admin.staff') }}" class="{{ request()->routeIs('admin.staff') ? 'active' : '' }}">
            <span class="icon">👥</span>
            <span>View Staff</span>
        </a>
    </li>
    @endif
</ul>
