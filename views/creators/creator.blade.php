@extends('layouts.app')
@section('title', 'Dashboard — NestPeek Photo')

@section('content')
<div style="background:linear-gradient(135deg,rgba(201,168,76,0.06) 0%,transparent 60%);border-bottom:1px solid #2A2A3F;padding:40px 0 0">
    <div style="max-width:1280px;margin:0 auto;padding:0 24px">

        {{-- Header --}}
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:32px">
            <div>
                <p style="font-size:0.75rem;color:#C9A84C;font-family:'DM Mono',monospace;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:8px">Creator Dashboard</p>
                <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.4rem;font-weight:400;color:#F5F0E8;margin-bottom:4px">
                    Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, {{ explode(' ', $user->name)[0] }}.
                </h1>
                <p style="color:#8B8BA0;font-size:0.9rem">Here's what's happening with your profile today.</p>
            </div>
            <div style="display:flex;gap:12px">
                <a href="{{ route('creators.edit') }}" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border:1px solid rgba(201,168,76,0.4);border-radius:12px;color:#C9A84C;font-size:0.85rem;text-decoration:none;transition:all 0.2s">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Profile
                </a>
                <a href="{{ route('creators.show', $profile) }}" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:linear-gradient(135deg,#9A7A2E,#C9A84C,#E8C878);color:#0A0A0F;border-radius:12px;font-size:0.85rem;font-weight:600;text-decoration:none">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Profile
                </a>
            </div>
        </div>

        {{-- Stats tabs nav --}}
        <div style="display:flex;gap:0;border-bottom:1px solid #2A2A3F">
            <button style="padding:12px 24px;font-size:0.85rem;color:#F5F0E8;border-bottom:2px solid #C9A84C;background:none;border-left:none;border-right:none;border-top:none;cursor:pointer">Overview</button>
            <button style="padding:12px 24px;font-size:0.85rem;color:#8B8BA0;border:none;background:none;cursor:pointer">Bookings</button>
            <button style="padding:12px 24px;font-size:0.85rem;color:#8B8BA0;border:none;background:none;cursor:pointer">Analytics</button>
        </div>
    </div>
</div>

<div style="max-width:1280px;margin:0 auto;padding:32px 24px">

    {{-- Stats Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:32px">
        @foreach([
        ['Total Bookings', $stats['total_bookings'], '📋', '#3498db'],
        ['Pending', $stats['pending_bookings'], '⏳', '#f39c12'],
        ['Completed', $stats['completed_bookings'], '✅', '#2ecc71'],
        ['Revenue', '₱'.number_format($stats['total_revenue']), '💰', '#C9A84C'],
        ['Rating', number_format($stats['average_rating'],1).'★', '⭐', '#C9A84C'],
        ['Profile Views', $stats['profile_views'], '👁', '#9b59b6'],
        ] as [$label, $value, $icon, $color])
        <div style="background:rgba(255,255,255,0.03);border:1px solid #2A2A3F;border-radius:16px;padding:20px;transition:all 0.3s">
            <div style="font-size:1.4rem;margin-bottom:10px">{{ $icon }}</div>
            <div style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:500;color:{{ $color }};margin-bottom:4px">{{ $value }}</div>
            <div style="font-size:0.78rem;color:#8B8BA0">{{ $label }}</div>
        </div>
        @endforeach
    </div>

    <div style="display:grid;grid-template-columns:1fr 360px;gap:24px">

        {{-- Recent Bookings --}}
        <div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
                <h2 style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:400;color:#F5F0E8">Recent Bookings</h2>
                <a href="{{ route('bookings.index') }}" style="font-size:0.82rem;color:#C9A84C;text-decoration:none">View all →</a>
            </div>

            <div style="background:rgba(255,255,255,0.03);border:1px solid #2A2A3F;border-radius:16px;overflow:hidden">
                @forelse($profile->bookings ?? [] as $booking)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid #1C1C2A">
                    <div style="display:flex;align-items:center;gap:14px">
                        <img src="{{ $booking->client->avatar_url }}" style="width:40px;height:40px;border-radius:10px;object-fit:cover">
                        <div>
                            <div style="font-size:0.88rem;font-weight:500;color:#F5F0E8">{{ $booking->client->name }}</div>
                            <div style="font-size:0.75rem;color:#8B8BA0">{{ $booking->event_date->format('M d, Y') }} · {{ $booking->event_type ?? 'Event' }}</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px">
                        <span style="font-size:0.78rem;font-weight:600;color:#F5F0E8">₱{{ number_format($booking->total_amount) }}</span>
                        @php $badge = $booking->status_badge; @endphp
                        <span style="font-size:0.7rem;padding:4px 10px;border-radius:20px;background:rgba({{ $badge['color'] === 'amber' ? '245,158,11' : ($badge['color'] === 'green' ? '46,204,113' : ($badge['color'] === 'blue' ? '52,152,219' : '231,76,60')) }},0.15);color:{{ $badge['color'] === 'amber' ? '#f59e0b' : ($badge['color'] === 'green' ? '#2ecc71' : ($badge['color'] === 'blue' ? '#3498db' : '#e74c3c')) }}">
                            {{ $badge['label'] }}
                        </span>
                        @if($booking->status === 'pending')
                        <form method="POST" action="{{ route('bookings.confirm', $booking) }}" style="margin:0">
                            @csrf
                            <button type="submit" style="font-size:0.75rem;padding:5px 12px;background:linear-gradient(135deg,#9A7A2E,#C9A84C);color:#0A0A0F;border:none;border-radius:8px;cursor:pointer;font-weight:600">Confirm</button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <div style="padding:48px;text-align:center">
                    <div style="font-size:2.5rem;margin-bottom:12px">📭</div>
                    <p style="color:#8B8BA0;font-size:0.88rem">No bookings yet. Share your profile to get started!</p>
                    <a href="{{ route('creators.show', $profile) }}" style="display:inline-block;margin-top:16px;padding:10px 20px;background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.3);border-radius:10px;color:#C9A84C;font-size:0.82rem;text-decoration:none">Share Profile</a>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Right sidebar --}}
        <div style="display:flex;flex-direction:column;gap:20px">

            {{-- Profile completeness --}}
            <div style="background:rgba(255,255,255,0.03);border:1px solid #2A2A3F;border-radius:16px;padding:20px">
                <h3 style="font-size:0.88rem;font-weight:600;color:#F5F0E8;margin-bottom:16px">Profile Completeness</h3>
                @php
                $checks = [
                ['Avatar', $user->avatar],
                ['Bio', $user->bio],
                ['Cover Photo', $profile->cover_photo],
                ['Brand Name', $profile->brand_name],
                ['Starting Price', $profile->starting_price],
                ['Service Areas', $profile->service_areas],
                ['Portfolio', $profile->portfolios_count > 0],
                ['Services', true],
                ];
                $done = collect($checks)->filter(fn($c) => $c[1])->count();
                $pct = round(($done / count($checks)) * 100);
                @endphp
                <div style="display:flex;justify-content:space-between;margin-bottom:8px">
                    <span style="font-size:0.78rem;color:#8B8BA0">{{ $done }}/{{ count($checks) }} complete</span>
                    <span style="font-size:0.78rem;color:#C9A84C;font-weight:600">{{ $pct }}%</span>
                </div>
                <div style="height:6px;background:#2A2A3F;border-radius:3px;margin-bottom:16px;overflow:hidden">
                    <div style="height:100%;width:{{ $pct }}%;background:linear-gradient(to right,#9A7A2E,#C9A84C);border-radius:3px;transition:width 0.8s"></div>
                </div>
                @foreach($checks as [$item, $done])
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
                    <div style="width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:{{ $done ? 'rgba(46,204,113,0.15)' : 'rgba(255,255,255,0.04)' }};border:1px solid {{ $done ? 'rgba(46,204,113,0.4)' : '#2A2A3F' }}">
                        @if($done)
                        <svg width="10" height="10" fill="none" stroke="#2ecc71" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                        @endif
                    </div>
                    <span style="font-size:0.8rem;color:{{ $done ? '#F5F0E8' : '#8B8BA0' }}">{{ $item }}</span>
                </div>
                @endforeach
                @if($pct < 100)
                    <a href="{{ route('creators.edit') }}" style="display:block;text-align:center;margin-top:12px;padding:10px;background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.3);border-radius:10px;color:#C9A84C;font-size:0.82rem;text-decoration:none">Complete Profile</a>
                    @endif
            </div>

            {{-- Recent Reviews --}}
            <div style="background:rgba(255,255,255,0.03);border:1px solid #2A2A3F;border-radius:16px;padding:20px">
                <h3 style="font-size:0.88rem;font-weight:600;color:#F5F0E8;margin-bottom:16px">Recent Reviews</h3>
                @forelse($profile->reviews ?? [] as $review)
                <div style="margin-bottom:16px;padding-bottom:16px;border-bottom:1px solid #1C1C2A">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                        <div style="display:flex;align-items:center;gap:8px">
                            <img src="{{ $review->reviewer->avatar_url }}" style="width:28px;height:28px;border-radius:50%;object-fit:cover">
                            <span style="font-size:0.82rem;color:#F5F0E8">{{ $review->reviewer->name }}</span>
                        </div>
                        <div style="display:flex;gap:2px">
                            @for($i=1;$i<=5;$i++)
                                <span style="color:{{ $i<=$review->rating ? '#C9A84C' : '#2A2A3F' }};font-size:0.7rem">★</span>
                                @endfor
                        </div>
                    </div>
                    <p style="font-size:0.8rem;color:#8B8BA0;line-height:1.5">{{ Str::limit($review->content, 80) }}</p>
                </div>
                @empty
                <p style="color:#8B8BA0;font-size:0.82rem;text-align:center;padding:20px 0">No reviews yet</p>
                @endforelse
            </div>

            {{-- Quick Links --}}
            <div style="background:rgba(255,255,255,0.03);border:1px solid #2A2A3F;border-radius:16px;padding:20px">
                <h3 style="font-size:0.88rem;font-weight:600;color:#F5F0E8;margin-bottom:14px">Quick Actions</h3>
                @foreach([
                ['Add Portfolio', route('creators.edit').'#portfolio', '🖼️'],
                ['Manage Services', route('creators.edit').'#services', '💼'],
                ['Set Availability', route('creators.edit').'#availability', '📅'],
                ['View Messages', route('messages.index'), '💬'],
                ] as [$label, $url, $icon])
                <a href="{{ $url }}" style="display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid #1C1C2A;text-decoration:none;color:#8B8BA0;font-size:0.85rem;transition:color 0.2s" onmouseover="this.style.color='#F5F0E8'" onmouseout="this.style.color='#8B8BA0'">
                    <span>{{ $icon }}</span>
                    {{ $label }}
                    <svg style="margin-left:auto" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection