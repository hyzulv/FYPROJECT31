@extends('layouts.app')

@section('title', 'Orders')
@section('page-title', 'View Orders')

@section('content')
<div class="data-card">
    <h3>All Orders</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Table</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order['id'] }}</td>
                <td>{{ $order['table'] }}</td>
                <td>{{ $order['items'] }}</td>
                <td>RM {{ $order['total'] }}</td>
                <td><span class="badge badge-{{ $order['status'] }}">{{ ucfirst($order['status']) }}</span></td>
                <td>{{ $order['time'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
