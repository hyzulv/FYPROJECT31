@extends('layouts.app')

@section('title', 'Change Password')
@section('page-title', 'Change Password')

@section('content')
<div class="change-password-container">
    @if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="change-password-card">
        <div class="profile-avatar-large" style="margin: 0 auto 20px;">🔒</div>
        <h2>Change Password</h2>
        <p class="subtitle">Enter your current password and choose a new one</p>

        <form action="{{ route($userRole . '.change-password.submit') }}" method="POST">
            @csrf
            <div class="cp-form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" placeholder="Enter current password" required>
            </div>

            <div class="cp-form-group">
                <label>New Password</label>
                <input type="password" name="password" placeholder="Enter new password" minlength="6" required>
            </div>

            <div class="cp-form-group">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm new password" minlength="6" required>
            </div>

            <button type="submit" class="btn-submit">Update Password</button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route($userRole . '.profile') }}" style="color: #d1986a; text-decoration: none; font-size: 0.9rem;">← Back to Profile</a>
        </div>
    </div>
</div>
@endsection
