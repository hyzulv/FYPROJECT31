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
                <div style="position: relative;">
                    <input type="password" id="current_password" name="current_password" placeholder="Enter current password" required style="width: 100%; padding: 14px 45px 14px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 1rem;">
                    <img src="{{ asset('show_password.png') }}" id="toggle-current-icon" onclick="togglePassword('current_password', 'toggle-current-icon')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; opacity: 0.6; width: 20px;">
                </div>
            </div>

            <div class="cp-form-group">
                <label>New Password</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password" placeholder="Enter new password" minlength="6" required style="width: 100%; padding: 14px 45px 14px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 1rem;">
                    <img src="{{ asset('show_password.png') }}" id="toggle-password-icon" onclick="togglePassword('password', 'toggle-password-icon')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; opacity: 0.6; width: 20px;">
                </div>
            </div>

            <div class="cp-form-group">
                <label>Confirm New Password</label>
                <div style="position: relative;">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" minlength="6" required style="width: 100%; padding: 14px 45px 14px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 10px; color: #222; font-size: 1rem;">
                    <img src="{{ asset('show_password.png') }}" id="toggle-confirm-icon" onclick="togglePassword('password_confirmation', 'toggle-confirm-icon')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; opacity: 0.6; width: 20px;">
                </div>
            </div>

            <button type="submit" class="btn-submit">Update Password</button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route($userRole . '.profile') }}" style="color: #420C09; text-decoration: none; font-size: 0.9rem;">← Back to Profile</a>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    var input = document.getElementById(inputId);
    var icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.src = "{{ asset('hide_password.png') }}";
    } else {
        input.type = 'password';
        icon.src = "{{ asset('show_password.png') }}";
    }
}
</script>
@endsection
