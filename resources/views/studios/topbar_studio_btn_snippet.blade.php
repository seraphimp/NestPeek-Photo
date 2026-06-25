{{-- Topbar: link to studio if exists, otherwise open modal --}}
@if($studio)
<a href="{{ route('studios.show', $studio) }}" class="btn-nav-studio">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="18" height="18" rx="4" />
        <path d="M9 9h6M9 12h6M9 15h4" />
    </svg>
    <span class="label">My Studio</span>
</a>
@else
<button class="btn-nav-studio" onclick="openStudioModal()">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="18" height="18" rx="4" />
        <path d="M12 8v8M8 12h8" />
    </svg>
    <span class="label">Create Studio</span>
</button>
@endif

