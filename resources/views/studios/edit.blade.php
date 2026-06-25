@extends('layouts.app')

@section('title', 'Edit ' . $studio->name . ' — NestPeek Photo')

@section('content')

<style>
    :root {
        --sky: #0EA5E9; --sky-mid: #0369A1; --navy: #0C4A6E;
        --sky-faint: #F0F9FF; --slate: #64748B; --slate-mid: #94A3B8;
        --text-main: #0F172A; --text-muted: #475569;
        --border: rgba(14, 165, 233, 0.14); --border-mid: rgba(14, 165, 233, 0.28);
        --red: #EF4444; --red-faint: rgba(239, 68, 68, 0.06);
    }
    *, *::before, *::as { box-sizing: border-box; }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Inter', sans-serif; background: #F8FBFF; color: var(--text-main); }

    .form-page { max-width: 760px; margin: 0 auto; padding: 40px 24px 80px; }

    .form-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 28px; }
    .form-title { font-family: 'Playfair Display', serif; font-size: 1.9rem; color: var(--navy); font-weight: 400; }
    .form-sub { font-size: 0.85rem; color: var(--text-muted); margin-top: 4px; }

    .btn-back-link { font-size: 0.8rem; color: var(--sky-mid); text-decoration: none; font-weight: 600; white-space: nowrap; padding-top: 6px; }

    .form-card { background: #fff; border: 1.5px solid var(--border); border-radius: 20px; padding: 28px; box-shadow: 0 2px 16px rgba(14,165,233,0.04); }

    .form-section { margin-bottom: 26px; }
    .form-section:last-of-type { margin-bottom: 0; }
    .form-section-title { font-family: 'DM Mono', monospace; font-size: 0.62rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--sky-mid); margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid var(--border); }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-field { display: flex; flex-direction: column; gap: 6px; }
    .form-field.span-2 { grid-column: 1 / -1; }

    .form-label { font-size: 0.78rem; font-weight: 600; color: var(--text-main); }
    .req { color: var(--red); }

    .form-input { border: 1.5px solid var(--border-mid); border-radius: 10px; padding: 10px 13px; font-family: 'Inter', sans-serif; font-size: 0.86rem; outline: none; transition: border-color 0.15s; width: 100%; color: var(--text-main); }
    .form-input:focus { border-color: var(--sky); }
    .form-textarea { min-height: 100px; resize: vertical; font-family: 'Inter', sans-serif; }

    .form-hint { font-size: 0.7rem; color: var(--slate-mid); }
    .form-error { font-size: 0.72rem; color: var(--red); }

    .check-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .check-item { display: flex; align-items: center; gap: 8px; font-size: 0.82rem; color: var(--text-muted); background: var(--sky-faint); border: 1px solid var(--border); border-radius: 10px; padding: 9px 12px; cursor: pointer; }

    .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border); }

    .btn-cancel { padding: 10px 22px; background: transparent; color: var(--slate); border: 1.5px solid var(--border-mid); border-radius: 50px; font-size: 0.84rem; font-weight: 600; text-decoration: none; }
    .btn-submit { padding: 10px 26px; background: linear-gradient(135deg, var(--sky), var(--sky-mid)); color: #fff; border: none; border-radius: 50px; font-size: 0.84rem; font-weight: 700; cursor: pointer; box-shadow: 0 4px 14px rgba(14,165,233,0.28); }

    .alert-errors { background: var(--red-faint); border: 1.5px solid rgba(239,68,68,0.25); border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; font-size: 0.82rem; color: #991B1B; }

    @media(max-width: 600px) {
        .form-grid, .check-grid { grid-template-columns: 1fr; }
        .form-header { flex-direction: column; }
    }
</style>

<div class="form-page">
    <div class="form-header">
        <div>
            <h1 class="form-title">Edit {{ $studio->name }}</h1>
            <p class="form-sub">Update your studio's profile, rates, and photos.</p>
        </div>
        <a href="{{ route('studios.show', $studio) }}" class="btn-back-link">← Back to dashboard</a>
    </div>

    @if($errors->any())
    <div class="alert-errors">
        Please fix the following before continuing:
        <ul style="margin:6px 0 0 18px">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('studios.update', $studio) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-card">
            @include('studios._form', ['studio' => $studio])
        </div>

        <div class="form-actions">
            <a href="{{ route('studios.show', $studio) }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-submit">Save Changes</button>
        </div>
    </form>
</div>

@endsection
