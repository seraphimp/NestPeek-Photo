@extends('layouts.app')
@section('title', 'Browse Creative Professionals — NestPeek Photo')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300;9..144,500;9..144,600&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<div style="background:#F4F9FF;min-height:100vh;font-family:'Inter',sans-serif">

    {{-- Page Header --}}
    <div style="background:linear-gradient(180deg,#E4F2FE 0%,#F4F9FF 100%);border-bottom:1px solid #D6E8F7;padding:56px 0 40px;position:relative;overflow:hidden">
        <div style="position:absolute;top:-60px;right:8%;width:240px;height:240px;border-radius:50%;background:radial-gradient(circle,rgba(95,184,232,0.22),transparent 70%);pointer-events:none"></div>
        <div style="position:absolute;top:40px;right:22%;width:140px;height:140px;border-radius:50%;background:radial-gradient(circle,rgba(46,125,209,0.14),transparent 70%);pointer-events:none"></div>
        <div style="max-width:1280px;margin:0 auto;padding:0 24px;position:relative">
            <p style="font-size:0.72rem;color:#2E7DD1;font-family:'JetBrains Mono',monospace;letter-spacing:0.12em;text-transform:uppercase;margin-bottom:10px">Discover Talent</p>
            <h1 style="font-family:'Fraunces',serif;font-size:3rem;font-weight:500;color:#0F2C44;margin-bottom:12px;line-height:1.1">
                Find the right<br><em style="font-style:italic;background:linear-gradient(135deg,#0B4F8A,#5FB8E8);-webkit-background-clip:text;-webkit-text-fill-color:transparent">creative pro</em>
            </h1>
            <p style="color:#5B7185;font-size:0.95rem;max-width:540px">Browse verified photographers, planners, performers, and specialists ready for your next event or production.</p>
        </div>
    </div>

    <div style="max-width:1280px;margin:0 auto;padding:32px 24px;display:grid;grid-template-columns:280px 1fr;gap:32px;align-items:start">

        {{-- Filter Sidebar --}}
        <div style="background:#FFFFFF;border:1px solid #D6E8F7;border-radius:20px;padding:24px;position:sticky;top:88px;box-shadow:0 4px 24px rgba(46,125,209,0.06)">
            <form method="GET" action="{{ route('creators.index') }}" id="filterForm">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
                    <h3 style="font-size:0.85rem;font-weight:700;color:#0F2C44">Filters</h3>
                    <a href="{{ route('creators.index') }}" style="font-size:0.75rem;color:#2E7DD1;text-decoration:none;font-weight:500">Clear all</a>
                </div>

                @php
                $industryGroups = [
                'Photo & Video' => [
                ['wedding_photographer','Wedding Photographer'],['wedding_videographer','Wedding Videographer'],
                ['portrait_photographer','Portrait Photographer'],['event_photographer','Event Photographer'],
                ['event_videographer','Event Videographer'],['drone_operator','Drone Operator'],
                ['photo_editor','Photo Editor'],['videographer_editor','Video Editor'],
                ],
                'Events & Planning' => [
                ['wedding_coordinator','Wedding Coordinator'],['event_planner','Event Planner'],
                ['event_host','Event Host / Emcee'],['stylist_designer','Stylist / Event Designer'],
                ['caterer','Caterer'],['florist','Florist'],
                ],
                'Beauty & Glam' => [
                ['makeup_artist','Makeup Artist'],['hairstylist','Hairstylist'],['nail_artist','Nail Artist'],
                ],
                'Performers & Entertainment' => [
                ['live_band','Live Band'],['solo_musician','Solo Musician'],['dj','DJ'],
                ['lights_sound_tech','Lights & Sound Technician'],['performer_dancer','Performer / Dancer'],
                ],
                'Other Professional Services' => [
                ['graphic_designer','Graphic Designer'],['invitation_designer','Invitation Designer'],
                ['venue_coordinator','Venue Coordinator'],['transport_logistics','Transport & Logistics'],
                ],
                ];
                $selectedSpecialization = request('specialization');
                @endphp

                <div style="margin-bottom:24px">
                    <label style="font-size:0.72rem;color:#2E7DD1;font-family:'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:0.1em;display:block;margin-bottom:12px">Industry &amp; Role</label>
                    <div style="display:flex;flex-direction:column;gap:4px;max-height:420px;overflow-y:auto;padding-right:4px">
                        @foreach($industryGroups as $groupLabel => $roles)
                        <details {{ in_array($selectedSpecialization, array_column($roles, 0)) ? 'open' : '' }} style="margin-bottom:6px">
                            <summary style="cursor:pointer;list-style:none;display:flex;align-items:center;justify-content:space-between;padding:8px 4px;font-size:0.78rem;font-weight:600;color:#0F2C44;border-bottom:1px solid #EAF3FC">
                                <span>{{ $groupLabel }}</span>
                                <span style="color:#5FB8E8;font-size:0.7rem">▾</span>
                            </summary>
                            <div style="padding:8px 4px 4px 4px">
                                @foreach($roles as [$val, $label])
                                <label style="display:flex;align-items:center;gap:8px;margin-bottom:8px;cursor:pointer;font-size:0.83rem;color:{{ $selectedSpecialization === $val ? '#0F2C44' : '#5B7185' }}"
                                    onmouseover="this.style.color='#0F2C44'"
                                    onmouseout="this.style.color=this.querySelector('input').checked?'#0F2C44':'#5B7185'">
                                    <input type="radio" name="specialization" value="{{ $val }}" style="accent-color:#2E7DD1"
                                        {{ $selectedSpecialization === $val ? 'checked' : '' }}
                                        onchange="document.getElementById('filterForm').submit()">
                                    {{ $label }}
                                </label>
                                @endforeach
                            </div>
                        </details>
                        @endforeach
                    </div>
                </div>

                <div style="margin-bottom:24px">
                    <label style="font-size:0.72rem;color:#2E7DD1;font-family:'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:0.1em;display:block;margin-bottom:10px">Availability</label>
                    <select name="availability" onchange="document.getElementById('filterForm').submit()"
                        style="width:100%;background:#F4F9FF;border:1px solid #D6E8F7;color:#0F2C44;border-radius:10px;padding:10px 14px;font-size:0.83rem;font-family:'Inter',sans-serif;outline:none">
                        <option value="">Any</option>
                        <option value="available" {{ request('availability')==='available' ? 'selected':'' }}>☀️ Available</option>
                        <option value="booked_soon" {{ request('availability')==='booked_soon' ? 'selected':'' }}>⛅ Booked Soon</option>
                        <option value="unavailable" {{ request('availability')==='unavailable' ? 'selected':'' }}>🌧️ Unavailable</option>
                    </select>
                </div>

                <div style="margin-bottom:24px">
                    <label style="font-size:0.72rem;color:#2E7DD1;font-family:'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:0.1em;display:block;margin-bottom:10px">Location</label>
                    <input type="text" name="location" value="{{ request('location') }}" placeholder="City or region..."
                        style="width:100%;background:#F4F9FF;border:1px solid #D6E8F7;color:#0F2C44;border-radius:10px;padding:10px 14px;font-size:0.83rem;font-family:'Inter',sans-serif;outline:none"
                        onfocus="this.style.borderColor='#2E7DD1'" onblur="this.style.borderColor='#D6E8F7'">
                </div>

                <div style="margin-bottom:24px">
                    <label style="font-size:0.72rem;color:#2E7DD1;font-family:'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:0.1em;display:block;margin-bottom:10px">Budget (PHP)</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                            style="background:#F4F9FF;border:1px solid #D6E8F7;color:#0F2C44;border-radius:10px;padding:10px 12px;font-size:0.83rem;font-family:'Inter',sans-serif;outline:none;width:100%">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                            style="background:#F4F9FF;border:1px solid #D6E8F7;color:#0F2C44;border-radius:10px;padding:10px 12px;font-size:0.83rem;font-family:'Inter',sans-serif;outline:none;width:100%">
                    </div>
                </div>

                <div style="margin-bottom:24px">
                    <label style="font-size:0.72rem;color:#2E7DD1;font-family:'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:0.1em;display:block;margin-bottom:10px">Min Rating</label>
                    <select name="min_rating"
                        style="width:100%;background:#F4F9FF;border:1px solid #D6E8F7;color:#0F2C44;border-radius:10px;padding:10px 14px;font-size:0.83rem;font-family:'Inter',sans-serif;outline:none">
                        <option value="">Any rating</option>
                        @foreach([4.5, 4, 3.5, 3] as $r)
                        <option value="{{ $r }}" {{ request('min_rating') == $r ? 'selected':'' }}>{{ $r }}+ stars</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" style="width:100%;padding:12px;background:linear-gradient(135deg,#2E7DD1,#5FB8E8);color:#FFFFFF;border:none;border-radius:12px;font-size:0.85rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;box-shadow:0 4px 14px rgba(46,125,209,0.3)">
                    Apply Filters
                </button>
            </form>
        </div>

        {{-- Results --}}
        <div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <p style="font-size:0.85rem;color:#5B7185">
                    <span style="color:#0F2C44;font-weight:700">{{ $creators->total() }}</span> professionals found
                </p>
                <select name="sort" form="filterForm" onchange="document.getElementById('filterForm').submit()"
                    style="background:#FFFFFF;border:1px solid #D6E8F7;color:#0F2C44;border-radius:10px;padding:8px 14px;font-size:0.82rem;font-family:'Inter',sans-serif;outline:none">
                    <option value="featured" {{ request('sort','featured')==='featured' ? 'selected':'' }}>Featured</option>
                    <option value="rating" {{ request('sort')==='rating' ? 'selected':'' }}>Highest Rated</option>
                    <option value="price_asc" {{ request('sort')==='price_asc' ? 'selected':'' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort')==='price_desc' ? 'selected':'' }}>Price: High to Low</option>
                    <option value="bookings" {{ request('sort')==='bookings' ? 'selected':'' }}>Most Booked</option>
                </select>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px">
                @forelse($creators as $creator)
                @php
                $avail = $creator->availability_status;
                $weather = match($avail) {
                'available' => ['icon'=>'☀️','color'=>'#2E7DD1','bg'=>'rgba(46,125,209,0.08)','border'=>'rgba(46,125,209,0.25)','label'=>'Available'],
                'booked_soon'=> ['icon'=>'⛅','color'=>'#B8860B','bg'=>'rgba(245,158,11,0.08)','border'=>'rgba(245,158,11,0.25)','label'=>'Booked Soon'],
                default => ['icon'=>'🌧️','color'=>'#C0392B','bg'=>'rgba(192,57,43,0.08)','border'=>'rgba(192,57,43,0.22)','label'=>'Unavailable'],
                };
                @endphp

                <a href="{{ route('creators.show', $creator) }}"
                    style="background:#FFFFFF;border:1px solid #D6E8F7;border-radius:20px;overflow:hidden;text-decoration:none;display:block;transition:all 0.35s;box-shadow:0 2px 12px rgba(46,125,209,0.05)"
                    onmouseover="this.style.transform='translateY(-6px)';this.style.borderColor='#5FB8E8';this.style.boxShadow='0 12px 28px rgba(46,125,209,0.16)'"
                    onmouseout="this.style.transform='translateY(0)';this.style.borderColor='#D6E8F7';this.style.boxShadow='0 2px 12px rgba(46,125,209,0.05)'">

                    <div style="position:relative;height:200px;overflow:hidden;background:#E4F2FE">
                        @if($creator->cover_photo)
                        <img src="{{ asset('storage/'.$creator->cover_photo) }}" style="width:100%;height:100%;object-fit:cover;transition:transform 0.6s">
                        @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#E4F2FE,#CFE8FB)">
                            <span style="font-size:3rem;opacity:0.35">📷</span>
                        </div>
                        @endif
                        <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(11,33,55,0.78) 0%,transparent 55%)"></div>
                        <div style="position:absolute;top:12px;left:12px;display:flex;align-items:center;gap:6px;background:{{ $weather['bg'] }};border:1px solid {{ $weather['border'] }};backdrop-filter:blur(4px);padding:4px 10px 4px 8px;border-radius:20px">
                            <span style="font-size:0.8rem;line-height:1">{{ $weather['icon'] }}</span>
                            <span style="font-size:0.7rem;color:{{ $weather['color'] }};font-family:'JetBrains Mono',monospace;font-weight:500">{{ $weather['label'] }}</span>
                        </div>

                        {{-- ── FAVORITE BUTTON (clients only, on the card) ── --}}
                        @auth
                        @if(auth()->user()->isClient())
                        <form method="POST" action="{{ route('favorites.toggle') }}"
                            style="position:absolute;top:10px;right:10px;margin:0"
                            onclick="event.stopPropagation()">
                            @csrf
                            <input type="hidden" name="favorable_type" value="App\Models\CreatorProfile">
                            <input type="hidden" name="favorable_id" value="{{ $creator->id }}">
                            <button type="submit"
                                title="{{ $creator->isFavoritedBy(auth()->user()) ? 'Remove from favorites' : 'Save to favorites' }}"
                                style="width:32px;height:32px;border-radius:50%;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1rem;transition:all 0.2s;
                                {{ $creator->isFavoritedBy(auth()->user()) 
                                    ? 'background:#EF4444;color:#fff;box-shadow:0 2px 8px rgba(239,68,68,0.4);' 
                                    : 'background:rgba(255,255,255,0.85);color:#9CA3AF;backdrop-filter:blur(4px);' }}">
                                {{ $creator->isFavoritedBy(auth()->user()) ? '♥' : '♡' }}
                            </button>
                        </form>
                        @endif
                        @endauth

                        <div style="position:absolute;bottom:12px;left:12px;display:flex;align-items:flex-end;gap:10px">
                            <img src="{{ $creator->user->avatar_url }}" style="width:44px;height:44px;border-radius:10px;border:2px solid rgba(95,184,232,0.7);object-fit:cover">
                            <div>
                                <div style="font-size:0.88rem;font-weight:600;color:#FFFFFF">{{ $creator->display_name }}</div>
                                <div style="font-size:0.72rem;color:rgba(255,255,255,0.85)">{{ $creator->specialization_label }}</div>
                            </div>
                        </div>
                    </div>

                    <div style="padding:16px">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
                            <div style="display:flex;align-items:center;gap:4px">
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="color:{{ $i <= round($creator->average_rating) ? '#2E7DD1' : '#D6E8F7' }};font-size:0.75rem">★</span>
                                    @endfor
                                    <span style="font-size:0.75rem;color:#5B7185;margin-left:4px">({{ $creator->reviews_count ?? $creator->total_reviews ?? 0 }})</span>
                            </div>
                            @if($creator->user->location)
                            <span style="font-size:0.72rem;color:#5B7185">📍 {{ $creator->user->location }}</span>
                            @endif
                        </div>

                        @if($creator->styles)
                        <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:12px">
                            @foreach(array_slice($creator->styles, 0, 2) as $style)
                            <span style="font-size:0.68rem;padding:3px 10px;border-radius:20px;background:rgba(46,125,209,0.08);border:1px solid rgba(46,125,209,0.2);color:#2E7DD1;text-transform:uppercase;letter-spacing:0.05em">{{ $style }}</span>
                            @endforeach
                        </div>
                        @endif

                        <div style="display:flex;align-items:center;justify-content:space-between">
                            <div>
                                <div style="font-size:0.7rem;color:#5B7185">Starting from</div>
                                <div style="font-size:1.1rem;font-weight:600;color:#0B4F8A">
                                    {{ $creator->starting_price ? '₱'.number_format($creator->starting_price) : 'Contact' }}
                                </div>
                            </div>
                            {{-- ── FIX: was $creator->total_bookings (accessor, always 0) ── --}}
                            <div style="font-size:0.72rem;color:#5B7185">{{ $creator->bookings_count ?? 0 }} booked</div>
                        </div>
                    </div>
                </a>
                @empty
                <div style="grid-column:1/-1;text-align:center;padding:80px 20px;background:#FFFFFF;border:1px solid #D6E8F7;border-radius:20px">
                    <div style="font-size:3rem;margin-bottom:16px">🔍</div>
                    <h3 style="font-family:'Fraunces',serif;font-size:1.6rem;font-weight:500;color:#0F2C44;margin-bottom:8px">No professionals found</h3>
                    <p style="color:#5B7185;font-size:0.88rem;margin-bottom:20px">Try a different role, location, or budget range.</p>
                    <a href="{{ route('creators.index') }}" style="padding:12px 24px;background:rgba(46,125,209,0.08);border:1px solid rgba(46,125,209,0.25);border-radius:12px;color:#2E7DD1;font-size:0.85rem;text-decoration:none;font-weight:500">Clear Filters</a>
                </div>
                @endforelse
            </div>

            @if($creators->hasPages())
            <div style="margin-top:32px;display:flex;justify-content:center">
                {{ $creators->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection