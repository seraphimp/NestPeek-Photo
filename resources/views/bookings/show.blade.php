@extends('layouts.app')

@section('title', 'Booking ' . $booking->booking_number . ' — NestPeek Photo')

@section('content')
<style>
    :root {
        --sky: #0EA5E9;
        --sky-light: #38BDF8;
        --sky-mid: #0369A1;
        --navy: #0C4A6E;
        --sky-faint: #F0F9FF;
        --sky-pale: #E0F2FE;
        --slate: #64748B;
        --slate-mid: #94A3B8;
        --slate-light: #CBD5E1;
        --text-main: #0F172A;
        --text-muted: #475569;
        --border: rgba(14, 165, 233, 0.14);
        --green: #10B981;
        --green-faint: rgba(16, 185, 129, 0.08);
        --green-border: rgba(16, 185, 129, 0.25);
        --amber: #F59E0B;
        --amber-faint: rgba(245, 158, 11, 0.08);
        --red: #EF4444;
        --red-faint: rgba(239, 68, 68, 0.08);
    }

    .booking-page {
        max-width: 900px;
        margin: 0 auto;
        padding: 32px 24px 60px;
    }

    /* Header */
    .booking-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .booking-header-left {
        flex: 1;
    }

    .booking-eyebrow {
        font-family: 'DM Mono', monospace;
        font-size: 0.63rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--sky-mid);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
    }

    .booking-eyebrow::before {
        content: '';
        display: inline-block;
        width: 20px;
        height: 1px;
        background: var(--sky-light);
    }

    .booking-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.8rem;
        font-weight: 400;
        color: var(--navy);
        line-height: 1.2;
        margin: 0;
    }

    .booking-sub {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-top: 4px;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        flex-shrink: 0;
    }

    .status-badge .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-badge-pending {
        background: var(--amber-faint);
        color: #B45309;
        border: 1.5px solid rgba(245, 158, 11, 0.25);
    }

    .status-badge-pending .dot {
        background: var(--amber);
    }

    .status-badge-confirmed {
        background: var(--green-faint);
        color: #065F46;
        border: 1.5px solid var(--green-border);
    }

    .status-badge-confirmed .dot {
        background: var(--green);
    }

    .status-badge-completed {
        background: var(--sky-faint);
        color: var(--sky-mid);
        border: 1.5px solid var(--border);
    }

    .status-badge-completed .dot {
        background: var(--sky);
    }

    .status-badge-cancelled {
        background: var(--red-faint);
        color: #991B1B;
        border: 1.5px solid rgba(239, 68, 68, 0.25);
    }

    .status-badge-cancelled .dot {
        background: var(--red);
    }

    /* Cards */
    .detail-card {
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 20px;
        box-shadow: 0 2px 16px rgba(14, 165, 233, 0.05);
        overflow: hidden;
        margin-bottom: 20px;
        transition: border-color 0.2s;
    }

    .detail-card:hover {
        border-color: rgba(14, 165, 233, 0.28);
    }

    .detail-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 18px 24px 0;
        font-family: 'DM Mono', monospace;
        font-size: 0.62rem;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--slate-mid);
    }

    .detail-card-header .icon {
        font-size: 1.1rem;
    }

    .detail-card-body {
        padding: 16px 24px 24px;
    }

    /* Grid Layout */
    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px 24px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .detail-item.full-width {
        grid-column: 1 / -1;
    }

    .detail-label {
        font-size: 0.7rem;
        font-weight: 500;
        color: var(--slate-mid);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .detail-value {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-main);
        word-break: break-word;
    }

    .detail-value.currency {
        font-family: 'DM Mono', monospace;
    }

    /* Payment Summary */
    .payment-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        font-size: 0.85rem;
    }

    .payment-row .label {
        color: var(--slate);
    }

    .payment-row .value {
        font-weight: 500;
        color: var(--text-main);
    }

    .payment-row.total {
        border-top: 2px solid var(--border);
        margin-top: 6px;
        padding-top: 12px;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .payment-row.total .value {
        color: var(--navy);
        font-size: 1.05rem;
    }

    .payment-row .value.paid {
        color: var(--green);
    }

    .payment-row .value.due {
        color: var(--red);
    }

    /* Creator Info */
    .creator-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .creator-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--sky-pale), var(--sky-light));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--sky-mid);
        flex-shrink: 0;
        overflow: hidden;
    }

    .creator-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .creator-name {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--navy);
    }

    .creator-role {
        font-size: 0.75rem;
        color: var(--slate);
    }

    /* Actions */
    .actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 8px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 22px;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-secondary {
        background: var(--sky-faint);
        color: var(--sky-mid);
        border: 1.5px solid var(--border);
    }

    .btn-secondary:hover {
        background: var(--sky-pale);
        border-color: var(--sky);
        transform: translateY(-1px);
    }

    .btn-danger {
        background: var(--red-faint);
        color: #991B1B;
        border: 1.5px solid rgba(239, 68, 68, 0.25);
    }

    .btn-danger:hover {
        background: var(--red);
        color: #fff;
        border-color: var(--red);
        transform: translateY(-1px);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--sky), var(--sky-mid));
        color: #fff;
        border: none;
        box-shadow: 0 4px 14px rgba(14, 165, 233, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(14, 165, 233, 0.4);
    }

    /* Success Message */
    .alert-success {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 20px;
        background: var(--green-faint);
        border: 1.5px solid var(--green-border);
        border-radius: 14px;
        color: #065F46;
        margin-bottom: 20px;
    }

    .alert-success .icon {
        font-size: 1.2rem;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .booking-header {
            flex-direction: column;
        }

        .booking-title {
            font-size: 1.4rem;
        }

        .details-grid {
            grid-template-columns: 1fr;
        }

        .detail-item.full-width {
            grid-column: 1;
        }

        .actions {
            flex-direction: column;
        }

        .actions .btn {
            width: 100%;
            justify-content: center;
        }

        .detail-card-body {
            padding: 12px 16px 18px;
        }
    }

    /* Print Styles */
    @media print {
        .actions {
            display: none;
        }

        .detail-card {
            border: 1px solid #ddd;
            box-shadow: none;
        }

        .status-badge {
            border: 1px solid #ddd;
        }
    }
</style>

<div class="booking-page">

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert-success">
        <span class="icon">✅</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- Header --}}
    <div class="booking-header">
        <div class="booking-header-left">
            <p class="booking-eyebrow">Booking Details</p>
            <h1 class="booking-title">{{ $booking->booking_number }}</h1>
            <p class="booking-sub">
                Created {{ $booking->created_at->format('F j, Y g:i A') }}
            </p>
        </div>
        <div>
            <span class="status-badge status-badge-{{ $booking->status }}">
                <span class="dot"></span>
                {{ ucfirst($booking->status) }}
            </span>
        </div>
    </div>

    {{-- Booking Details --}}
    <div class="detail-card">
        <div class="detail-card-header">
            <span class="icon">📋</span>
            Booking Information
        </div>
        <div class="detail-card-body">
            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label">Booking #</span>
                    <span class="detail-value">{{ $booking->booking_number }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Service</span>
                    <span class="detail-value">{{ $booking->service->name }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Event Date</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->event_date)->format('l, F j, Y') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Time</span>
                    <span class="detail-value">
                        @if($booking->start_time)
                        {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}
                        @if($booking->end_time)
                        – {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}
                        @endif
                        @else
                        <span class="text-gray-400">Not specified</span>
                        @endif
                    </span>
                </div>
                @if($booking->event_type)
                <div class="detail-item">
                    <span class="detail-label">Event Type</span>
                    <span class="detail-value">{{ $booking->event_type }}</span>
                </div>
                @endif
                @if($booking->venue)
                <div class="detail-item">
                    <span class="detail-label">Venue</span>
                    <span class="detail-value">{{ $booking->venue }}</span>
                </div>
                @endif
                @if($booking->notes)
                <div class="detail-item full-width">
                    <span class="detail-label">Notes</span>
                    <span class="detail-value" style="white-space:pre-wrap;">{{ $booking->notes }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Payment Summary --}}
    <div class="detail-card">
        <div class="detail-card-header">
            <span class="icon">💰</span>
            Payment Summary
        </div>
        <div class="detail-card-body">
            <div class="payment-row">
                <span class="label">Subtotal</span>
                <span class="value currency">₱{{ number_format($booking->subtotal, 2) }}</span>
            </div>
            <div class="payment-row">
                <span class="label">Deposit Required</span>
                <span class="value currency">₱{{ number_format($booking->deposit_amount, 2) }}</span>
            </div>
            <div class="payment-row">
                <span class="label">Amount Paid</span>
                <span class="value currency paid">₱{{ number_format($booking->amount_paid, 2) }}</span>
            </div>
            <div class="payment-row total">
                <span class="label">Amount Due</span>
                <span class="value currency due">₱{{ number_format($booking->amount_due, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Creator Info --}}
    @if($booking->creatorProfile)
    <div class="detail-card">
        <div class="detail-card-header">
            <span class="icon">👤</span>
            Creator
        </div>
        <div class="detail-card-body">
            <div class="creator-info">
                <div class="creator-avatar">
                    @if($booking->creatorProfile->user->avatar)
                    <img src="{{ asset('storage/' . $booking->creatorProfile->user->avatar) }}"
                        alt="{{ $booking->creatorProfile->user->name }}">
                    @else
                    {{ strtoupper(substr($booking->creatorProfile->user->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="creator-name">{{ $booking->creatorProfile->user->name }}</div>
                    <div class="creator-role">
                        {{ $booking->creatorProfile->brand_name ?? 'Freelancer' }}
                        @if($booking->creatorProfile->specialization)
                        · {{ ucfirst(str_replace('_', ' ', $booking->creatorProfile->specialization)) }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Studio Info --}}
    @if($booking->studio)
    <div class="detail-card">
        <div class="detail-card-header">
            <span class="icon">🏢</span>
            Studio
        </div>
        <div class="detail-card-body">
            <div class="creator-info">
                <div class="creator-avatar" style="background: linear-gradient(135deg, #F5F3FF, #EDE9FE); color: var(--studio-mid);">
                    @if($booking->studio->logo)
                    <img src="{{ asset('storage/' . $booking->studio->logo) }}"
                        alt="{{ $booking->studio->name }}">
                    @else
                    🏛️
                    @endif
                </div>
                <div>
                    <div class="creator-name">{{ $booking->studio->name }}</div>
                    <div class="creator-role">
                        @if($booking->studio->city)
                        📍 {{ $booking->studio->city }}
                        @endif
                        @if($booking->studio->is_active)
                        · <span style="color: var(--green);">Active</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Actions --}}
    <div class="actions">
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Back to Bookings
        </a>

        @if($booking->status === 'pending' && auth()->id() === $booking->client_id)
        <form method="POST" action="{{ route('bookings.cancel', $booking) }}" style="display:inline;">
            @csrf
            <button type="submit"
                onclick="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.')"
                class="btn btn-danger">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" />
                </svg>
                Cancel Booking
            </button>
        </form>
        @endif

        @if($booking->status === 'pending' && auth()->user()->isCreator() && $booking->creatorProfile?->user_id === auth()->id())
        <form method="POST" action="{{ route('bookings.accept', $booking) }}" style="display:inline;">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M20 6L9 17l-5-5" />
                </svg>
                Accept Booking
            </button>
        </form>
        <form method="POST" action="{{ route('bookings.decline', $booking) }}" style="display:inline;">
            @csrf
            @method('PATCH')
            <button type="submit"
                onclick="return confirm('Decline this booking?')"
                class="btn btn-danger">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" />
                </svg>
                Decline
            </button>
        </form>
        @endif

        {{-- Print Button --}}
        <button onclick="window.print()" class="btn btn-secondary" style="margin-left:auto;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9V3h12v6M6 21h12v-6H6v6z" />
                <path d="M18 9v9H6V9h12z" />
            </svg>
            Print
        </button>
    </div>

</div>
@endsection