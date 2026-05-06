@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'View Profile')

@section('content')
<div class="profile-card">
    <div class="profile-avatar">{{ substr($admin['name'] ?? 'Admin', 0, 1) }}</div>
    <div class="profile-info">
        <h3>{{ $admin['name'] ?? 'Admin User' }}</h3>
        <div class="profile-detail">
            <span class="label">Email</span>
            <span class="value">{{ $admin['email'] ?? 'admin@matrock.com' }}</span>
        </div>
        <div class="profile-detail">
            <span class="label">Role</span>
            <span class="value"><span class="badge badge-admin">{{ ucfirst($admin['role'] ?? 'Admin') }}</span></span>
        </div>
        <div class="profile-detail">
            <span class="label">Phone</span>
            <span class="value">{{ $admin['phone'] ?? '+60 11-123 4567' }}</span>
        </div>
        <div class="profile-detail">
            <span class="label">Join Date</span>
            <span class="value">{{ $admin['join_date'] ?? 'January 2023' }}</span>
        </div>
        <div class="profile-detail">
            <span class="label">Status</span>
            <span class="value"><span class="badge badge-completed">Active</span></span>
        </div>
    </div>
</div>
@endsection
