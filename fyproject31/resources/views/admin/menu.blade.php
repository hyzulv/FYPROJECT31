@extends('layouts.app')

@section('title', 'Menu')
@section('page-title', 'View Menu')

@section('content')
<div class="data-card">
    <h3>Food Items</h3>
    @foreach($menu['food'] as $item)
    <div class="menu-item-card">
        <div class="menu-item-img">🍗</div>
        <div class="menu-item-info">
            <h4>{{ $item['name'] }}</h4>
            <p>{{ $item['description'] }}</p>
            <div class="price">RM {{ $item['price'] }}</div>
        </div>
    </div>
    @endforeach
</div>

<div class="data-card">
    <h3>Drinks</h3>
    @foreach($menu['drinks'] as $item)
    <div class="menu-item-card">
        <div class="menu-item-img">☕</div>
        <div class="menu-item-info">
            <h4>{{ $item['name'] }}</h4>
            <p>{{ $item['description'] }}</p>
            <div class="price">RM {{ $item['price'] }}</div>
        </div>
    </div>
    @endforeach
</div>
@endsection
