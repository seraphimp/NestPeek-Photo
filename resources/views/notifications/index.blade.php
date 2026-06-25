@extends('layouts.app')

@section('title', 'Notifications — NestPeek Photo')

@section('content')
<div class="notifications-page">
    <div class="page-header">
        <div>
            <p class="page-eyebrow">Your Updates</p>
            <h1 class="page-title">Notifications</h1>
            <p class="page-sub">Stay updated with your studio and booking activity</p>
        </div>
        @if($unreadCount > 0)
        <form action="{{ route('notifications.mark-all-read') }}" method="POST">
            @csrf
            <button class="btn-primary">Mark all as read</button>
        </form>
        @endif
    </div>

    <div class="notifications-list">
        @forelse($notifications as $notification)
        <div class="notification-card {{ $notification->read_at ? '' : 'unread' }}">
            <div class="notification-icon-large">{{ $notification->data['icon'] ?? '🔔' }}</div>
            <div class="notification-body">
                <p class="notification-message">{{ $notification->data['message'] ?? 'New notification' }}</p>
                @if(isset($notification->data['studio_name']))
                <p class="notification-studio-name">🏢 {{ $notification->data['studio_name'] }}</p>
                @endif
                <div class="notification-footer">
                    <span class="notification-time">{{ $notification->created_at->format('F j, Y g:i A') }}</span>
                    @if(!$notification->read_at)
                    <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="mark-read-btn">Mark as read</button>
                    </form>
                    @endif
                    @if(isset($notification->data['action_url']))
                    <a href="{{ $notification->data['action_url'] }}" class="view-action-btn">View →</a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">🔔</div>
            <h3>All caught up!</h3>
            <p>You have no notifications at the moment.</p>
        </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">{{ $notifications->links() }}</div>
</div>

<style>
    .notifications-page {
        max-width: 800px;
        margin: 0 auto;
        padding: 32px 24px;
    }

    .page-eyebrow {
        font-family: 'DM Mono', monospace;
        font-size: 0.63rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: #0369A1;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
    }

    .page-eyebrow::before {
        content: '';
        display: inline-block;
        width: 20px;
        height: 1px;
        background: #38BDF8;
    }

    .page-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.8rem;
        font-weight: 400;
        color: #0C4A6E;
        line-height: 1.2;
    }

    .page-sub {
        font-size: 0.85rem;
        color: #475569;
        margin-top: 4px;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 22px;
        background: linear-gradient(135deg, #0EA5E9, #0369A1);
        color: #fff;
        border: none;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(14, 165, 233, 0.3);
        transition: all 0.2s;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(14, 165, 233, 0.4);
    }

    .notifications-list {
        margin-top: 24px;
    }

    .notification-card {
        display: flex;
        gap: 16px;
        padding: 18px 20px;
        background: #fff;
        border: 1.5px solid rgba(14, 165, 233, 0.14);
        border-radius: 16px;
        margin-bottom: 12px;
        transition: all 0.2s;
    }

    .notification-card.unread {
        background: #F0F9FF;
        border-color: rgba(14, 165, 233, 0.28);
    }

    .notification-card:hover {
        border-color: rgba(14, 165, 233, 0.4);
    }

    .notification-icon-large {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #E0F2FE;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .notification-body {
        flex: 1;
        min-width: 0;
    }

    .notification-message {
        font-family: 'Inter', sans-serif;
        font-size: 0.88rem;
        color: #0F172A;
        margin: 0 0 6px;
        line-height: 1.6;
    }

    .notification-studio-name {
        font-size: 0.78rem;
        color: #0369A1;
        font-weight: 600;
        margin: 0 0 8px;
    }

    .notification-footer {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .notification-time {
        font-family: 'DM Mono', monospace;
        font-size: 0.63rem;
        color: #94A3B8;
    }

    .mark-read-btn {
        background: none;
        border: none;
        color: #0EA5E9;
        font-size: 0.7rem;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        padding: 0;
        transition: color 0.2s;
    }

    .mark-read-btn:hover {
        color: #0369A1;
    }

    .view-action-btn {
        font-size: 0.7rem;
        color: #0EA5E9;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .view-action-btn:hover {
        color: #0369A1;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94A3B8;
    }

    .empty-icon {
        font-size: 3rem;
        display: block;
        margin-bottom: 16px;
    }

    .empty-state h3 {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.2rem;
        color: #0F172A;
        margin: 0 0 8px;
    }

    .empty-state p {
        font-size: 0.85rem;
        color: #64748B;
        margin: 0;
    }

    .pagination-wrapper {
        margin-top: 24px;
        text-align: center;
    }
</style>
@endsection