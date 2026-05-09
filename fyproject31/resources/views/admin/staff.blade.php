@extends('layouts.app')

@section('title', 'Staff')
@section('page-title', 'Manage Staff')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

<div class="data-card">
    <h3>Add New Staff</h3>
    <form action="{{ route('admin.staff.add') }}" method="POST" autocomplete="off" style="display: grid; gap: 1rem; max-width: 500px;">
        @csrf
        <div>
            <label>Name</label>
            <input type="text" name="name" required style="width: 100%; padding: 8px;">
        </div>
        <div>
            <label>Username</label>
            <input type="text" name="username" required style="width: 100%; padding: 8px;">
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" required style="width: 100%; padding: 8px;">
        </div>
        <div>
            <label>Password</label>
            <div style="position: relative;">
                <input type="password" id="staff_password" name="password" required minlength="6" style="width: 100%; padding: 8px 45px 8px 8px;">
                <img src="{{ asset('show_password.png') }}" id="toggle-staff-icon" onclick="togglePassword('staff_password', 'toggle-staff-icon')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; opacity: 0.6; width: 20px; filter: brightness(0) invert(1);">
            </div>
        </div>
        <div>
            <label>Role</label>
            <select name="role" required style="width: 100%; padding: 8px;">
                <option value="staff">Staff</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div>
            <label>Phone</label>
            <input type="text" name="phone" style="width: 100%; padding: 8px;">
        </div>
        <button type="submit" style="padding: 10px 20px; background: #cf2c21; color: white; border: none; cursor: pointer;">Add Staff</button>
    </form>
</div>

<div class="data-card" style="margin-top: 2rem;">
    <h3>Staff Members</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $s)
            <tr>
                <td>{{ $s['name'] }}</td>
                <td>{{ $s['username'] }}</td>
                <td>{{ $s['email'] }}</td>
                <td><span class="badge badge-{{ $s['role'] }}">{{ ucfirst($s['role']) }}</span></td>
                <td>{{ $s['phone'] }}</td>
                <td><span class="badge badge-{{ strtolower($s['status']) }}">{{ $s['status'] }}</span></td>
                <td>
                    <form action="{{ route('admin.staff.delete', $s['id']) }}" method="POST" onsubmit="return confirm('Delete this staff?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #dc3545; color: white; border: none; padding: 5px 10px; cursor: pointer;">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="data-card" style="margin-top: 2rem;">
    <h3>Sync Database</h3>
    <p>After adding/removing staff, run this command to sync with your friend:</p>
    <code style="display: block; background: #f4f4f4; padding: 10px; margin: 10px 0;">php artisan db:sync</code>
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

document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
    document.querySelector('form[action="{{ route('admin.staff.add') }}"]')?.reset();
    @endif
});
</script>
@endsection
