@extends('layouts.app')

@section('content')
<div class="py-8 max-w-4xl mx-auto px-4">

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
    @endif

    <h2 class="font-semibold text-xl text-gray-800 mb-6">
        Booking {{ $booking->booking_number }}
    </h2>

    {{-- Status Badge --}}
    <div class="mb-6 flex items-center gap-3">
        <span class="text-gray-500 text-sm">Status:</span>
        <span class="px-3 py-1 rounded-full text-sm font-medium
            {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
            {{ $booking->status === 'pending'   ? 'bg-yellow-100 text-yellow-800' : '' }}
            {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
        ">
            {{ ucfirst($booking->status) }}
        </span>
    </div>

    {{-- Booking Details --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="font-semibold text-lg mb-4">Booking Details</h3>
        <dl class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <dt class="text-gray-500">Booking #</dt>
                <dd class="font-medium">{{ $booking->booking_number }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Service</dt>
                <dd class="font-medium">{{ $booking->service->name }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Event Date</dt>
                <dd class="font-medium">{{ \Carbon\Carbon::parse($booking->event_date)->format('F j, Y') }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Time</dt>
                <dd class="font-medium">
                    {{ $booking->start_time ?? '—' }}
                    @if($booking->end_time) – {{ $booking->end_time }} @endif
                </dd>
            </div>
            @if($booking->event_type)
            <div>
                <dt class="text-gray-500">Event Type</dt>
                <dd class="font-medium">{{ $booking->event_type }}</dd>
            </div>
            @endif
            @if($booking->venue)
            <div>
                <dt class="text-gray-500">Venue</dt>
                <dd class="font-medium">{{ $booking->venue }}</dd>
            </div>
            @endif
            @if($booking->notes)
            <div class="col-span-2">
                <dt class="text-gray-500">Notes</dt>
                <dd class="font-medium">{{ $booking->notes }}</dd>
            </div>
            @endif
        </dl>
    </div>

    {{-- Payment Summary --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="font-semibold text-lg mb-4">Payment Summary</h3>
        <dl class="text-sm space-y-2">
            <div class="flex justify-between">
                <dt class="text-gray-500">Subtotal</dt>
                <dd>₱{{ number_format($booking->subtotal, 2) }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Deposit Required</dt>
                <dd>₱{{ number_format($booking->deposit_amount, 2) }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Amount Paid</dt>
                <dd class="text-green-600">₱{{ number_format($booking->amount_paid, 2) }}</dd>
            </div>
            <div class="flex justify-between font-semibold border-t pt-2">
                <dt>Amount Due</dt>
                <dd>₱{{ number_format($booking->amount_due, 2) }}</dd>
            </div>
        </dl>
    </div>

    {{-- Creator Info --}}
    @if($booking->creatorProfile)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="font-semibold text-lg mb-2">Creator</h3>
        <p class="text-sm text-gray-700">{{ $booking->creatorProfile->user->name }}</p>
    </div>
    @endif

    {{-- Actions --}}
    <div class="flex gap-3">
        <a href="{{ route('bookings.index') }}"
            class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 text-sm">
            ← Back to Bookings
        </a>

        @if($booking->status === 'pending' && auth()->id() === $booking->client_id)
        <form method="POST" action="{{ route('bookings.cancel', $booking) }}">
            @csrf
        
            <button type="submit"
                onclick="return confirm('Cancel this booking?')"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                Cancel Booking
            </button>
        </form>
        @endif
    </div>

</div>
@endsection