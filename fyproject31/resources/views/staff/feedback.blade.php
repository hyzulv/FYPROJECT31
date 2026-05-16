@extends('layouts.app')

@section('title', 'Feedback')
@section('page-title', 'View Feedback')

@section('content')
<div class="data-card">
    <h3>Customer Feedback</h3>

    <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
        <span style="font-weight: bold; color: #420C09; margin-right: 5px;">Filter by:</span>
        <a href="{{ route('staff.feedback') }}"
           style="padding: 6px 14px; border-radius: 20px; text-decoration: none; font-size: 0.9rem;
                  {{ is_null($selectedRating) ? 'background: #420C09; color: #fff;' : 'background: #eee; color: #555;' }}">All</a>
        @for($i = 1; $i <= 5; $i++)
        <a href="{{ route('staff.feedback', ['rating' => $i]) }}"
           style="padding: 6px 14px; border-radius: 20px; text-decoration: none; font-size: 0.9rem;
                  {{ $selectedRating === $i ? 'background: #420C09; color: #fff;' : 'background: #eee; color: #555;' }}">
            {{ str_repeat('⭐', $i) }}
        </a>
        @endfor
    </div>

    @forelse($feedbacks as $fb)
    <div class="feedback-card">
        <div class="feedback-header">
            <h4>{{ $fb['customer'] }}</h4>
            <div class="feedback-rating">{{ str_repeat('⭐', $fb['rating']) }}</div>
        </div>
        <p class="feedback-text">{{ $fb['message'] }}</p>
        <p style="color: #666; font-size: 0.85rem; margin-top: 10px;">{{ $fb['date'] }}</p>
    </div>
    @empty
    <p style="text-align: center; color: #666; padding: 30px 0;">No feedback found.</p>
    @endforelse
</div>
@endsection
