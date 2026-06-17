@extends('layouts.app')

@section('title', 'Browse Studios — NestPeek Photo')

@section('content')

{{-- Page Header --}}
<div style="background:linear-gradient(135deg,rgba(201,168,76,0.06) 0%,transparent 70%);border-bottom:1px solid #2A2A3F;padding:56px 0 40px">
    <div style="max-width:1280px;margin:0 auto;padding:0 24px">
        <p style="font-size:0.72rem;color:#C9A84C;font-family:'DM Mono',monospace;letter-spacing:0.12em;text-transform:uppercase;margin-bottom:10px">
            Discover Spaces
        </p>

        <h1 style="font-family:'Cormorant Garamond',serif;font-size:3rem;font-weight:300;color:#F5F0E8;margin-bottom:12px">
            Find the perfect<br>
            <em style="background:linear-gradient(135deg,#C9A84C,#E8C878);-webkit-background-clip:text;-webkit-text-fill-color:transparent">
                photography studio
            </em>
        </h1>

        <p style="color:#8B8BA0;font-size:0.95rem;max-width:500px">
            Browse professional studios available for your shoots and creative projects.
        </p>
    </div>
</div>

<div style="max-width:1280px;margin:0 auto;padding:32px 24px;display:grid;grid-template-columns:260px 1fr;gap:32px;align-items:start">

    {{-- FILTER SIDEBAR --}}
    <div style="background:rgba(255,255,255,0.02);border:1px solid #2A2A3F;border-radius:20px;padding:24px;position:sticky;top:88px">

        <form method="GET" action="{{ route('studios.index') }}" id="filterForm">

            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
                <h3 style="font-size:0.85rem;font-weight:600;color:#F5F0E8">Filters</h3>
                <a href="{{ route('studios.index') }}" style="font-size:0.75rem;color:#C9A84C;text-decoration:none">
                    Clear all
                </a>
            </div>

            {{-- Location --}}
            <div style="margin-bottom:24px">
                <label style="font-size:0.72rem;color:#C9A84C;font-family:'DM Mono',monospace;text-transform:uppercase;letter-spacing:0.1em;display:block;margin-bottom:10px">
                    Location
                </label>

                <input type="text" name="location" value="{{ request('location') }}"
                    placeholder="City or region..."
                    style="width:100%;background:rgba(255,255,255,0.04);border:1px solid #2A2A3F;color:#F5F0E8;border-radius:10px;padding:10px 14px;font-size:0.83rem;outline:none">
            </div>

            {{-- Price --}}
            <div style="margin-bottom:24px">
                <label style="font-size:0.72rem;color:#C9A84C;font-family:'DM Mono',monospace;text-transform:uppercase;letter-spacing:0.1em;display:block;margin-bottom:10px">
                    Budget (PHP)
                </label>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                        style="background:rgba(255,255,255,0.04);border:1px solid #2A2A3F;color:#F5F0E8;border-radius:10px;padding:10px 12px;width:100%;outline:none">

                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                        style="background:rgba(255,255,255,0.04);border:1px solid #2A2A3F;color:#F5F0E8;border-radius:10px;padding:10px 12px;width:100%;outline:none">
                </div>
            </div>

            {{-- Apply --}}
            <button type="submit"
                style="width:100%;padding:12px;background:linear-gradient(135deg,#9A7A2E,#C9A84C);color:#0A0A0F;border:none;border-radius:12px;font-size:0.85rem;font-weight:600;cursor:pointer">
                Apply Filters
            </button>
        </form>
    </div>

    {{-- RESULTS --}}
    <div>

        {{-- header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
            <p style="font-size:0.85rem;color:#8B8BA0">
                <span style="color:#F5F0E8;font-weight:600">{{ $studios->total() }}</span> studios found
            </p>
        </div>

        {{-- GRID --}}
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px">

            @forelse($studios as $studio)
            <a href="#"
                style="background:rgba(255,255,255,0.03);border:1px solid #2A2A3F;border-radius:20px;overflow:hidden;text-decoration:none;display:block">

                {{-- Image --}}
                <div style="height:200px;background:#1C1C2A;display:flex;align-items:center;justify-content:center">
                    @if($studio->cover_photo)
                    <img src="{{ asset('storage/'.$studio->cover_photo) }}"
                        style="width:100%;height:100%;object-fit:cover">
                    @else
                    <span style="font-size:3rem;opacity:0.3">🏢</span>
                    @endif
                </div>

                {{-- Info --}}
                <div style="padding:16px">

                    <div style="font-size:0.9rem;font-weight:600;color:#F5F0E8;margin-bottom:6px">
                        {{ $studio->name }}
                    </div>

                    <div style="font-size:0.75rem;color:#8B8BA0;margin-bottom:10px">
                        📍 {{ $studio->location ?? 'No location set' }}
                    </div>

                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <div style="color:#C9A84C;font-weight:600;font-size:0.95rem">
                            ₱{{ number_format($studio->price_per_hour ?? 0) }}/hr
                        </div>

                        <div style="font-size:0.72rem;color:#8B8BA0">
                            Available
                        </div>
                    </div>

                </div>
            </a>
            @empty

            <div style="grid-column:1/-1;text-align:center;padding:80px 20px">
                <div style="font-size:3rem;margin-bottom:16px">🏢</div>
                <h3 style="color:#F5F0E8;margin-bottom:8px">No studios found</h3>
                <p style="color:#8B8BA0">Try adjusting your filters.</p>
            </div>

            @endforelse

        </div>

        {{-- PAGINATION --}}
        @if($studios->hasPages())
        <div style="margin-top:32px;display:flex;justify-content:center">
            {{ $studios->links() }}
        </div>
        @endif

    </div>
</div>

@endsection