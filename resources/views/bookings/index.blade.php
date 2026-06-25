@php $isCreator = !auth()->user()->isClient(); @endphp

@if(!$isCreator)
{{-- ════════════════════════════════════════════════════════ --}}
{{-- CLIENT VIEW                                           --}}
{{-- ════════════════════════════════════════════════════════ --}}
@extends('layouts.app')

@section('title', 'My Bookings — NestPeek Photo')

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
        --border-mid: rgba(14, 165, 233, 0.28);
        --green: #10B981;
        --green-faint: rgba(16, 185, 129, 0.08);
        --green-border: rgba(16, 185, 129, 0.25);
        --amber: #F59E0B;
        --amber-faint: rgba(245, 158, 11, 0.08);
        --red: #EF4444;
        --red-faint: rgba(239, 68, 68, 0.08);
    }

    .bookings-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 32px 24px 60px;
    }

    .page-eyebrow {
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

    .page-eyebrow::before {
        content: '';
        display: inline-block;
        width: 20px;
        height: 1px;
        background: var(--sky-light);
    }

    .page-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.8rem;
        font-weight: 400;
        color: var(--navy);
        line-height: 1.2;
        margin: 0;
    }

    .page-sub {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-top: 4px;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

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

    .card {
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 20px;
        box-shadow: 0 2px 16px rgba(14, 165, 233, 0.05);
        overflow: hidden;
        transition: border-color 0.2s;
    }

    .card:hover {
        border-color: rgba(14, 165, 233, 0.28);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .bookings-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
    }

    .bookings-table thead tr {
        background: var(--sky-faint);
        border-bottom: 1.5px solid var(--border);
    }

    .bookings-table th {
        padding: 14px 20px;
        text-align: left;
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--slate-mid);
        font-weight: 600;
        white-space: nowrap;
    }

    .bookings-table td {
        padding: 14px 20px;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    .bookings-table tbody tr:last-child td {
        border-bottom: none;
    }

    .bookings-table tbody tr:hover td {
        background: var(--sky-faint);
    }

    .booking-number {
        font-family: 'DM Mono', monospace;
        font-size: 0.8rem;
        color: var(--sky-mid);
        font-weight: 600;
    }

    .client-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .client-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--sky-pale), var(--sky-light));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--sky-mid);
        flex-shrink: 0;
        overflow: hidden;
    }

    .client-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .client-name {
        font-weight: 600;
        color: var(--navy);
    }

    .client-email {
        font-size: 0.7rem;
        color: var(--text-muted);
    }

    .amount {
        font-family: 'DM Mono', monospace;
        font-weight: 600;
        color: var(--navy);
        font-size: 0.9rem;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.67rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .badge-pending {
        background: var(--amber-faint);
        color: #B45309;
        border: 1px solid rgba(245, 158, 11, 0.25);
    }

    .badge-confirmed {
        background: var(--sky-faint);
        color: var(--sky-mid);
        border: 1px solid var(--border-mid);
    }

    .badge-completed {
        background: var(--green-faint);
        color: #065F46;
        border: 1px solid var(--green-border);
    }

    .badge-cancelled {
        background: var(--red-faint);
        color: #991B1B;
        border: 1px solid rgba(239, 68, 68, 0.25);
    }

    .badge-deposit_paid {
        background: #E0F2FE;
        color: #0369A1;
        border: 1px solid rgba(14, 165, 233, 0.25);
    }

    .badge-in_progress {
        background: #FEF3C7;
        color: #B45309;
        border: 1px solid rgba(245, 158, 11, 0.25);
    }

    .action-group {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: 1.5px solid;
        font-family: 'Inter', sans-serif;
        transition: all 0.2s;
        background: #fff;
    }

    .btn-view {
        color: var(--sky-mid);
        border-color: var(--border-mid);
    }

    .btn-view:hover {
        background: var(--sky-faint);
        border-color: var(--sky);
    }

    .btn-confirm {
        color: #065F46;
        border-color: var(--green-border);
        background: var(--green-faint);
    }

    .btn-confirm:hover {
        background: #D1FAE5;
        border-color: var(--green);
    }

    .btn-decline {
        color: #991B1B;
        border-color: rgba(239, 68, 68, 0.25);
        background: var(--red-faint);
    }

    .btn-decline:hover {
        background: #FEE2E2;
        border-color: var(--red);
    }

    .btn-cancel {
        color: var(--red);
        border-color: var(--red-border);
        background: var(--red-faint);
    }

    .btn-cancel:hover {
        background: #FEE2E2;
        border-color: var(--red);
    }

    .empty-state {
        text-align: center;
        padding: 60px 24px;
    }

    .empty-state .icon {
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
        font-size: 0.9rem;
        color: var(--text-muted);
        margin: 0;
    }

    .pagination-wrapper {
        padding: 16px 20px;
        border-top: 1px solid var(--border);
    }

    @media (max-width: 640px) {
        .bookings-page {
            padding: 20px 16px 40px;
        }

        .page-title {
            font-size: 1.4rem;
        }

        .bookings-table th,
        .bookings-table td {
            padding: 10px 12px;
            font-size: 0.75rem;
        }

        .client-cell {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }
    }
</style>

<div class="bookings-page">

    {{-- Header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:28px;gap:16px;flex-wrap:wrap;">
        <div>
            <p class="page-eyebrow">Your Bookings</p>
            <h1 class="page-title">My Bookings</h1>
            <p class="page-sub">Track and manage all your booking requests</p>
        </div>
        <div class="header-actions">
            <span style="font-size:0.78rem;color:var(--slate);">
                Total: <strong style="color:var(--navy);">{{ $bookings->total() }}</strong>
            </span>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert-success">
        <span class="icon">✅</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- Filter Tabs --}}
    <div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;">
        @foreach(['all' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
        <a href="{{ route('bookings.index', ['status' => $value === 'all' ? null : $value]) }}"
            style="font-size:0.8rem;font-weight:600;padding:6px 18px;border-radius:50px;text-decoration:none;border:1.5px solid;transition:all 0.15s;
                {{ (request('status', 'all') === $value) 
                    ? 'background:var(--sky);color:#fff;border-color:var(--sky);' 
                    : 'background:#fff;color:var(--slate);border-color:var(--border);' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Bookings Table --}}
    @if($bookings->isEmpty())
    <div class="card empty-state">
        <span class="icon">📭</span>
        <h3>No bookings found</h3>
        <p>{{ request('status') ? 'No bookings with this status yet.' : 'You haven\'t made any bookings yet.' }}</p>
    </div>
    @else
    <div class="card">
        <div class="table-responsive">
            <table class="bookings-table">
                <thead>
                    <tr>
                        <th>Booking #</th>
                        <th>Service</th>
                        <th>Event Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td>
                            <span class="booking-number">{{ $booking->booking_number }}</span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <span>{{ $booking->service->name ?? '—' }}</span>
                                @if($booking->creatorProfile)
                                <span style="font-size:0.65rem;color:var(--slate);">
                                    by {{ $booking->creatorProfile->user->name ?? '' }}
                                </span>
                                @endif
                            </div>
                        </td>
                        <td style="white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($booking->event_date)->format('M j, Y') }}
                            @if($booking->start_time)
                            <br><span style="font-size:0.7rem;color:var(--slate);">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}
                            </span>
                            @endif
                        </td>
                        <td>
                            <span class="amount">₱{{ number_format($booking->total_amount, 2) }}</span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $booking->status }}">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-view">
                                    View
                                </a>
                                @if($booking->status === 'pending')
                                <form method="POST" action="{{ route('bookings.cancel', $booking) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-cancel"
                                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                                        Cancel
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            {{ $bookings->withQueryString()->links() }}
        </div>
    </div>
    @endif

</div>
@endsection

@else
{{-- ════════════════════════════════════════════════════════ --}}
{{-- CREATOR VIEW                                          --}}
{{-- ════════════════════════════════════════════════════════ --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings — NestPeek Photo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Inter:wght@300;400;500;600&family=DM+Mono&display=swap" rel="stylesheet">
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
            --border-mid: rgba(14, 165, 233, 0.28);
            --green: #10B981;
            --green-faint: rgba(16, 185, 129, 0.08);
            --green-border: rgba(16, 185, 129, 0.25);
            --amber: #F59E0B;
            --amber-faint: rgba(245, 158, 11, 0.08);
            --amber-border: rgba(245, 158, 11, 0.25);
            --red: #EF4444;
            --red-faint: rgba(239, 68, 68, 0.08);
            --red-border: rgba(239, 68, 68, 0.25);
            --studio: #7C3AED;
            --studio-faint: rgba(124, 58, 237, 0.07);
            --studio-border: rgba(124, 58, 237, 0.22);
            --studio-mid: #6D28D9;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F8FBFF;
            min-height: 100vh;
            color: var(--text-main);
        }

        /* Topbar */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 32px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-brand {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.2rem;
            font-weight: 400;
            color: var(--navy);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo-box {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-nav {
            display: flex;
            gap: 4px;
        }

        .topbar-nav a {
            font-size: 0.82rem;
            color: var(--slate);
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 8px;
            transition: background 0.15s, color 0.15s;
        }

        .topbar-nav a:hover,
        .topbar-nav a.active {
            background: var(--sky-faint);
            color: var(--navy);
        }

        .topbar-nav a.active {
            color: var(--sky-mid);
            font-weight: 600;
        }

        .btn-nav-studio {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--studio-mid);
            background: var(--studio-faint);
            border: 1.5px solid var(--studio-border);
            padding: 6px 14px;
            border-radius: 50px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-nav-studio:hover {
            background: rgba(124, 58, 237, 0.13);
            border-color: var(--studio);
            color: var(--studio);
        }

        .topbar-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(12, 74, 110, 0.12);
            min-width: 180px;
            overflow: hidden;
            z-index: 200;
        }

        .dropdown:hover .dropdown-menu,
        .dropdown-menu:hover {
            display: block;
        }

        .dropdown-menu a,
        .dropdown-menu button {
            display: block;
            width: 100%;
            padding: 10px 16px;
            font-size: 0.82rem;
            color: var(--text-main);
            text-decoration: none;
            text-align: left;
            background: none;
            border: none;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background 0.15s;
        }

        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background: var(--sky-faint);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0;
        }

        .dropdown-menu .danger {
            color: var(--red);
        }

        /* Layout */
        .page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 24px 80px;
        }

        .page-eyebrow {
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

        .page-eyebrow::before {
            content: '';
            display: inline-block;
            width: 20px;
            height: 1px;
            background: var(--sky-light);
        }

        .page-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.8rem;
            font-weight: 400;
            color: var(--navy);
            line-height: 1.2;
            margin: 0;
        }

        .page-sub {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 28px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .header-stats {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.78rem;
            color: var(--slate);
            background: #fff;
            padding: 4px 14px;
            border-radius: 50px;
            border: 1px solid var(--border);
        }

        .stat-chip strong {
            color: var(--navy);
        }

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

        .card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 2px 16px rgba(14, 165, 233, 0.05);
            overflow: hidden;
            transition: border-color 0.2s;
        }

        .card:hover {
            border-color: rgba(14, 165, 233, 0.28);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .bookings-table thead tr {
            background: var(--sky-faint);
            border-bottom: 1.5px solid var(--border);
        }

        .bookings-table th {
            padding: 14px 20px;
            text-align: left;
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--slate-mid);
            font-weight: 600;
            white-space: nowrap;
        }

        .bookings-table td {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .bookings-table tbody tr:last-child td {
            border-bottom: none;
        }

        .bookings-table tbody tr:hover td {
            background: var(--sky-faint);
        }

        .booking-number {
            font-family: 'DM Mono', monospace;
            font-size: 0.8rem;
            color: var(--sky-mid);
            font-weight: 600;
        }

        .client-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .client-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sky-pale), var(--sky-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--sky-mid);
            flex-shrink: 0;
            overflow: hidden;
        }

        .client-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .client-name {
            font-weight: 600;
            color: var(--navy);
        }

        .client-email {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .amount {
            font-family: 'DM Mono', monospace;
            font-weight: 600;
            color: var(--navy);
            font-size: 0.9rem;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.67rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .badge-pending {
            background: var(--amber-faint);
            color: #B45309;
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .badge-confirmed {
            background: var(--sky-faint);
            color: var(--sky-mid);
            border: 1px solid var(--border-mid);
        }

        .badge-completed {
            background: var(--green-faint);
            color: #065F46;
            border: 1px solid var(--green-border);
        }

        .badge-cancelled {
            background: var(--red-faint);
            color: #991B1B;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        .badge-deposit_paid {
            background: #E0F2FE;
            color: #0369A1;
            border: 1px solid rgba(14, 165, 233, 0.25);
        }

        .badge-in_progress {
            background: #FEF3C7;
            color: #B45309;
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .action-group {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: 1.5px solid;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            background: #fff;
        }

        .btn-view {
            color: var(--sky-mid);
            border-color: var(--border-mid);
        }

        .btn-view:hover {
            background: var(--sky-faint);
            border-color: var(--sky);
        }

        .btn-confirm {
            color: #065F46;
            border-color: var(--green-border);
            background: var(--green-faint);
        }

        .btn-confirm:hover {
            background: #D1FAE5;
            border-color: var(--green);
        }

        .btn-decline {
            color: #991B1B;
            border-color: rgba(239, 68, 68, 0.25);
            background: var(--red-faint);
        }

        .btn-decline:hover {
            background: #FEE2E2;
            border-color: var(--red);
        }

        .btn-cancel {
            color: var(--red);
            border-color: var(--red-border);
            background: var(--red-faint);
        }

        .btn-cancel:hover {
            background: #FEE2E2;
            border-color: var(--red);
        }

        .filter-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-tab {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 6px 18px;
            border-radius: 50px;
            text-decoration: none;
            border: 1.5px solid;
            transition: all 0.15s;
        }

        .filter-tab.active {
            background: var(--sky);
            color: #fff;
            border-color: var(--sky);
        }

        .filter-tab.inactive {
            background: #fff;
            color: var(--slate);
            border-color: var(--border);
        }

        .filter-tab.inactive:hover {
            background: var(--sky-faint);
            border-color: var(--border-mid);
            color: var(--navy);
        }

        .empty-state {
            text-align: center;
            padding: 60px 24px;
        }

        .empty-state .icon {
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
            font-size: 0.9rem;
            color: var(--text-muted);
            margin: 0;
        }

        .pagination-wrapper {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
        }

        @media (max-width: 640px) {
            .topbar {
                padding: 14px 20px;
            }

            .page {
                padding: 20px 16px 40px;
            }

            .page-title {
                font-size: 1.4rem;
            }

            .bookings-table th,
            .bookings-table td {
                padding: 10px 12px;
                font-size: 0.75rem;
            }

            .client-cell {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }

            .btn-nav-studio .label {
                display: none;
            }

            .header-stats {
                gap: 8px;
            }

            .stat-chip {
                font-size: 0.7rem;
                padding: 2px 10px;
            }
        }

        @media print {
            .topbar {
                display: none;
            }

            .action-group {
                display: none;
            }
        }
    </style>
</head>

<body>

    {{-- Topbar --}}
    <nav class="topbar">
        <a href="{{ route('home') }}" class="topbar-brand">
            <span class="logo-box">N</span>
            NestPeek Photo
        </a>
        <div class="topbar-right">
            <nav class="topbar-nav">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('bookings.index') }}" class="active">Bookings</a>
                <a href="{{ route('portfolio.index') }}">Portfolio</a>
                <a href="{{ route('creators.edit') }}">Services</a>
            </nav>

            @if(!$studio)
            <button class="btn-nav-studio" onclick="openStudioModal()">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="4" />
                    <path d="M12 8v8M8 12h8" />
                </svg>
                <span class="label">Create Studio</span>
            </button>
            @else
            <a href="{{ route('studios.show', $studio) }}" class="btn-nav-studio">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="4" />
                    <path d="M12 8v8M8 12h8" />
                </svg>
                <span class="label">{{ $studio->name }}</span>
            </a>
            @endif

            <div class="dropdown">
                <div class="topbar-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="dropdown-menu">
                    <a href="{{ route('onboarding.start') }}">Edit Profile</a>
                    <a href="{{ route('creators.show', $profile->slug ?? $profile->id) }}">Public Profile</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="danger">Sign out</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="page">

        {{-- Page Header --}}
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Creator Dashboard</p>
                <h1 class="page-title">Bookings</h1>
                <p class="page-sub">Manage all client booking requests</p>
            </div>
            <div class="header-stats">
                <span class="stat-chip">
                    Total: <strong>{{ $bookings->total() }}</strong>
                </span>
                <span class="stat-chip">
                    Pending: <strong style="color:var(--amber);">
                        {{ $bookings->where('status', 'pending')->count() }}
                    </strong>
                </span>
                <span class="stat-chip">
                    Confirmed: <strong style="color:var(--sky-mid);">
                        {{ $bookings->where('status', 'confirmed')->count() }}
                    </strong>
                </span>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="alert-success">
            <span class="icon">✅</span>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        {{-- Filter Tabs --}}
        <div class="filter-tabs">
            @foreach(['all' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
            <a href="{{ route('bookings.index', ['status' => $value === 'all' ? null : $value]) }}"
                class="filter-tab {{ (request('status', 'all') === $value) ? 'active' : 'inactive' }}">
                {{ $label }}
                @php
                $count = $bookings->where('status', $value)->count();
                @endphp
                @if($value !== 'all' && $count > 0)
                <span style="font-size:0.65rem;opacity:0.7;">({{ $count }})</span>
                @endif
            </a>
            @endforeach
        </div>

        {{-- Bookings Table --}}
        @if($bookings->isEmpty())
        <div class="card empty-state">
            <span class="icon">📭</span>
            <h3>No bookings found</h3>
            <p>{{ request('status') ? 'No bookings with this status yet.' : 'You haven\'t received any bookings yet.' }}</p>
        </div>
        @else
        <div class="card">
            <div class="table-responsive">
                <table class="bookings-table">
                    <thead>
                        <tr>
                            <th>Booking #</th>
                            <th>Client</th>
                            <th>Service</th>
                            <th>Event Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>
                                <span class="booking-number">{{ $booking->booking_number }}</span>
                            </td>
                            <td>
                                <div class="client-cell">
                                    <div class="client-avatar">
                                        @if($booking->client->avatar)
                                        <img src="{{ asset('storage/' . $booking->client->avatar) }}"
                                            alt="{{ $booking->client->name }}">
                                        @else
                                        {{ strtoupper(substr($booking->client->name ?? 'C', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="client-name">{{ $booking->client->name ?? '—' }}</div>
                                        <div class="client-email">{{ $booking->client->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div>{{ $booking->service->name ?? '—' }}</div>
                                    @if($booking->service)
                                    <div style="font-size:0.65rem;color:var(--slate-mid);">
                                        ₱{{ number_format($booking->service->price, 0) }}
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td style="white-space:nowrap;">
                                {{ \Carbon\Carbon::parse($booking->event_date)->format('M j, Y') }}
                                @if($booking->start_time)
                                <br>
                                <span style="font-size:0.7rem;color:var(--slate);">
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}
                                    @if($booking->end_time)
                                    – {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}
                                    @endif
                                </span>
                                @endif
                            </td>
                            <td>
                                <span class="amount">₱{{ number_format($booking->total_amount, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $booking->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-view">
                                        View
                                    </a>
                                    @if($booking->status === 'pending')
                                    <form method="POST" action="{{ route('bookings.confirm', $booking) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-confirm">Confirm</button>
                                    </form>
                                    <form method="POST" action="{{ route('bookings.cancel', $booking) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-decline"
                                            onclick="return confirm('Decline this booking?')">Decline</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrapper">
                {{ $bookings->withQueryString()->links() }}
            </div>
        </div>
        @endif

    </div>

    <script>
        // Studio modal functions (for Create Studio button)
        function openStudioModal() {
            // Your existing modal logic
            alert('Open studio modal');
        }
    </script>

</body>

</html>
@endif