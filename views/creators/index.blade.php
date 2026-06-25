@extends('layouts.app')
@section('title', 'Browse Photographers — NestPeek Photo')

@section('content')

{{-- Page Header --}}
<div style="background:linear-gradient(135deg,rgba(201,168,76,0.06) 0%,transparent 70%);border-bottom:1px solid #2A2A3F;padding:56px 0 40px">
    <div style="max-width:1280px;margin:0 auto;padding:0 24px">
        <p style="font-size:0.72rem;color:#C9A84C;font-family:'DM Mono',monospace;letter-spacing:0.12em;text-transform:uppercase;margin-bottom:10px">Discover Talent</p>
        <h1 style="font-family:'Cormorant Garamond',serif;font-size:3rem;font-weight:300;color:#F5F0E8;margin-bottom:12px">
            Find your perfect<br><em style="background:linear-gradient(135deg,#C9A84C,#E8C878);-webkit-background-clip:text;-webkit-text-fill-color:transparent">photographer</em>
        </h1>
        <p style="color:#8B8BA0;font-size:0.95rem;max-width:500px">Browse verified creators ready to capture your most important moments.</p>
    </div>
</div>

<div style="max-width:1280px;margin:0 auto;padding:32px 24px;display:grid;grid-template-columns:260px 1fr;gap:32px;align-items:start">

    {{-- Filter Sidebar --}}
    <div style="background:rgba(255,255,255,0.02);border:1px solid #2A2A3F;border-radius:20px;padding:24px;position:sticky;top:88px">
        <form method="GET" action="{{ route('creators.index') }}" id="filterForm">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
                <h3 style="font-size:0.85rem;font-weight:600;color:#F5F0E8">Filters</h3>
                <a href="{{ route('creators.index') }}" style="font-size:0.75rem;color:#C9A84C;text-decoration:none">Clear all</a>
            </div>

            {{-- Specialization --}}
            <div style="margin-bottom:24px">
                <label style="font-size:0.72rem;color:#C9A84C;font-family:'DM Mono',monospace;text-transform:uppercase;letter-spacing:0.1em;display:block;margin-bottom:12px">Specialization</label>
                @foreach([
                ['wedding_photographer','Wedding Photographer'],
                ['wedding_videographer','Wedding Videographer'],
                ['portrait_photographer','Portrait Photographer'],
                ['event_photographer','Event Photographer'],
                ['event_videographer','Event Videographer'],
                ['wedding_coordinator','Wedding Coordinator'],
                ['drone_operator','Drone Operator'],
                ['photo_editor','Photo Editor'],
                ] as [$val, $label])
                <label style="display:flex;align-items:center;gap:8px;margin-bottom:8px;cursor:pointer;font-size:0.83rem;color:#8B8BA0"
                    onmouseover="this.style.color='#F5F0E8'"
                    onmouseout="this.style.color=this.querySelector('input').checked?'#F5F0E8':'#8B8BA0'">
                    <input type="radio" name="specialization" value="{{ $val }}" style="accent-color:#C9A84C"
                        {{ request('specialization') === $val ? 'checked' : '' }}
                        onchange="document.getElementById('filterForm').submit()">
                    {{ $label }}
                </label>
                @endforeach
            </div>

            {{-- Availability filter --}}
            <div style="margin-bottom:24px">
                <label style="font-size:0.72rem;color:#C9A84C;font-family:'DM Mono',monospace;text-transform:uppercase;letter-spacing:0.1em;display:block;margin-bottom:10px">Availability</label>
                <select name="availability" onchange="document.getElementById('filterForm').submit()"
                    style="width:100%;background:rgba(255,255,255,0.04);border:1px solid #2A2A3F;color:#F5F0E8;border-radius:10px;padding:10px 14px;font-size:0.83rem;font-family:'DM Sans',sans-serif;outline:none">
                    <option value="">Any</option>
                    <option value="available" {{ request('availability') === 'available'   ? 'selected' : '' }}>🟢 Available</option>
                    <option value="booked_soon" {{ request('availability') === 'booked_soon' ? 'selected' : '' }}>🟡 Booked Soon</option>
                    <option value="unavailable" {{ request('availability') === 'unavailable' ? 'selected' : '' }}>🔴 Unavailable</option>
                </select>
            </div>

            {{-- Location --}}
            <div style="margin-bottom:24px">
                <label style="font-size:0.72rem;color:#C9A84C;font-family:'DM Mono',monospace;text-transform:uppercase;letter-spacing:0.1em;display:block;margin-bottom:10px">Location</label>
                <input type="text" name="location" value="{{ request('location') }}"
                    placeholder="City or region..."
                    style="width:100%;background:rgba(255,255,255,0.04);border:1px solid #2A2A3F;color:#F5F0E8;border-radius:10px;padding:10px 14px;font-size:0.83rem;font-family:'DM Sans',sans-serif;outline:none"
                    onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#2A2A3F'">
            </div>

            {{-- Price Range --}}
            <div style="margin-bottom:24px">
                <label style="font-size:0.72rem;color:#C9A84C;font-family:'DM Mono',monospace;text-transform:uppercase;letter-spacing:0.1em;display:block;margin-bottom:10px">Budget (PHP)</label>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                        style="background:rgba(255,255,255,0.04);border:1px solid #2A2A3F;color:#F5F0E8;border-radius:10px;padding:10px 12px;font-size:0.83rem;font-family:'DM Sans',sans-serif;outline:none;width:100%">
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                        style="background:rgba(255,255,255,0.04);border:1px solid #2A2A3F;color:#F5F0E8;border-radius:10px;padding:10px 12px;font-size:0.83rem;font-family:'DM Sans',sans-serif;outline:none;width:100%">
                </div>
            </div>

            {{-- Rating --}}
            <div style="margin-bottom:24px">
                <label style="font-size:0.72rem;color:#C9A84C;font-family:'DM Mono',monospace;text-transform:uppercase;letter-spacing:0.1em;display:block;margin-bottom:10px">Min Rating</label>
                <select name="min_rating"
                    style="width:100%;background:rgba(255,255,255,0.04);border:1px solid #2A2A3F;color:#F5F0E8;border-radius:10px;padding:10px 14px;font-size:0.83rem;font-family:'DM Sans',sans-serif;outline:none">
                    <option value="">Any rating</option>
                    @foreach([4.5, 4, 3.5, 3] as $r)
                    <option value="{{ $r }}" {{ request('min_rating') == $r ? 'selected' : '' }}>{{ $r }}+ stars</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" style="width:100%;padding:12px;background:linear-gradient(135deg,#9A7A2E,#C9A84C);color:#0A0A0F;border:none;border-radius:12px;font-size:0.85rem;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif">
                Apply Filters
            </button>
        </form>
    </div>

    {{-- Results --}}
    <div>
        {{-- Sort + Count bar --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
            <p style="font-size:0.85rem;color:#8B8BA0">
                <span style="color:#F5F0E8;font-weight:600">{{ $creators->total() }}</span> creators found
            </p>
            <select name="sort" form="filterForm" onchange="document.getElementById('filterForm').submit()"
                style="background:rgba(255,255,255,0.04);border:1px solid #2A2A3F;color:#F5F0E8;border-radius:10px;padding:8px 14px;font-size:0.82rem;font-family:'DM Sans',sans-serif;outline:none">
                <option value="featured" {{ request('sort', 'featured') === 'featured'   ? 'selected' : '' }}>Featured</option>
                <option value="rating" {{ request('sort') === 'rating'                 ? 'selected' : '' }}>Highest Rated</option>
                <option value="price_asc" {{ request('sort') === 'price_asc'              ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ request('sort') === 'price_desc'             ? 'selected' : '' }}>Price: High to Low</option>
                <option value="bookings" {{ request('sort') === 'bookings'               ? 'selected' : '' }}>Most Booked</option>
            </select>
        </div>

        {{-- Grid --}}
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px">
            @forelse($creators as $creator)
            @php
            $avail = $creator->availability_status;
            $dot = match($avail) {
            'available' => ['color' => '#2ecc71', 'glow' => 'rgba(46,204,113,0.6)', 'label' => 'Available'],
            'booked_soon' => ['color' => '#F59E0B', 'glow' => 'rgba(245,158,11,0.6)', 'label' => 'Booked Soon'],
            default => ['color' => '#e74c3c', 'glow' => 'rgba(231,76,60,0.6)', 'label' => 'Unavailable'],
            };
            @endphp

            <a href="{{ route('creators.show', $creator) }}"
                style="background:rgba(255,255,255,0.03);border:1px solid #2A2A3F;border-radius:20px;overflow:hidden;text-decoration:none;display:block;transition:all 0.4s"
                onmouseover="this.style.transform='translateY(-6px)';this.style.borderColor='rgba(201,168,76,0.35)';this.style.background='rgba(255,255,255,0.05)'"
                onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#2A2A3F';this.style.background='rgba(255,255,255,0.03)'">

                {{-- Cover --}}
                <div style="position:relative;height:200px;overflow:hidden;background:#1C1C2A">
                    @if($creator->cover_photo)
                    <img src="{{ asset('storage/'.$creator->cover_photo) }}" style="width:100%;height:100%;object-fit:cover;transition:transform 0.6s">
                    @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#1C1C2A,#0A0A0F)">
                        <span style="font-size:3rem;opacity:0.3">📷</span>
                    </div>
                    @endif

                    {{-- Gradient overlay --}}
                    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(10,10,15,0.9) 0%,transparent 60%)"></div>

                    {{-- Availability dot — 3 states --}}
                    <div style="position:absolute;top:12px;left:12px;display:flex;align-items:center;gap:6px">
                        <div style="width:8px;height:8px;border-radius:50%;background:{{ $dot['color'] }};box-shadow:0 0 6px {{ $dot['glow'] }}"></div>
                        <span style="font-size:0.7rem;color:rgba(245,240,232,0.9);font-family:'DM Mono',monospace">{{ $dot['label'] }}</span>
                    </div>

                    {{-- Avatar --}}
                    <div style="position:absolute;bottom:12px;left:12px;display:flex;align-items:flex-end;gap:10px">
                        <img src="{{ $creator->user->avatar_url }}" style="width:44px;height:44px;border-radius:10px;border:2px solid rgba(201,168,76,0.4);object-fit:cover">
                        <div>
                            <div style="font-size:0.88rem;font-weight:600;color:#F5F0E8">{{ $creator->display_name }}</div>
                            <div style="font-size:0.72rem;color:rgba(245,240,232,0.65)">{{ $creator->specialization_label }}</div>
                        </div>
                    </div>
                </div>

                {{-- Info --}}
                <div style="padding:16px">
                    {{-- Rating + Location --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
                        <div style="display:flex;align-items:center;gap:4px">
                            @for($i = 1; $i <= 5; $i++)
                                <span style="color:{{ $i <= round($creator->average_rating) ? '#C9A84C' : '#2A2A3F' }};font-size:0.75rem">★</span>
                                @endfor
                                <span style="font-size:0.75rem;color:#8B8BA0;margin-left:4px">({{ $creator->total_reviews }})</span>
                        </div>
                        @if($creator->user->location)
                        <span style="font-size:0.72rem;color:#8B8BA0">📍 {{ $creator->user->location }}</span>
                        @endif
                    </div>

                    {{-- Style tags --}}
                    @if($creator->styles)
                    <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:12px">
                        @foreach(array_slice($creator->styles, 0, 2) as $style)
                        <span style="font-size:0.68rem;padding:3px 10px;border-radius:20px;background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.25);color:#C9A84C;text-transform:uppercase;letter-spacing:0.05em">{{ $style }}</span>
                        @endforeach
                    </div>
                    @endif

                    {{-- Price + Bookings --}}
                    <div style="display:flex;align-items:center;justify-content:space-between">
                        <div>
                            <div style="font-size:0.7rem;color:#8B8BA0">Starting from</div>
                            <div style="font-size:1.1rem;font-weight:600;color:#C9A84C">
                                {{ $creator->starting_price ? '₱'.number_format($creator->starting_price) : 'Contact' }}
                            </div>
                        </div>
                        <div style="font-size:0.72rem;color:#8B8BA0">{{ $creator->total_bookings }} booked</div>
                    </div>
                </div>
            </a>

            @empty
            <div style="grid-column:1/-1;text-align:center;padding:80px 20px">
                <div style="font-size:3rem;margin-bottom:16px">🔍</div>
                <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.6rem;color:#F5F0E8;margin-bottom:8px">No creators found</h3>
                <p style="color:#8B8BA0;font-size:0.88rem;margin-bottom:20px">Try adjusting your filters or search in a different location.</p>
                <a href="{{ route('creators.index') }}" style="padding:12px 24px;background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.3);border-radius:12px;color:#C9A84C;font-size:0.85rem;text-decoration:none">Clear Filters</a>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($creators->hasPages())
        <div style="margin-top:32px;display:flex;justify-content:center">
            {{ $creators->links() }}
        </div>
        @endif
    </div>
</div>
@endsection