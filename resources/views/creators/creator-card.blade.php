<a href="{{ route('creators.show', $creator) }}" style="display:block;text-decoration:none">
    <div class="card" style="overflow:hidden;transition:all var(--transition)" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 12px 40px rgba(0,0,0,0.35)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow=''">
        {{-- Cover image --}}
        <div style="height:160px;background:var(--bg3);position:relative;overflow:hidden">
            @if($creator->cover_photo)
            <img src="{{ Storage::url($creator->cover_photo) }}" style="width:100%;height:100%;object-fit:cover">
            @else
            <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--bg3),var(--bg4));display:flex;align-items:center;justify-content:center;font-size:2rem;opacity:0.3">📸</div>
            @endif
            {{-- Specialization badge --}}
            <div style="position:absolute;top:10px;left:10px">
                <span class="badge badge-gold" style="font-size:0.68rem">{{ ucwords(str_replace('_',' ',$creator->specialization)) }}</span>
            </div>
            @if($creator->is_available)
            <div style="position:absolute;top:10px;right:10px;width:8px;height:8px;border-radius:50%;background:var(--green);box-shadow:0 0 0 3px rgba(46,204,113,0.25)"></div>
            @endif
        </div>

        {{-- Card body --}}
        <div style="padding:16px">
            <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:12px">
                <img src="{{ $creator->user->avatar_url }}" class="avatar" style="width:48px;height:48px;border-radius:12px;border:2px solid var(--border2);margin-top:-28px;position:relative;z-index:1;background:var(--bg2)">
                <div style="flex:1;min-width:0;margin-top:0">
                    <div style="font-size:0.925rem;font-weight:500;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                        {{ $creator->brand_name ?? $creator->user->name }}
                    </div>
                    @if($creator->user->location)
                    <div style="font-size:0.75rem;color:var(--text3);margin-top:2px;display:flex;align-items:center;gap:4px">
                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $creator->user->location }}
                    </div>
                    @endif
                </div>
            </div>

            @if($creator->tagline)
            <p style="font-size:0.8rem;color:var(--text2);line-height:1.5;margin-bottom:12px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical">{{ $creator->tagline }}</p>
            @endif

            <div style="display:flex;align-items:center;justify-content:space-between;padding-top:12px;border-top:1px solid var(--border)">
                <div>
                    @if($creator->average_rating > 0)
                    <div style="display:flex;align-items:center;gap:5px">
                        <span style="color:var(--gold);font-size:0.82rem">★</span>
                        <span style="font-size:0.82rem;font-weight:500;color:var(--text)">{{ number_format($creator->average_rating,1) }}</span>
                        <span style="font-size:0.75rem;color:var(--text3)">({{ $creator->total_reviews }})</span>
                    </div>
                    @endif
                </div>
                @if($creator->starting_price)
                <div style="text-align:right">
                    <div style="font-size:0.7rem;color:var(--text3)">Starting at</div>
                    <div style="font-size:0.9rem;font-weight:600;color:var(--gold)">₱{{ number_format($creator->starting_price) }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</a>