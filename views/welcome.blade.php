@extends('layouts.app')
@section('title', 'NestPeek Photo — Book the Best Photographers in the Philippines')

@section('content')

<style>
    :root {
        --sky: #0EA5E9;
        --sky-light: #38BDF8;
        --sky-pale: #E0F2FE;
        --sky-faint: #F0F9FF;
        --navy: #0C4A6E;
        --navy-mid: #075985;
        --white: #FFFFFF;
        --slate: #64748B;
        --slate-mid: #94A3B8;
        --slate-light: #CBD5E1;
        --border: rgba(14, 165, 233, 0.15);
        --border-mid: rgba(14, 165, 233, 0.3);
        --green: #22C55E;
        --text-main: #0F172A;
        --text-muted: #475569;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background: var(--white);
        color: var(--text-main);
        font-family: 'DM Sans', 'Segoe UI', sans-serif;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--sky), var(--navy-mid));
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 13px 32px;
        font-size: 0.92rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.35);
    }

    .btn-primary:hover {
        box-shadow: 0 8px 30px rgba(14, 165, 233, 0.5);
        transform: translateY(-2px);
    }

    .btn-ghost {
        background: transparent;
        color: var(--navy);
        border: 1.5px solid var(--border-mid);
        border-radius: 50px;
        padding: 13px 28px;
        font-size: 0.92rem;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }

    .btn-ghost:hover {
        background: var(--sky-faint);
        border-color: var(--sky);
        color: var(--sky);
    }

    .btn-ghost-sm {
        font-size: 0.82rem;
        padding: 8px 18px;
    }

    .eyebrow {
        font-size: 0.7rem;
        color: var(--sky);
        font-family: 'DM Mono', monospace;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .eyebrow::before,
    .eyebrow::after {
        content: '';
        display: inline-block;
        width: 28px;
        height: 1px;
        background: var(--sky-light);
    }

    .eyebrow-left {
        justify-content: flex-start;
    }

    .eyebrow-left::before {
        display: none;
    }
</style>

{{-- HERO --}}
<section style="min-height:100vh;display:flex;align-items:center;position:relative;overflow:hidden;padding:120px 32px 80px;background:linear-gradient(160deg,#F0F9FF 0%,#E0F2FE 40%,#BAE6FD 100%)">

    {{-- Decorative blobs --}}
    <div style="position:absolute;top:-120px;right:-100px;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(56,189,248,0.22) 0%,transparent 70%);pointer-events:none"></div>
    <div style="position:absolute;bottom:-80px;left:-80px;width:420px;height:420px;border-radius:50%;background:radial-gradient(circle,rgba(14,165,233,0.12) 0%,transparent 70%);pointer-events:none"></div>

    {{-- Decorative grid (right side) --}}
    <div style="position:absolute;top:0;right:0;width:50%;height:100%;overflow:hidden;pointer-events:none">
        <div style="position:absolute;inset:0;background:linear-gradient(to right,#F0F9FF 0%,transparent 30%),linear-gradient(to top,#E0F2FE 0%,transparent 25%);z-index:2"></div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;padding:60px 40px;opacity:0.6;transform:rotate(-3deg) scale(1.1);position:absolute;inset:0;align-content:center">
            @foreach(range(1,9) as $i)
            <div style="aspect-ratio:3/4;border-radius:16px;background:linear-gradient(135deg,rgba(14,165,233,0.15),rgba(56,189,248,0.07));border:1.5px solid rgba(14,165,233,0.2);box-shadow:0 4px 20px rgba(14,165,233,0.08)"></div>
            @endforeach
        </div>
    </div>

    {{-- Hero Content --}}
    <div style="max-width:1280px;margin:0 auto;width:100%;position:relative;z-index:3">
        <div style="max-width:580px">
            <p class="eyebrow eyebrow-left" style="margin-bottom:20px">The Photography Marketplace</p>

            <h1 style="font-family:'Playfair Display','Georgia',serif;font-size:clamp(3rem,6vw,5rem);font-weight:400;line-height:1.1;color:var(--navy);margin-bottom:24px">
                Your perfect<br>
                <em style="font-style:italic;background:linear-gradient(135deg,var(--sky),var(--sky-light));-webkit-background-clip:text;-webkit-text-fill-color:transparent">moment</em>,<br>
                captured forever.
            </h1>

            <p style="color:var(--text-muted);font-size:1.05rem;line-height:1.8;margin-bottom:40px;max-width:480px">
                Discover and book verified photographers, videographers, and studios across the Philippines — for weddings, portraits, and every occasion that matters.
            </p>

            <div style="display:flex;gap:14px;flex-wrap:wrap;margin-bottom:56px">
                <a href="{{ route('creators.index') }}" class="btn-primary">
                    Browse Photographers
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
                <a href="{{ route('studios.index') }}" class="btn-ghost">Find Studios</a>
            </div>

            {{-- Trust badges --}}
            <div style="display:flex;align-items:center;gap:28px;flex-wrap:wrap">
                @foreach([
                ['2,500+', 'Creators'],
                ['500+', 'Studios'],
                ['12,000+','Bookings'],
                ] as [$num, $label])
                <div>
                    <div style="font-family:'Playfair Display','Georgia',serif;font-size:1.9rem;font-weight:400;color:var(--navy);line-height:1">{{ $num }}</div>
                    <div style="font-size:0.75rem;color:var(--slate);margin-top:3px;letter-spacing:0.04em">{{ $label }}</div>
                </div>
                @endforeach

                <div style="width:1px;height:40px;background:var(--border-mid);margin:0 4px"></div>

                <div style="display:flex;align-items:center;gap:7px;background:rgba(255,255,255,0.7);border:1px solid var(--border-mid);border-radius:50px;padding:6px 14px">
                    <div style="width:8px;height:8px;border-radius:50%;background:var(--green);box-shadow:0 0 8px rgba(34,197,94,0.5)"></div>
                    <span style="font-size:0.78rem;color:var(--navy-mid);font-weight:500">Verified creators</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SPECIALIZATIONS --}}
<section style="padding:80px 32px;background:#fff;border-top:1px solid var(--border)">
    <div style="max-width:1280px;margin:0 auto">
        <div style="text-align:center;margin-bottom:48px">
            <p class="eyebrow">What we offer</p>
            <h2 style="font-family:'Playfair Display','Georgia',serif;font-size:2.6rem;font-weight:400;color:var(--navy)">Every moment has a specialist</h2>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:14px">
            @foreach([
            ['📷', 'Wedding Photography', 'wedding_photographer'],
            ['🎬', 'Wedding Videography', 'wedding_videographer'],
            ['🖼️', 'Portrait Sessions', 'portrait_photographer'],
            ['🎉', 'Event Photography', 'event_photographer'],
            ['🚁', 'Drone Aerial', 'drone_operator'],
            ['💃', 'Event Videography', 'event_videographer'],
            ['💍', 'Wedding Coordination', 'wedding_coordinator'],
            ['🎭', 'Photo Booth', 'photo_booth'],
            ] as [$icon, $label, $spec])
            <a href="{{ route('creators.index', ['specialization' => $spec]) }}"
                style="display:flex;flex-direction:column;align-items:center;gap:12px;padding:24px 16px;
                      background:var(--sky-faint);border:1.5px solid var(--border);border-radius:20px;
                      text-decoration:none;transition:all 0.3s;text-align:center"
                onmouseover="this.style.background='var(--sky-pale)';this.style.borderColor='var(--sky)';this.style.transform='translateY(-5px)';this.style.boxShadow='0 8px 24px rgba(14,165,233,0.18)'"
                onmouseout="this.style.background='var(--sky-faint)';this.style.borderColor='var(--border)';this.style.transform='translateY(0)';this.style.boxShadow='none'">
                <span style="font-size:1.9rem">{{ $icon }}</span>
                <span style="font-size:0.82rem;color:var(--navy-mid);line-height:1.4;font-weight:500">{{ $label }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- FEATURED CREATORS --}}
<section style="padding:80px 32px;background:linear-gradient(180deg,#F0F9FF 0%,#fff 100%)">
    <div style="max-width:1280px;margin:0 auto">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:40px;gap:20px;flex-wrap:wrap">
            <div>
                <p class="eyebrow eyebrow-left">Top talent</p>
                <h2 style="font-family:'Playfair Display','Georgia',serif;font-size:2.4rem;font-weight:400;color:var(--navy)">Featured photographers</h2>
            </div>
            <a href="{{ route('creators.index') }}" class="btn-ghost btn-ghost-sm">View all creators →</a>
        </div>

        @php
        $featured = \App\Models\CreatorProfile::with('user')
        ->where('is_available', true)
        ->whereHas('user', fn($q) => $q->where('is_active', true))
        ->orderByDesc('average_rating')
        ->limit(6)
        ->get();
        @endphp

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px">
            @forelse($featured as $creator)
            <a href="{{ route('creators.show', $creator) }}"
                style="background:#fff;border:1.5px solid var(--border);border-radius:24px;overflow:hidden;
                      text-decoration:none;display:block;transition:all 0.4s;
                      box-shadow:0 2px 12px rgba(14,165,233,0.07)"
                onmouseover="this.style.transform='translateY(-6px)';this.style.borderColor='var(--sky)';this.style.boxShadow='0 12px 36px rgba(14,165,233,0.18)'"
                onmouseout="this.style.transform='translateY(0)';this.style.borderColor='var(--border)';this.style.boxShadow='0 2px 12px rgba(14,165,233,0.07)'">

                <div style="position:relative;height:200px;overflow:hidden;background:var(--sky-pale)">
                    @if($creator->cover_photo)
                    <img src="{{ asset('storage/'.$creator->cover_photo) }}" style="width:100%;height:100%;object-fit:cover">
                    @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#E0F2FE,#BAE6FD)">
                        <span style="font-size:3.5rem;opacity:0.35">📷</span>
                    </div>
                    @endif
                    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(12,74,110,0.7) 0%,transparent 55%)"></div>
                    <div style="position:absolute;bottom:12px;left:12px;display:flex;align-items:flex-end;gap:10px">
                        <img src="{{ $creator->user->avatar_url }}" style="width:42px;height:42px;border-radius:10px;border:2px solid rgba(255,255,255,0.8);object-fit:cover">
                        <div>
                            <div style="font-size:0.88rem;font-weight:600;color:#fff">{{ $creator->display_name }}</div>
                            <div style="font-size:0.72rem;color:rgba(255,255,255,0.75)">{{ $creator->specialization_label }}</div>
                        </div>
                    </div>
                </div>

                <div style="padding:16px">
                    <div style="display:flex;align-items:center;justify-content:space-between">
                        <div style="display:flex;align-items:center;gap:3px">
                            @for($i=1;$i<=5;$i++)
                                <span style="color:{{ $i<=round($creator->average_rating) ? 'var(--sky)' : 'var(--slate-light)' }};font-size:0.8rem">★</span>
                                @endfor
                                <span style="font-size:0.74rem;color:var(--slate);margin-left:5px">({{ $creator->total_reviews }})</span>
                        </div>
                        <div style="font-size:0.9rem;font-weight:700;color:var(--navy)">
                            {{ $creator->starting_price ? '₱'.number_format($creator->starting_price) : 'Contact' }}
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--slate)">No creators yet — be the first to join!</div>
            @endforelse
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section style="padding:80px 32px;background:#fff;border-top:1px solid var(--border)">
    <div style="max-width:1280px;margin:0 auto">
        <div style="text-align:center;margin-bottom:56px">
            <p class="eyebrow">Simple process</p>
            <h2 style="font-family:'Playfair Display','Georgia',serif;font-size:2.6rem;font-weight:400;color:var(--navy)">How NestPeek works</h2>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:24px">
            @foreach([
            ['01', 'Browse & Discover', 'Search through hundreds of verified photographers and studios filtered by location, style, and budget.', '🔍'],
            ['02', 'View Portfolios', 'Explore their work, read real reviews from past clients, and compare packages.', '🖼️'],
            ['03', 'Send a Booking', 'Submit your event details and get a confirmation from your chosen creator.', '📅'],
            ['04', 'Capture the Moment', 'On the day, let them work their magic. Receive your photos and leave a review.', '✨'],
            ] as [$num, $title, $desc, $icon])
            <div style="position:relative;padding:32px 24px 24px;background:var(--sky-faint);border:1.5px solid var(--border);border-radius:24px;overflow:hidden">
                {{-- Step number badge --}}
                <div style="position:absolute;top:-1px;left:20px;font-family:'DM Mono',monospace;font-size:0.65rem;font-weight:600;color:var(--sky);
                             background:#fff;border:1.5px solid var(--border);border-top:none;padding:5px 12px 4px;
                             border-radius:0 0 12px 12px;letter-spacing:0.1em">{{ $num }}</div>
                {{-- Faint watermark --}}
                <div style="position:absolute;bottom:-16px;right:-8px;font-family:'Playfair Display',serif;font-size:5rem;
                             color:rgba(14,165,233,0.07);pointer-events:none;user-select:none;line-height:1">{{ $num }}</div>
                <div style="font-size:2rem;margin-bottom:16px;margin-top:8px">{{ $icon }}</div>
                <h3 style="font-family:'Playfair Display','Georgia',serif;font-size:1.25rem;color:var(--navy);margin-bottom:10px;font-weight:500">{{ $title }}</h3>
                <p style="font-size:0.84rem;color:var(--text-muted);line-height:1.75;position:relative;z-index:1">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section style="padding:80px 32px;background:linear-gradient(160deg,#E0F2FE 0%,#BAE6FD 60%,#7DD3FC 100%)">
    <div style="max-width:1280px;margin:0 auto">
        <div style="background:rgba(255,255,255,0.65);backdrop-filter:blur(16px);
                    border:1.5px solid rgba(255,255,255,0.9);border-radius:32px;
                    padding:64px;text-align:center;position:relative;overflow:hidden;
                    box-shadow:0 8px 48px rgba(14,165,233,0.15)">
            {{-- Decorative circle --}}
            <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
                         width:500px;height:500px;border-radius:50%;
                         background:radial-gradient(circle,rgba(14,165,233,0.06) 0%,transparent 70%);
                         pointer-events:none"></div>

            <p class="eyebrow" style="margin-bottom:16px">Join the community</p>
            <h2 style="font-family:'Playfair Display','Georgia',serif;font-size:3rem;font-weight:400;color:var(--navy);margin-bottom:16px">Are you a photographer?</h2>
            <p style="color:var(--text-muted);font-size:1rem;margin-bottom:36px;max-width:480px;margin-left:auto;margin-right:auto;line-height:1.8;position:relative;z-index:1">
                Join thousands of creators on NestPeek and grow your business. Showcase your portfolio, manage bookings, and get discovered by clients across the Philippines.
            </p>
            <div style="display:flex;justify-content:center;gap:14px;flex-wrap:wrap;position:relative;z-index:1">
                <a href="{{ route('register') }}" class="btn-primary" style="padding:14px 36px;font-size:0.92rem">Join as a Creator</a>
                <a href="{{ route('creators.index') }}" class="btn-ghost" style="padding:14px 28px;font-size:0.92rem;background:rgba(255,255,255,0.7)">Browse First</a>
            </div>
        </div>
    </div>
</section>

@endsection