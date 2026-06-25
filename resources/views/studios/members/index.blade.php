<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Members — {{ $studio->name }} · NestPeek Photo</title>
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
            --green: #10B981;
            --green-faint: rgba(16, 185, 129, 0.08);
            --green-border: rgba(16, 185, 129, 0.25);
            --amber: #F59E0B;
            --amber-faint: rgba(245, 158, 11, 0.08);
            --amber-border: rgba(245, 158, 11, 0.25);
            --red: #EF4444;
            --red-faint: rgba(239, 68, 68, 0.08);
            --red-border: rgba(239, 68, 68, 0.25);
            --studio: #7C3AED;
            --studio-faint: rgba(124, 58, 237, 0.07);
            --studio-border: rgba(124, 58, 237, 0.22);
            --studio-mid: #6D28D9;
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

        /* Topbar - SAME AS DASHBOARD */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 32px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-brand {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.2rem;
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

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-nav {
            display: flex;
            gap: 4px;
        }

        .topbar-nav a {
            font-size: 0.82rem;
            color: var(--slate);
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 8px;
            transition: background 0.15s, color 0.15s;
        }

        .topbar-nav a:hover {
            background: var(--sky-faint);
            color: var(--navy);
        }

        .btn-nav-studio {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--studio-mid);
            background: var(--studio-faint);
            border: 1.5px solid var(--studio-border);
            padding: 6px 14px;
            border-radius: 50px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-nav-studio:hover {
            background: rgba(124, 58, 237, 0.13);
            border-color: var(--studio);
            color: var(--studio);
        }

        .topbar-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(12, 74, 110, 0.12);
            min-width: 180px;
            overflow: hidden;
            z-index: 200;
        }

        .dropdown:hover .dropdown-menu,
        .dropdown-menu:hover {
            display: block;
        }

        .dropdown-menu a,
        .dropdown-menu button {
            display: block;
            width: 100%;
            padding: 10px 16px;
            font-size: 0.82rem;
            color: var(--text-main);
            text-decoration: none;
            text-align: left;
            background: none;
            border: none;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background 0.15s;
        }

        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background: var(--sky-faint);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0;
        }

        .dropdown-menu .danger {
            color: var(--red);
        }

        /* Page */
        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 24px 80px;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 28px;
            gap: 16px;
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
            margin-bottom: 6px;
        }

        .page-eyebrow::before {
            content: '';
            display: inline-block;
            width: 20px;
            height: 1px;
            background: var(--sky-light);
        }

        .page-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.8rem;
            font-weight: 400;
            color: var(--navy);
            line-height: 1.2;
        }

        .page-sub {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 22px;
            background: linear-gradient(135deg, var(--sky), var(--sky-mid));
            color: #fff;
            border: none;
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(14, 165, 233, 0.3);
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(14, 165, 233, 0.4);
        }

        .card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 2px 16px rgba(14, 165, 233, 0.05);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-body {
            padding: 16px 24px 24px;
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border: 1.5px solid var(--border-mid);
            border-radius: 50px;
            color: var(--sky-mid);
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            background: none;
            cursor: pointer;
        }

        .btn-ghost:hover {
            background: var(--sky-faint);
            border-color: var(--sky);
        }

        .badge {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 0.67rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .badge-sky {
            background: rgba(14, 165, 233, 0.12);
            border: 1px solid rgba(14, 165, 233, 0.28);
            color: var(--sky-mid);
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 500;
            text-transform: capitalize;
        }

        .badge-secondary {
            background: var(--sky-faint);
            color: var(--sky-mid);
            border: 1px solid var(--border-mid);
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 500;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }

        .alert-success {
            background: var(--green-faint);
            border: 1px solid var(--green-border);
            color: #065F46;
        }

        .alert-danger {
            background: var(--red-faint);
            border: 1px solid var(--red-border);
            color: #991B1B;
        }

        .alert-dismissible {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: var(--slate);
            padding: 0 4px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--slate-mid);
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 16px;
            display: block;
        }

        .empty-state p {
            font-size: 0.83rem;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        .btn-action {
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 500;
            cursor: pointer;
            border: 1.5px solid;
            font-family: 'Inter', sans-serif;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .btn-decline {
            background: rgba(239, 68, 68, 0.08);
            color: #B91C1B;
            border-color: rgba(239, 68, 68, 0.25);
        }

        .btn-decline:hover {
            background: #EF4444;
            color: #fff;
            border-color: #EF4444;
        }

        @media (max-width: 560px) {
            .page {
                padding: 20px 16px 60px;
            }

            .topbar {
                padding: 14px 20px;
            }

            .page-header {
                flex-direction: column;
            }

            .btn-nav-studio .label {
                display: none;
            }
        }
    </style>
</head>

<body>

    {{-- Topbar - SAME AS DASHBOARD --}}
    <nav class="topbar">
        <a href="{{ route('home') }}" class="topbar-brand">
            <span class="logo-box">N</span>
            NestPeek Photo
        </a>
        <div class="topbar-right">
            <nav class="topbar-nav">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('bookings.index') }}">Bookings</a>
                <a href="{{ route('portfolio.index') }}">Portfolio</a>
                <a href="{{ route('creators.edit') }}">Services</a>
            </nav>

            <a href="{{ route('studios.show', $studio) }}" class="btn-nav-studio">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="4" />
                    <path d="M12 8v8M8 12h8" />
                </svg>
                <span class="label">{{ $studio->name }}</span>
            </a>

            <div class="dropdown">
                <div class="topbar-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="dropdown-menu">
                    <a href="{{ route('onboarding.start') }}">Edit Profile</a>
                    <a href="{{ route('creators.show', $profile->slug ?? $profile->id) }}">Public Profile</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="danger">Sign out</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="page">

        {{-- Page header --}}
        <div class="page-header">
            <div>
                <p class="page-eyebrow">Studio Management</p>
                <h1 class="page-title">Team Members</h1>
                <p class="page-sub">Manage your studio team members — <strong>{{ $studio->name }}</strong></p>
            </div>
            <a href="{{ route('studios.members.create', $studio) }}" class="btn-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M5 12h8" />
                </svg>
                Add Team Member
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            {{ session('success') }}
            <button type="button" class="btn-close" onclick="this.parentElement.remove()">✕</button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if($members->isEmpty())
        <div class="empty-state">
            <span class="empty-state-icon">👥</span>
            <p>No team members yet. Start by adding your first team member.</p>
            <a href="{{ route('studios.members.create', $studio) }}" class="btn-ghost">Add a team member →</a>
        </div>
        @else
        <div class="card">
            <div class="card-body" style="padding:0;overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;min-width:600px;">
                    <thead>
                        <tr style="background:var(--sky-faint);">
                            <th style="padding:14px 20px;font-size:0.65rem;font-family:'DM Mono',monospace;letter-spacing:0.1em;text-transform:uppercase;color:var(--slate-mid);text-align:left;border-bottom:1px solid var(--border);">Name</th>
                            <th style="padding:14px 20px;font-size:0.65rem;font-family:'DM Mono',monospace;letter-spacing:0.1em;text-transform:uppercase;color:var(--slate-mid);text-align:left;border-bottom:1px solid var(--border);">Email</th>
                            <th style="padding:14px 20px;font-size:0.65rem;font-family:'DM Mono',monospace;letter-spacing:0.1em;text-transform:uppercase;color:var(--slate-mid);text-align:left;border-bottom:1px solid var(--border);">Role</th>
                            <th style="padding:14px 20px;font-size:0.65rem;font-family:'DM Mono',monospace;letter-spacing:0.1em;text-transform:uppercase;color:var(--slate-mid);text-align:left;border-bottom:1px solid var(--border);">Joined</th>
                            <th style="padding:14px 20px;font-size:0.65rem;font-family:'DM Mono',monospace;letter-spacing:0.1em;text-transform:uppercase;color:var(--slate-mid);text-align:right;border-bottom:1px solid var(--border);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td style="padding:14px 20px;border-bottom:1px solid var(--border);">
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg, #7C3AED, #6D28D9);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.75rem;font-weight:600;flex-shrink:0;">
                                        {{ strtoupper(substr($member->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span style="font-weight:500;color:var(--text-main);">{{ $member->user->name ?? 'Unknown' }}</span>
                                </div>
                            </td>
                            <td style="padding:14px 20px;border-bottom:1px solid var(--border);color:var(--text-muted);font-size:0.82rem;">
                                {{ $member->user->email ?? '—' }}
                            </td>
                            <td style="padding:14px 20px;border-bottom:1px solid var(--border);">
                                <span class="badge-sky">{{ ucfirst($member->pivot->role ?? 'member') }}</span>
                            </td>
                            <td style="padding:14px 20px;border-bottom:1px solid var(--border);color:var(--text-muted);font-size:0.78rem;">
                                {{ $member->pivot->joined_at ? \Carbon\Carbon::parse($member->pivot->joined_at)->format('M j, Y') : '—' }}
                            </td>
                            <td style="padding:14px 20px;border-bottom:1px solid var(--border);text-align:right;">
                                <div style="display:flex;gap:8px;justify-content:flex-end;">
                                    @if($member->user_id !== $studio->owner_id)
                                    <form action="{{ route('studios.members.destroy', [$studio, $member]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-decline" onclick="return confirm('Remove this member from the studio?')">
                                            Remove
                                        </button>
                                    </form>
                                    @else
                                    <span class="badge-secondary">Owner</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <div style="margin-top:24px;">
            <a href="{{ route('studios.show', $studio) }}" class="btn-ghost" style="display:inline-flex;align-items:center;gap:6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
                Back to Studio Dashboard
            </a>
        </div>

    </div>

</body>

</html>