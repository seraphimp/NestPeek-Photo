<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Your Services — NestPeek Photo</title>
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

        .logo-box {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .topbar-step {
            font-family: 'DM Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--slate-mid);
        }

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
            font-size: 0.75rem;
            color: var(--slate-mid);
            white-space: nowrap;
        }

        .step-label.done {
            color: var(--sky-mid);
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

        .step-connector.done {
            background: var(--sky-light);
        }

        .page {
            max-width: 700px;
            margin: 40px auto 80px;
            padding: 0 20px;
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
        }

        .page-sub {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin-bottom: 28px;
            line-height: 1.6;
        }

        .card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            padding: 28px 30px;
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

        .skip-notice {
            background: var(--sky-faint);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 14px 18px;
            font-size: 0.82rem;
            color: var(--text-muted);
            line-height: 1.55;
            margin-bottom: 16px;
        }

        .service-entry {
            border: 1.5px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 12px;
            background: var(--sky-faint);
        }

        .service-entry-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .service-entry-num {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 0.95rem;
            color: var(--navy);
        }

        .service-entry-num span {
            font-family: 'DM Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--slate-mid);
            margin-left: 8px;
        }

        .btn-remove {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--slate-mid);
            font-size: 1.1rem;
            padding: 4px 6px;
            border-radius: 6px;
            transition: color 0.2s, background 0.2s;
            line-height: 1;
        }

        .btn-remove:hover {
            color: var(--red);
            background: var(--red-faint);
        }

        .sfield {
            margin-bottom: 12px;
        }

        .sfield:last-child {
            margin-bottom: 0;
        }

        .sfield-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        .sfield-row-3 {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 5px;
        }

        label .opt {
            font-weight: 400;
            color: var(--slate-mid);
            font-size: 0.7rem;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid var(--border-mid);
            border-radius: 9px;
            font-family: 'Inter', sans-serif;
            font-size: 0.83rem;
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
            min-height: 68px;
            line-height: 1.6;
        }

        .price-wrap {
            position: relative;
        }

        .price-prefix {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-family: 'DM Mono', monospace;
            font-size: 0.78rem;
            color: var(--slate-mid);
            pointer-events: none;
        }

        .price-wrap input {
            padding-left: 28px;
        }

        .btn-add {
            width: 100%;
            padding: 13px;
            border: 1.5px dashed var(--border-mid);
            border-radius: 14px;
            background: transparent;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            color: var(--sky-mid);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-add:hover {
            border-color: var(--sky);
            background: var(--sky-faint);
        }

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }

        .btn-back-link {
            font-size: 0.82rem;
            color: var(--slate-mid);
            text-decoration: none;
            transition: color 0.2s;
        }

        .btn-back-link:hover {
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

        .btn-skip-link {
            font-size: 0.82rem;
            color: var(--slate-mid);
            text-decoration: none;
            transition: color 0.2s;
            cursor: pointer;
            background: none;
            border: none;
            font-family: 'Inter', sans-serif;
        }

        .btn-skip-link:hover {
            color: var(--slate);
        }

        @media (max-width: 640px) {

            .sfield-row,
            .sfield-row-3 {
                grid-template-columns: 1fr;
            }

            .page {
                padding: 0 16px;
            }

            .card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="topbar">
        <a href="{{ route('home') }}" class="topbar-brand">
            <span class="logo-box">N</span>
            NestPeek Photo
        </a>
        <span class="topbar-step">Profile Setup</span>
    </div>

    <div class="progress-wrap">
        <div class="progress-steps">
            <div class="step-item">
                <div class="step-circle done">✓</div>
                <span class="step-label done">Your Profile</span>
            </div>
            <div class="step-connector done"></div>
            <div class="step-item">
                <div class="step-circle active">2</div>
                <span class="step-label active">Services</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-item">
                <div class="step-circle">3</div>
                <span class="step-label">Done</span>
            </div>
        </div>
    </div>

    <div class="page">
        <p class="page-eyebrow">Step 2 of 2</p>
        <h1 class="page-title">Add your services</h1>
        <p class="page-sub">List the packages clients can book from you. You can always edit these later from your dashboard.</p>

        <div class="skip-notice">
            <strong>This step is optional.</strong> You can skip it now and add services later — but clients won't be able to book you until you have at least one active service.
        </div>

        @if($errors->any())
        <div style="background:var(--red-faint);border:1.5px solid var(--red-border);border-radius:14px;padding:14px 18px;margin-bottom:24px;font-size:0.83rem;color:#B91C1C">
            <strong style="display:block;margin-bottom:6px">Please fix the following:</strong>
            <ul style="padding-left:18px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <form action="{{ route('onboarding.complete') }}" method="POST" id="main-form">
            @csrf
            <div class="card">
                <p class="section-label">Your Packages</p>
                <div id="services-list"></div>
                <button type="button" class="btn-add" id="add-btn">
                    <span style="font-size:1.2rem;line-height:1">+</span> Add a Service
                </button>
            </div>

            <div class="form-footer">
                <a href="{{ route('onboarding.start') }}" class="btn-back-link">← Back</a>
                <div style="display:flex;gap:16px;align-items:center">
                    <button type="button" class="btn-skip-link" id="skip-btn">Skip for now →</button>
                    <button type="submit" class="btn-next">
                        Finish Setup
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </form>

        <form id="skip-form" action="{{ route('onboarding.complete') }}" method="POST" style="display:none">@csrf</form>
    </div>

    <script>
        const CATS = [{
                value: 'wedding_package',
                label: '💍 Wedding Package'
            },
            {
                value: 'portrait_session',
                label: '🤍 Portrait Session'
            },
            {
                value: 'event_coverage',
                label: '🎉 Event Coverage'
            },
            {
                value: 'video_production',
                label: '🎬 Video Production'
            },
            {
                value: 'photo_editing',
                label: '🖥️ Photo Editing'
            },
            {
                value: 'studio_rental',
                label: '🏛️ Studio Rental'
            },
            {
                value: 'coordination',
                label: '📋 Coordination'
            },
            {
                value: 'add_on',
                label: '➕ Add-on'
            },
            {
                value: 'other',
                label: '✨ Other'
            },
        ];

        let idx = 0;

        function catOptions() {
            return '<option value="">Select…</option>' +
                CATS.map(c => `<option value="${c.value}">${c.label}</option>`).join('');
        }

        function addEntry() {
            const i = idx++;
            const html = `
        <div class="service-entry" id="se-${i}">
            <div class="service-entry-header">
                <div class="service-entry-num">Service <span>#${i + 1}</span></div>
                <button type="button" class="btn-remove" onclick="document.getElementById('se-${i}').remove()" title="Remove">✕</button>
            </div>
            <div class="sfield-row">
                <div class="sfield">
                    <label>Service Name <span style="color:var(--red)">*</span></label>
                    <input type="text" name="services[${i}][name]" placeholder="e.g. Full-Day Wedding Coverage" required>
                </div>
                <div class="sfield">
                    <label>Category <span style="color:var(--red)">*</span></label>
                    <select name="services[${i}][category]" required>${catOptions()}</select>
                </div>
            </div>
            <div class="sfield">
                <label>Description <span class="opt">(optional)</span></label>
                <textarea name="services[${i}][description]" placeholder="Describe what's included…"></textarea>
            </div>
            <div class="sfield">
                <label>Inclusions <span class="opt">(optional)</span></label>
                <input type="text" name="services[${i}][inclusions]" placeholder="e.g. 8hrs coverage, 300+ edited photos, online gallery">
            </div>
            <div class="sfield-row-3">
                <div class="sfield">
                    <label>Price <span style="color:var(--red)">*</span></label>
                    <div class="price-wrap">
                        <span class="price-prefix">₱</span>
                        <input type="number" name="services[${i}][price]" min="0" step="100" placeholder="25000" required>
                    </div>
                </div>
                <div class="sfield">
                    <label>Price Type</label>
                    <select name="services[${i}][price_type]">
                        <option value="fixed">Fixed</option>
                        <option value="per_hour">Per Hour</option>
                        <option value="starting_at">Starting At</option>
                    </select>
                </div>
                <div class="sfield">
                    <label>Duration (hrs) <span class="opt">(opt)</span></label>
                    <input type="number" name="services[${i}][duration_hours]" min="0" step="0.5" placeholder="8">
                </div>
            </div>
            <div class="sfield-row">
                <div class="sfield">
                    <label>Deposit % <span class="opt">(optional)</span></label>
                    <input type="number" name="services[${i}][deposit_percentage]" min="0" max="100" placeholder="e.g. 30">
                </div>
                <div class="sfield">
                    <label>Max bookings/day</label>
                    <input type="number" name="services[${i}][max_bookings_per_day]" min="1" value="1">
                </div>
            </div>
        </div>`;
            document.getElementById('services-list').insertAdjacentHTML('beforeend', html);
        }

        document.getElementById('add-btn').addEventListener('click', addEntry);
        document.getElementById('skip-btn').addEventListener('click', () => document.getElementById('skip-form').submit());

        // Start with one entry
        addEntry();
    </script>

</body>

</html>