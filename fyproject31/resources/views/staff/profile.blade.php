@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'View Profile')

@section('content')
<div class="profile-card">
    <div class="profile-avatar">{{ substr($staff['name'] ?? 'John', 0, 1) }}</div>
    <div class="profile-info">
        <h3>{{ $staff['name'] ?? 'John Doe' }}</h3>
        <div class="profile-detail">
            <span class="label">Email</span>
            <span class="value">{{ $staff['email'] ?? 'john@matrock.com' }}</span>
        </div>
        <div class="profile-detail">
            <span class="label">Role</span>
            <span class="value">{{ ucfirst($staff['role'] ?? 'Staff') }}</span>
        </div>
        <div class="profile-detail">
            <span class="label">Phone</span>
            <span class="value">{{ $staff['phone'] ?? '+60 12-345 6789' }}</span>
        </div>
        <div class="profile-detail">
            <span class="label">Join Date</span>
            <span class="value">{{ $staff['join_date'] ?? 'January 2024' }}</span>
        </div>
        <div class="profile-detail">
            <span class="label">Status</span>
            <span class="value"><span class="badge badge-completed">Active</span></span>
        </div>
    </div>
</div>
@endsection
