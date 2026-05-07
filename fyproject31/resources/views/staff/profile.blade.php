@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="profile-container">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="profile-layout">
        <div class="profile-left">
            <div class="profile-card-full">
                <div class="profile-avatar-large">{{ substr($profile['name'] ?? 'User', 0, 1) }}</div>
                <h2 class="profile-name">{{ $profile['name'] ?? 'User' }}</h2>
                <span class="profile-role-badge">{{ ucfirst($profile['role']) }}</span>
                <div class="profile-details-grid">
                    <div class="detail-item">
                        <span class="detail-icon">📧</span>
                        <div class="detail-text">
                            <span class="detail-label">Email</span>
                            <span class="detail-value">{{ $profile['email'] ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <span class="detail-icon">👤</span>
                        <div class="detail-text">
                            <span class="detail-label">Username</span>
                            <span class="detail-value">{{ $profile['username'] ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <span class="detail-icon">📱</span>
                        <div class="detail-text">
                            <span class="detail-label">Phone</span>
                            <span class="detail-value">{{ $profile['phone'] ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <span class="detail-icon">📅</span>
                        <div class="detail-text">
                            <span class="detail-label">Joined</span>
                            <span class="detail-value">{{ $profile['join_date'] ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <span class="detail-icon">🟢</span>
                        <div class="detail-text">
                            <span class="detail-label">Status</span>
                            <span class="detail-value active-text">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-right">
            <div class="edit-card">
                <h3>Edit Profile</h3>
                <form action="{{ route($prefix . '.profile.update') }}" method="POST">
                    @csrf
                    <div class="edit-form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $profile['name'] ?? '' }}" required>
                    </div>
                    <div class="edit-form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $profile['email'] ?? '' }}" required>
                    </div>
                    <div class="edit-form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ $profile['phone'] ?? '' }}">
                    </div>
                    <button type="submit" class="btn-save">Save Changes</button>
                </form>
            </div>

            <div class="security-card">
                <h3>Security</h3>
                <p>Change your password to keep your account secure</p>
                <a href="{{ route($prefix . '.change-password') }}" class="btn-change-password">
                    🔒 Change Password
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
