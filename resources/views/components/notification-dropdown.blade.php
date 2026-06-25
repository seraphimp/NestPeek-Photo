@php
$notifications = auth()->user()->notifications()->limit(10)->get();
$unreadCount = auth()->user()->unreadNotifications()->count();
@endphp

<div class="notification-dropdown" x-data="{ open: false }">
    <button @click="open = !open" class="notification-bell" @keydown.escape="open = false">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
        </svg>
        @if($unreadCount > 0)
        <span class="notification-badge">{{ $unreadCount }}</span>
        @endif
    </button>

    <div x-show="open" @click.away="open = false" class="notification-dropdown-menu">
        <div class="dropdown-header">
            <h4>Notifications</h4>
            @if($unreadCount > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="mark-all-read">Mark all as read</button>
            </form>
            @endif
        </div>

        <div class="dropdown-body">
            @if($notifications->isEmpty())
            <div class="empty-notification">
                <span class="empty-icon">🔔</span>
                <p>No notifications yet</p>
            </div>
            @else
            @foreach($notifications as $notification)
            <div class="notification-item {{ $notification->read_at ? '' : 'unread' }}">
                <div class="notification-icon">{{ $notification->data['icon'] ?? '🔔' }}</div>
                <div class="notification-content">
                    <p class="notification-message">{{ $notification->data['message'] ?? 'New notification' }}</p>
                    <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                    @if(isset($notification->data['studio_name']))
                    <span class="notification-studio">🏢 {{ $notification->data['studio_name'] }}</span>
                    @endif
                </div>
                @if(!$notification->read_at)
                <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="notification-dot-btn" title="Mark as read">
                        <span class="notification-dot"></span>
                    </button>
                </form>
                @endif
            </div>
            @endforeach
            @endif
        </div>

        <div class="dropdown-footer">
            <a href="{{ route('notifications.index') }}">View all notifications</a>
        </div>
    </div>
</div>

<style>
    .notification-dropdown {
        position: relative;
        display: inline-block;
    }

    .notification-bell {
        background: none;
        border: none;
        cursor: pointer;
        color: #64748B;
        padding: 8px;
        border-radius: 50%;
        transition: background 0.2s;
        position: relative;
    }

    .notification-bell:hover {
        background: #F0F9FF;
        color: #0369A1;
    }

    .notification-badge {
        position: absolute;
        top: 2px;
        right: 2px;
        background: #EF4444;
        color: white;
        font-size: 0.6rem;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 50%;
        min-width: 18px;
        text-align: center;
        border: 2px solid white;
    }

    .notification-dropdown-menu {
        position: absolute;
        right: 0;
        top: calc(100% + 8px);
        width: 380px;
        max-height: 500px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        border: 1.5px solid rgba(14, 165, 233, 0.14);
        overflow: hidden;
        z-index: 1000;
    }

    .dropdown-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        border-bottom: 1px solid rgba(14, 165, 233, 0.1);
    }

    .dropdown-header h4 {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        color: #0F172A;
        margin: 0;
    }

    .mark-all-read {
        background: none;
        border: none;
        color: #0EA5E9;
        font-size: 0.7rem;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: color 0.2s;
    }

    .mark-all-read:hover {
        color: #0369A1;
    }

    .dropdown-body {
        max-height: 350px;
        overflow-y: auto;
    }

    .empty-notification {
        padding: 40px 20px;
        text-align: center;
        color: #94A3B8;
    }

    .empty-icon {
        font-size: 2rem;
        display: block;
        margin-bottom: 8px;
    }

    .notification-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 20px;
        transition: background 0.15s;
        position: relative;
        border-bottom: 1px solid rgba(14, 165, 233, 0.05);
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item:hover {
        background: #F8FAFC;
    }

    .notification-item.unread {
        background: #F0F9FF;
    }

    .notification-item.unread:hover {
        background: #E0F2FE;
    }

    .notification-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #F0F9FF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .notification-content {
        flex: 1;
        min-width: 0;
    }

    .notification-message {
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        color: #0F172A;
        margin: 0 0 4px;
        line-height: 1.5;
    }

    .notification-time {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem;
        color: #94A3B8;
        letter-spacing: 0.04em;
    }

    .notification-studio {
        display: inline-block;
        font-size: 0.65rem;
        color: #0369A1;
        background: #F0F9FF;
        padding: 2px 8px;
        border-radius: 10px;
        margin-top: 4px;
    }

    .notification-dot-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        margin-top: 4px;
    }

    .notification-dot {
        display: block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #0EA5E9;
        transition: transform 0.2s;
    }

    .notification-dot-btn:hover .notification-dot {
        transform: scale(1.3);
    }

    .dropdown-footer {
        padding: 12px 20px;
        border-top: 1px solid rgba(14, 165, 233, 0.1);
        text-align: center;
    }

    .dropdown-footer a {
        font-family: 'Inter', sans-serif;
        font-size: 0.78rem;
        color: #0EA5E9;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .dropdown-footer a:hover {
        color: #0369A1;
    }
</style>