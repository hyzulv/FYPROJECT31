@extends('layouts.app')

@section('title', 'Staff')
@section('page-title', 'View Staff')

@section('content')
<div class="data-card">
    <h3>Staff Members</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $s)
            <tr>
                <td>{{ $s['name'] }}</td>
                <td>{{ $s['email'] }}</td>
                <td><span class="badge badge-{{ $s['role'] }}">{{ ucfirst($s['role']) }}</span></td>
                <td>{{ $s['phone'] }}</td>
                <td><span class="badge badge-{{ strtolower($s['status']) }}">{{ $s['status'] }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
