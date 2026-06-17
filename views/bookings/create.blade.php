@extends('layouts.app')
@section('title', 'Book ' . $service->serviceable->display_name ?? $service->serviceable->name . ' — NestPeek Photo')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&family=Inter:wght@400;500;600&family=DM+Mono&display=swap');

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
        --text-muted: #475569;
        --border: rgba(14, 165, 233, 0.14);
        --border-mid: rgba(14, 165, 233, 0.28);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    .wrap {
        max-width: 860px;
        margin: 0 auto;
        padding: 44px 20px 80px;
    }

    /* ── Page header ── */
    .page-eyebrow {
        font-family: 'DM Mono', monospace;
        font-size: 0.63rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--sky-mid);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }

    .page-eyebrow::before {
        content: '';
        display: inline-block;
        width: 26px;
        height: 1px;
        background: var(--sky-light);
    }

    .page-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2rem;
        font-weight: 400;
        color: var(--navy);
        margin: 0 0 4px;
    }

    .page-sub {
        font-family: 'Inter', sans-serif;
        font-size: 0.88rem;
        color: var(--text-muted);
        margin-bottom: 32px;
    }

    /* ── Layout ── */
    .grid {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 24px;
        align-items: start;
    }

    /* ── Form card ── */
    .form-card {
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 20px;
        padding: 28px 30px;
        box-shadow: 0 2px 16px rgba(14, 165, 233, 0.06);
    }

    .section-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--slate-mid);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* ── Fields ── */
    .field {
        margin-bottom: 18px;
    }

    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 18px;
    }

    label {
        display: block;
        font-family: 'Inter', sans-serif;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 6px;
    }

    label .opt {
        font-weight: 400;
        color: var(--slate-mid);
        font-size: 0.72rem;
    }

    input[type="date"],
    input[type="time"],
    input[type="text"],
    select,
    textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--border-mid);
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: #0F172A;
        background: #fff;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        appearance: none;
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: var(--sky);
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.12);
    }

    textarea {
        resize: vertical;
        min-height: 90px;
        line-height: 1.6;
    }

    .field-error {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        color: #B91C1C;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ── Summary sidebar ── */
    .summary-card {
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 20px;
        padding: 22px;
        box-shadow: 0 2px 12px rgba(14, 165, 233, 0.06);
        position: sticky;
        top: 24px;
    }

    .summary-creator {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
        padding-bottom: 18px;
        border-bottom: 1px solid var(--border);
    }

    .summary-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--sky-pale);
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        border: 1.5px solid var(--border);
    }

    .summary-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .summary-creator-name {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1rem;
        font-weight: 400;
        color: var(--navy);
        margin-bottom: 2px;
    }

    .summary-creator-role {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--slate-mid);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        margin-bottom: 10px;
        gap: 8px;
    }

    .summary-row-label {
        color: var(--text-muted);
    }

    .summary-row-value {
        color: var(--navy);
        font-weight: 500;
        text-align: right;
    }

    .summary-divider {
        height: 1px;
        background: var(--border);
        margin: 14px 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 6px;
    }

    .summary-total-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.62rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--slate-mid);
    }

    .summary-total-amount {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.6rem;
        font-weight: 400;
        color: var(--navy);
    }

    .summary-deposit-note {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 18px;
        line-height: 1.5;
    }

    /* ── Submit button ── */
    .btn-submit {
        display: block;
        width: 100%;
        padding: 13px;
        background: linear-gradient(135deg, var(--sky), var(--sky-mid));
        color: #fff;
        border: none;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(14, 165, 233, 0.35);
        transition: all 0.2s;
        text-align: center;
    }

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.45);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        color: var(--slate);
        text-decoration: none;
        margin-bottom: 20px;
        transition: color 0.2s;
    }

    .btn-back:hover {
        color: var(--sky);
    }

    /* ── Notice ── */
    .notice {
        background: var(--sky-faint);
        border: 1px solid var(--border-mid);
        border-radius: 12px;
        padding: 12px 14px;
        font-family: 'Inter', sans-serif;
        font-size: 0.78rem;
        color: var(--text-muted);
        line-height: 1.55;
        margin-top: 14px;
    }

    @media (max-width: 700px) {
        .grid {
            grid-template-columns: 1fr;
        }

        .field-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .summary-card {
            position: static;
        }
    }
</style>

<div style="background:linear-gradient(160deg,#F0F9FF 0%,#fff 40%);min-height:100vh">
    <div class="wrap">

        <a href="{{ url()->previous() }}" class="btn-back">← Back</a>

        <p class="page-eyebrow">New Booking</p>
        <h1 class="page-title">Request a shoot</h1>
        <p class="page-sub">Fill in your event details and we'll send the request to the photographer.</p>

        @if($errors->any())
        <div style="background:rgba(239,68,68,0.08);border:1.5px solid rgba(239,68,68,0.25);border-radius:14px;padding:14px 18px;margin-bottom:24px;font-family:'Inter',sans-serif;font-size:0.83rem;color:#B91C1C">
            <strong style="display:block;margin-bottom:6px">Please fix the following:</strong>
            <ul style="margin:0;padding-left:18px">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}">

            <div class="grid">

                {{-- ── Form ── --}}
                <div class="form-card">

                    {{-- Event details --}}
                    <p class="section-label">Event Details</p>

                    <div class="field-row">
                        <div>
                            <label for="event_date">Event Date <span style="color:#B91C1C">*</span></label>
                            <input type="date"
                                id="event_date"
                                name="event_date"
                                value="{{ old('event_date') }}"
                                min="{{ now()->addDay()->format('Y-m-d') }}"
                                required>
                            @error('event_date')
                            <p class="field-error">⚠ {{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="event_type">Event Type <span class="opt">(optional)</span></label>
                            <select id="event_type" name="event_type">
                                <option value="">Select type…</option>
                                @foreach(['Wedding','Prenuptial','Debut','Birthday','Corporate','Baptism','Graduation','Portrait Session','Other'] as $type)
                                <option value="{{ $type }}" {{ old('event_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="field-row">
                        <div>
                            <label for="start_time">Start Time <span class="opt">(optional)</span></label>
                            <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}">
                        </div>
                        <div>
                            <label for="end_time">End Time <span class="opt">(optional)</span></label>
                            <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label for="venue">Venue / Location <span class="opt">(optional)</span></label>
                        <input type="text" id="venue" name="venue"
                            placeholder="e.g. Smallville Complex, Iloilo City"
                            value="{{ old('venue') }}">
                    </div>

                    {{-- Additional info --}}
                    <p class="section-label" style="margin-top:22px">Additional Info</p>

                    <div class="field">
                        <label for="notes">Notes for the photographer <span class="opt">(optional)</span></label>
                        <textarea id="notes" name="notes" placeholder="Anything the photographer should know about the event, your preferences, the look you want…">{{ old('notes') }}</textarea>
                    </div>

                    <div class="field">
                        <label for="special_requests">Special Requests <span class="opt">(optional)</span></label>
                        <textarea id="special_requests" name="special_requests"
                            style="min-height:70px"
                            placeholder="e.g. specific shots, family groupings, must-capture moments…">{{ old('special_requests') }}</textarea>
                    </div>

                </div>

                {{-- ── Summary sidebar ── --}}
                <div>
                    <div class="summary-card">

                        {{-- Creator --}}
                        @php $serviceable = $service->serviceable; @endphp
                        <div class="summary-creator">
                            <div class="summary-avatar">
                                @if($serviceable instanceof \App\Models\CreatorProfile && $serviceable->user->avatar)
                                <img src="{{ asset('storage/' . $serviceable->user->avatar) }}" alt="">
                                @elseif($serviceable instanceof \App\Models\Studio && $serviceable->logo)
                                <img src="{{ asset('storage/' . $serviceable->logo) }}" alt="">
                                @else
                                📷
                                @endif
                            </div>
                            <div>
                                <div class="summary-creator-name">
                                    {{ $serviceable instanceof \App\Models\CreatorProfile ? $serviceable->display_name : $serviceable->name }}
                                </div>
                                <div class="summary-creator-role">
                                    {{ $serviceable instanceof \App\Models\CreatorProfile ? $serviceable->specialization_label : 'Studio' }}
                                </div>
                            </div>
                        </div>

                        {{-- Service --}}
                        <div class="summary-row">
                            <span class="summary-row-label">Service</span>
                            <span class="summary-row-value">{{ $service->name }}</span>
                        </div>
                        @if($service->duration_hours)
                        <div class="summary-row">
                            <span class="summary-row-label">Duration</span>
                            <span class="summary-row-value">{{ $service->duration_hours }} hours</span>
                        </div>
                        @endif
                        @if($service->inclusions)
                        <div class="summary-row" style="align-items:flex-start">
                            <span class="summary-row-label">Includes</span>
                            <span class="summary-row-value" style="font-size:0.78rem">{{ Str::limit($service->inclusions, 60) }}</span>
                        </div>
                        @endif

                        <div class="summary-divider"></div>

                        {{-- Pricing --}}
                        <div class="summary-row">
                            <span class="summary-row-label">Package price</span>
                            <span class="summary-row-value">₱{{ number_format($service->price) }}</span>
                        </div>
                        @if($service->requires_deposit && $service->deposit_amount)
                        <div class="summary-row">
                            <span class="summary-row-label">Deposit to confirm</span>
                            <span class="summary-row-value" style="color:var(--sky-mid)">₱{{ number_format($service->deposit_amount) }}</span>
                        </div>
                        @elseif($service->requires_deposit && $service->deposit_percentage)
                        <div class="summary-row">
                            <span class="summary-row-label">Deposit to confirm</span>
                            <span class="summary-row-value" style="color:var(--sky-mid)">{{ $service->deposit_percentage }}% (₱{{ number_format($service->price * $service->deposit_percentage / 100) }})</span>
                        </div>
                        @endif

                        <div class="summary-divider"></div>

                        <div class="summary-total">
                            <span class="summary-total-label">Total</span>
                            <span class="summary-total-amount">₱{{ number_format($service->price) }}</span>
                        </div>

                        <p class="summary-deposit-note">
                            No payment now. The photographer will confirm your request first, then payment details will be shared.
                        </p>

                        <button type="submit" class="btn-submit">
                            📅 Send Booking Request
                        </button>

                        <div class="notice">
                            🔒 Your booking request will be sent to the photographer. You'll be notified once they confirm or respond.
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
@endsection