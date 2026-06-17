<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Up Your Profile — NestPeek Photo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Inter:wght@300;400;500;600&family=DM+Mono&display=swap" rel="stylesheet">
    <style>
        :root {
            --sky: #0EA5E9;
            --sky-light: #38BDF8;
            --sky-mid: #0369A1;
            --navy: #0C4A6E;
            --sky-faint: #F0F9FF;
            --sky-pale: #E0F2FE;
            --slate: #64748B;
            --slate-mid: #94A3B8;
            --slate-light: #CBD5E1;
            --text-main: #0F172A;
            --text-muted: #475569;
            --border: rgba(14, 165, 233, 0.14);
            --border-mid: rgba(14, 165, 233, 0.28);
            --red: #EF4444;
            --red-faint: rgba(239, 68, 68, 0.08);
            --red-border: rgba(239, 68, 68, 0.25);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F8FBFF;
            min-height: 100vh;
            color: var(--text-main);
        }

        /* ── Top bar ── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 32px;
            background: #fff;
            border-bottom: 1px solid var(--border);
        }

        .topbar-brand {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.25rem;
            font-weight: 400;
            color: var(--navy);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topbar-brand span {
            display: inline-block;
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.85rem;
        }

        .topbar-step {
            font-family: 'DM Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--slate-mid);
        }

        /* ── Progress bar ── */
        .progress-wrap {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
        }

        .progress-steps {
            max-width: 700px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 0;
            padding: 16px 0;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
        }

        .step-item:last-child {
            flex: none;
        }

        .step-circle {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Mono', monospace;
            font-size: 0.7rem;
            font-weight: 600;
            flex-shrink: 0;
            border: 2px solid var(--border-mid);
            color: var(--slate-mid);
            background: #fff;
            transition: all 0.2s;
        }

        .step-circle.active {
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            border-color: transparent;
            color: #fff;
            box-shadow: 0 3px 10px rgba(14, 165, 233, 0.35);
        }

        .step-circle.done {
            background: var(--sky-pale);
            border-color: var(--sky-mid);
            color: var(--sky-mid);
        }

        .step-label {
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            color: var(--slate-mid);
            white-space: nowrap;
        }

        .step-label.active {
            color: var(--navy);
            font-weight: 600;
        }

        .step-connector {
            flex: 1;
            height: 1px;
            background: var(--border);
            margin: 0 10px;
        }

        /* ── Main layout ── */
        .page {
            max-width: 700px;
            margin: 40px auto 80px;
            padding: 0 20px;
        }

        /* ── Header ── */
        .page-header {
            margin-bottom: 32px;
        }

        .page-eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 0.63rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--sky-mid);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .page-eyebrow::before {
            content: '';
            display: inline-block;
            width: 24px;
            height: 1px;
            background: var(--sky-light);
        }

        .page-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--navy);
            margin-bottom: 6px;
            line-height: 1.2;
        }

        .page-sub {
            font-size: 0.88rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ── Card ── */
        .card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 2px 20px rgba(14, 165, 233, 0.06);
            margin-bottom: 16px;
        }

        .section-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--slate-mid);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Fields ── */
        .field {
            margin-bottom: 18px;
        }

        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 6px;
        }

        label .opt {
            font-weight: 400;
            color: var(--slate-mid);
            font-size: 0.71rem;
        }

        label .req {
            color: var(--red);
        }

        input[type="text"],
        input[type="number"],
        input[type="url"],
        select,
        textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border-mid);
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            color: var(--text-main);
            background: #fff;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            appearance: none;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--sky);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 96px;
            line-height: 1.65;
        }

        .field-hint {
            font-size: 0.72rem;
            color: var(--slate-mid);
            margin-top: 5px;
            line-height: 1.5;
        }

        .field-error {
            font-size: 0.74rem;
            color: var(--red);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Specialization grid ── */
        .spec-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .spec-option {
            display: none;
        }

        .spec-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 16px 10px;
            border: 1.5px solid var(--border-mid);
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            background: #fff;
        }

        .spec-label:hover {
            border-color: var(--sky-light);
            background: var(--sky-faint);
        }

        .spec-option:checked+.spec-label {
            border-color: var(--sky);
            background: var(--sky-faint);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.12);
        }

        .spec-icon {
            font-size: 1.6rem;
            line-height: 1;
        }

        .spec-name {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--navy);
            line-height: 1.3;
        }

        /* ── Tag input ── */
        .tag-input-wrap {
            border: 1.5px solid var(--border-mid);
            border-radius: 10px;
            padding: 8px 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            cursor: text;
            min-height: 46px;
            background: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .tag-input-wrap:focus-within {
            border-color: var(--sky);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }

        .tag-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--sky-pale);
            color: var(--sky-mid);
            border: 1px solid var(--border-mid);
            border-radius: 20px;
            padding: 3px 10px 3px 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .tag-pill button {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--sky-mid);
            font-size: 0.85rem;
            line-height: 1;
            padding: 0;
            display: flex;
            align-items: center;
            opacity: 0.7;
        }

        .tag-pill button:hover {
            opacity: 1;
        }

        .tag-text-input {
            border: none !important;
            outline: none !important;
            padding: 2px 4px !important;
            font-size: 0.82rem !important;
            min-width: 120px;
            flex: 1;
            background: transparent !important;
            box-shadow: none !important;
        }

        /* ── Price input ── */
        .price-wrap {
            position: relative;
        }

        .price-prefix {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-family: 'DM Mono', monospace;
            font-size: 0.8rem;
            color: var(--slate-mid);
            pointer-events: none;
        }

        .price-wrap input {
            padding-left: 32px;
        }

        /* ── Toggle ── */
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            background: var(--sky-faint);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            margin-bottom: 10px;
        }

        .toggle-info {
            flex: 1;
        }

        .toggle-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 2px;
        }

        .toggle-desc {
            font-size: 0.74rem;
            color: var(--text-muted);
        }

        .toggle {
            position: relative;
            width: 42px;
            height: 24px;
            flex-shrink: 0;
            margin-left: 16px;
        }

        .toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            inset: 0;
            background: var(--slate-light);
            border-radius: 24px;
            cursor: pointer;
            transition: 0.2s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            left: 3px;
            top: 3px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #fff;
            transition: 0.2s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
        }

        .toggle input:checked+.toggle-slider {
            background: var(--sky);
        }

        .toggle input:checked+.toggle-slider::before {
            transform: translateX(18px);
        }

        /* ── Errors alert ── */
        .alert-error {
            background: var(--red-faint);
            border: 1.5px solid var(--red-border);
            border-radius: 14px;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 0.83rem;
            color: #B91C1C;
        }

        .alert-error strong {
            display: block;
            margin-bottom: 6px;
        }

        .alert-error ul {
            padding-left: 18px;
        }

        /* ── Submit ── */
        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }

        .btn-skip {
            font-size: 0.82rem;
            color: var(--slate-mid);
            text-decoration: none;
            transition: color 0.2s;
        }

        .btn-skip:hover {
            color: var(--slate);
        }

        .btn-next {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            color: #fff;
            border: none;
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.35);
            transition: all 0.2s;
        }

        .btn-next:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.45);
        }

        /* ── Welcome banner ── */
        .welcome-banner {
            background: linear-gradient(135deg, #0C4A6E 0%, #0369A1 55%, #0EA5E9 100%);
            border-radius: 20px;
            padding: 28px 32px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .welcome-emoji {
            font-size: 2.8rem;
            flex-shrink: 0;
        }

        .welcome-text h2 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.3rem;
            font-weight: 400;
            color: #fff;
            margin-bottom: 4px;
        }

        .welcome-text p {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.55;
        }

        @media (max-width: 640px) {
            .field-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .spec-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .page {
                padding: 0 16px;
            }

            .card {
                padding: 20px;
            }

            .topbar {
                padding: 14px 20px;
            }
        }
    </style>
</head>

<body>

    {{-- Top bar --}}
    <div class="topbar">
        <a href="{{ route('home') }}" class="topbar-brand">
            <span>N</span>
            NestPeek Photo
        </a>
        <span class="topbar-step">Profile Setup</span>
    </div>

    {{-- Progress --}}
    <div class="progress-wrap">
        <div class="progress-steps">
            <div class="step-item">
                <div class="step-circle active">1</div>
                <span class="step-label active">Your Profile</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-item">
                <div class="step-circle">2</div>
                <span class="step-label">Services</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-item">
                <div class="step-circle">3</div>
                <span class="step-label">Done</span>
            </div>
        </div>
    </div>

    <div class="page">

        {{-- Welcome banner --}}
        <div class="welcome-banner">
            <div class="welcome-emoji">👋</div>
            <div class="welcome-text">
                <h2>Welcome, {{ $user->name }}!</h2>
                <p>Let's set up your creator profile. This is what clients will see when they discover you on NestPeek Photo.</p>
            </div>
        </div>

        {{-- Errors --}}
        @if($errors->any())
        <div class="alert-error">
            <strong>Please fix the following:</strong>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('onboarding.profile') }}" method="POST">
            @csrf

            {{-- ── Identity ── --}}
            <div class="card">
                <p class="section-label">Identity</p>

                <div class="field-row">
                    <div>
                        <label>Brand / Studio Name <span class="opt">(optional)</span></label>
                        <input type="text" name="brand_name"
                            value="{{ old('brand_name', $user->creatorProfile->brand_name) }}"
                            placeholder="e.g. Grace Manalo Photography">
                        <p class="field-hint">Leave blank to use your full name.</p>
                    </div>
                    <div>
                        <label>Tagline <span class="opt">(optional)</span></label>
                        <input type="text" name="tagline"
                            value="{{ old('tagline', $user->creatorProfile->tagline) }}"
                            placeholder="e.g. Capturing your most precious moments"
                            maxlength="100">
                        <p class="field-hint">One line that appears under your name.</p>
                    </div>
                </div>

                <div class="field">
                    <label>Bio <span class="opt">(optional)</span></label>
                    <textarea name="bio" placeholder="Tell clients a bit about yourself — your style, experience, what makes you unique…" maxlength="2000">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <div class="field-row">
                    <div>
                        <label>Location <span class="opt">(optional)</span></label>
                        <input type="text" name="location"
                            value="{{ old('location', $user->location) }}"
                            placeholder="e.g. Iloilo City, Philippines">
                    </div>
                    <div>
                        <label>Years of Experience <span class="opt">(optional)</span></label>
                        <input type="number" name="years_experience" min="0" max="50"
                            value="{{ old('years_experience', $user->creatorProfile->years_experience ?? 0) }}"
                            placeholder="0">
                    </div>
                </div>

                <div class="field">
                    <label>Starting Price <span class="opt">(optional)</span></label>
                    <div class="price-wrap">
                        <span class="price-prefix">₱</span>
                        <input type="number" name="starting_price" min="0" step="100"
                            value="{{ old('starting_price', $user->creatorProfile->starting_price) }}"
                            placeholder="e.g. 3500">
                    </div>
                    <p class="field-hint">The lowest price you offer. Shown on your public profile.</p>
                </div>
            </div>

            {{-- ── Specialization ── --}}
            <div class="card">
                <p class="section-label">Specialization <span style="color:var(--red);margin-left:2px">*</span></p>

                <div class="spec-grid">
                    @php
                    $specs = [
                    ['value' => 'wedding_photographer', 'icon' => '💍', 'label' => 'Wedding Photographer'],
                    ['value' => 'wedding_videographer', 'icon' => '🎬', 'label' => 'Wedding Videographer'],
                    ['value' => 'portrait_photographer', 'icon' => '🤍', 'label' => 'Portrait Photographer'],
                    ['value' => 'event_photographer', 'icon' => '🎉', 'label' => 'Event Photographer'],
                    ['value' => 'event_videographer', 'icon' => '📹', 'label' => 'Event Videographer'],
                    ['value' => 'photo_editor', 'icon' => '🖥️', 'label' => 'Photo Editor'],
                    ['value' => 'video_editor', 'icon' => '✂️', 'label' => 'Video Editor'],
                    ['value' => 'wedding_coordinator', 'icon' => '📋', 'label' => 'Wedding Coordinator'],
                    ['value' => 'drone_operator', 'icon' => '🚁', 'label' => 'Drone Operator'],
                    ['value' => 'photo_booth', 'icon' => '🖼️', 'label' => 'Photo Booth'],
                    ['value' => 'lighting_specialist', 'icon' => '💡', 'label' => 'Lighting Specialist'],
                    ['value' => 'other', 'icon' => '✨', 'label' => 'Other'],
                    ];
                    $current = old('specialization', $user->creatorProfile->specialization ?? 'wedding_photographer');
                    @endphp
                    @foreach($specs as $spec)
                    <div>
                        <input class="spec-option" type="radio" name="specialization"
                            id="spec_{{ $spec['value'] }}"
                            value="{{ $spec['value'] }}"
                            {{ $current === $spec['value'] ? 'checked' : '' }}>
                        <label class="spec-label" for="spec_{{ $spec['value'] }}">
                            <span class="spec-icon">{{ $spec['icon'] }}</span>
                            <span class="spec-name">{{ $spec['label'] }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>
                @error('specialization')
                <p class="field-error" style="margin-top:10px">⚠ {{ $message }}</p>
                @enderror
            </div>

            {{-- ── Skills & Style ── --}}
            <div class="card">
                <p class="section-label">Skills, Style &amp; Equipment</p>

                <div class="field">
                    <label>Photography Styles <span class="opt">(optional — press Enter or comma to add)</span></label>
                    <div class="tag-input-wrap" id="styles-wrap">
                        <input class="tag-text-input" id="styles-input" type="text"
                            placeholder="e.g. Candid, Editorial, Fine Art…">
                    </div>
                    <input type="hidden" name="styles" id="styles-hidden"
                        value="{{ old('styles', is_array($user->creatorProfile->styles) ? implode(',', $user->creatorProfile->styles) : '') }}">
                    <p class="field-hint">Styles help clients find you when they search for a specific look.</p>
                </div>

                <div class="field">
                    <label>Skills <span class="opt">(optional)</span></label>
                    <div class="tag-input-wrap" id="skills-wrap">
                        <input class="tag-text-input" id="skills-input" type="text"
                            placeholder="e.g. Lightroom, Adobe Premiere, Drone…">
                    </div>
                    <input type="hidden" name="skills" id="skills-hidden"
                        value="{{ old('skills', is_array($user->creatorProfile->skills) ? implode(',', $user->creatorProfile->skills) : '') }}">
                </div>

                <div class="field">
                    <label>Equipment <span class="opt">(optional)</span></label>
                    <div class="tag-input-wrap" id="equipment-wrap">
                        <input class="tag-text-input" id="equipment-input" type="text"
                            placeholder="e.g. Sony A7III, 85mm f/1.8…">
                    </div>
                    <input type="hidden" name="equipment" id="equipment-hidden"
                        value="{{ old('equipment', is_array($user->creatorProfile->equipment) ? implode(',', $user->creatorProfile->equipment) : '') }}">
                </div>

                <div class="field">
                    <label>Service Areas <span class="opt">(optional)</span></label>
                    <div class="tag-input-wrap" id="service_areas-wrap">
                        <input class="tag-text-input" id="service_areas-input" type="text"
                            placeholder="e.g. Iloilo City, Bacolod, Cebu…">
                    </div>
                    <input type="hidden" name="service_areas" id="service_areas-hidden"
                        value="{{ old('service_areas', is_array($user->creatorProfile->service_areas) ? implode(',', $user->creatorProfile->service_areas) : '') }}">
                    <p class="field-hint">Cities or regions you're willing to travel to for shoots.</p>
                </div>
            </div>

            {{-- ── Social & Contact ── --}}
            <div class="card">
                <p class="section-label">Social &amp; Contact</p>

                <div class="field-row">
                    <div>
                        <label>Instagram <span class="opt">(optional)</span></label>
                        <input type="text" name="instagram"
                            value="{{ old('instagram', $user->instagram) }}"
                            placeholder="@yourhandle">
                    </div>
                    <div>
                        <label>Facebook <span class="opt">(optional)</span></label>
                        <input type="text" name="facebook"
                            value="{{ old('facebook', $user->facebook) }}"
                            placeholder="https://facebook.com/yourpage">
                    </div>
                </div>

                <div class="field-row">
                    <div>
                        <label>Website <span class="opt">(optional)</span></label>
                        <input type="url" name="website"
                            value="{{ old('website', $user->website) }}"
                            placeholder="https://yourwebsite.com">
                    </div>
                    <div>
                        <label>Phone <span class="opt">(optional)</span></label>
                        <input type="text" name="phone"
                            value="{{ old('phone', $user->phone) }}"
                            placeholder="+63 912 345 6789">
                    </div>
                </div>
            </div>

            {{-- ── Availability ── --}}
            <div class="card">
                <p class="section-label">Availability</p>

                <div class="toggle-row">
                    <div class="toggle-info">
                        <div class="toggle-title">Available for bookings</div>
                        <div class="toggle-desc">Clients can send you booking requests right away.</div>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" name="is_available" value="1"
                            {{ old('is_available', $user->creatorProfile->is_available ?? true) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div class="toggle-info">
                        <div class="toggle-title">Travels internationally</div>
                        <div class="toggle-desc">You're open to destination shoots outside the Philippines.</div>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" name="travels_internationally" value="1"
                            {{ old('travels_internationally', $user->creatorProfile->travels_internationally) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="field" style="margin-top:4px;margin-bottom:0">
                    <label>Availability Note <span class="opt">(optional)</span></label>
                    <input type="text" name="availability_note"
                        value="{{ old('availability_note', $user->creatorProfile->availability_note) }}"
                        placeholder="e.g. Booking 3 months in advance. Weekends available.">
                    <p class="field-hint">Shown in the booking CTA on your profile page.</p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="form-footer">
                <a href="{{ route('dashboard') }}" class="btn-skip">Skip for now →</a>
                <button type="submit" class="btn-next">
                    Continue to Services
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

        </form>
    </div>

    <script>
        // ── Tag input system ──────────────────────────────────────
        const tagFields = ['styles', 'skills', 'equipment', 'service_areas'];

        tagFields.forEach(field => {
            const wrap = document.getElementById(`${field}-wrap`);
            const input = document.getElementById(`${field}-input`);
            const hidden = document.getElementById(`${field}-hidden`);

            let tags = hidden.value ?
                hidden.value.split(',').map(t => t.trim()).filter(Boolean) :
                [];

            function render() {
                // Remove existing pills
                wrap.querySelectorAll('.tag-pill').forEach(p => p.remove());
                // Re-add pills before the input
                tags.forEach((tag, i) => {
                    const pill = document.createElement('span');
                    pill.className = 'tag-pill';
                    pill.innerHTML = `${tag}<button type="button" data-i="${i}" title="Remove">✕</button>`;
                    pill.querySelector('button').addEventListener('click', () => {
                        tags.splice(i, 1);
                        render();
                    });
                    wrap.insertBefore(pill, input);
                });
                hidden.value = tags.join(',');
            }

            function addTag(val) {
                const clean = val.trim().replace(/,$/, '');
                if (clean && !tags.includes(clean)) {
                    tags.push(clean);
                    render();
                }
                input.value = '';
            }

            input.addEventListener('keydown', e => {
                if (e.key === 'Enter' || e.key === ',') {
                    e.preventDefault();
                    addTag(input.value);
                } else if (e.key === 'Backspace' && !input.value && tags.length) {
                    tags.pop();
                    render();
                }
            });

            input.addEventListener('blur', () => {
                if (input.value.trim()) addTag(input.value);
            });

            wrap.addEventListener('click', () => input.focus());

            // Init from existing hidden value
            render();
        });
    </script>

</body>

</html>