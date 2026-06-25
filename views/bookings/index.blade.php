@extends('layouts.app')

@section('content')
<div class="py-8 max-w-5xl mx-auto px-4">

    <div class="flex justify-between items-center mb-6">
        <h2 class="font-semibold text-xl text-gray-800">My Bookings</h2>
    </div>

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if($bookings->isEmpty())
    <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
        No bookings found.
    </div>
    @else
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Booking #</th>
                    <th class="px-4 py-3 text-left">Service</th>
                    <th class="px-4 py-3 text-left">Event Date</th>
                    <th class="px-4 py-3 text-left">Total</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($bookings as $booking)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $booking->booking_number }}</td>
                    <td class="px-4 py-3">{{ $booking->service->name ?? '—' }}</td>
                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($booking->event_date)->format('M j, Y') }}
                    </td>
                    <td class="px-4 py-3">₱{{ number_format($booking->total_amount, 2) }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $booking->status === 'pending'   ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                            ">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('bookings.show', $booking) }}"
                            class="text-blue-600 hover:underline text-sm">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
    @endif

</div>
@endsection