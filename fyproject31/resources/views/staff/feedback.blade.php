@extends('layouts.app')

@section('title', 'Feedback')
@section('page-title', 'View Feedback')

@section('content')
<div class="data-card">
    <h3>Customer Feedback</h3>
    @foreach($feedbacks as $fb)
    <div class="feedback-card">
        <div class="feedback-header">
            <h4>{{ $fb['customer'] }}</h4>
            <div class="feedback-rating">{{ str_repeat('⭐', $fb['rating']) }}</div>
        </div>
        <p class="feedback-text">{{ $fb['message'] }}</p>
        <p style="color: #666; font-size: 0.85rem; margin-top: 10px;">{{ $fb['date'] }}</p>
    </div>
    @endforeach
</div>
@endsection
