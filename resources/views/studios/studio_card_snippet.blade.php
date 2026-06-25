{{-- ★ Studio widget — shows existing studio OR the "Create" CTA --}}
@if($studio)
{{-- ── EXISTING STUDIO ── --}}
<div class="studio-card" style="background: linear-gradient(135deg, #F5F3FF 0%, #EDE9FE 100%);">
    <p class="studio-card-label">Your Studio</p>
    <p class="studio-card-title">{{ $studio->name }}</p>
    @if($studio->tagline)
    <p class="studio-card-desc">{{ $studio->tagline }}</p>
    @endif

    {{-- Quick stats row --}}
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;margin-bottom:16px">
        <div style="background:rgba(124,58,237,0.06);border:1px solid var(--studio-border);border-radius:10px;padding:10px;text-align:center">
            <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:#3B0764">
                {{ $studio->total_reviews }}
            </div>
            <div style="font-family:'DM Mono',monospace;font-size:0.55rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--studio-mid);margin-top:2px">Reviews</div>
        </div>
        <div style="background:rgba(124,58,237,0.06);border:1px solid var(--studio-border);border-radius:10px;padding:10px;text-align:center">
            <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:#3B0764">
                {{ number_format($studio->average_rating, 1) }}
            </div>
            <div style="font-family:'DM Mono',monospace;font-size:0.55rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--studio-mid);margin-top:2px">Rating</div>
        </div>
        <div style="background:rgba(124,58,237,0.06);border:1px solid var(--studio-border);border-radius:10px;padding:10px;text-align:center">
            <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:#3B0764">
                {{ $studio->creators->count() }}
            </div>
            <div style="font-family:'DM Mono',monospace;font-size:0.55rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--studio-mid);margin-top:2px">Members</div>
        </div>
    </div>

    <div style="display:flex;gap:8px">
        <a href="{{ route('studios.show', $studio) }}" class="btn-studio" style="flex:1;justify-content:center">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                <circle cx="12" cy="12" r="3" />
            </svg>
            View Studio
        </a>
        <a href="{{ route('studios.edit', $studio) }}"
            style="display:inline-flex;align-items:center;gap:6px;padding:10px 16px;
                background:rgba(124,58,237,0.1);border:1.5px solid var(--studio-border);
                color:var(--studio-mid);border-radius:50px;font-size:0.82rem;font-weight:600;
                text-decoration:none;transition:all 0.2s;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
            </svg>
            Edit
        </a>
    </div>

    @if(!$studio->is_active)
    <p style="margin-top:12px;font-size:0.72rem;color:#92400E;background:var(--amber-faint);
        border:1px solid var(--amber-border);border-radius:8px;padding:7px 10px;text-align:center">
        ⚠️ Your studio is currently inactive. Edit it to make it visible to clients.
    </p>
    @endif
</div>

@else
{{-- ── NO STUDIO YET — show the CTA ── --}}
<div class="studio-card">
    <p class="studio-card-label">Collaborate</p>
    <p class="studio-card-title">Launch a Studio</p>
    <p class="studio-card-desc">Group your crew — photographers, coordinators, makeup artists, and more — under one bookable brand. Clients book the team, not just you.</p>
    <div class="studio-pill-row">
        <span class="studio-pill">📷 Photo &amp; Video</span>
        <span class="studio-pill">🎤 Hosts &amp; MCs</span>
        <span class="studio-pill">💄 Beauty</span>
        <span class="studio-pill">🎵 Performers</span>
    </div>
    <button class="btn-studio" onclick="openStudioModal()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="18" height="18" rx="4" />
            <path d="M12 8v8M8 12h8" />
        </svg>
        Create a Studio
    </button>
</div>
@endif