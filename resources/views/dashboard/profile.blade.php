@extends('layouts.main-dashboard')

@section('title', 'CertChain - Profile')
@section('page-title', 'My Profile')
@section('page-subtitle', 'Manage your personal information and account settings')

@section('style')
    .profile-layout{display:grid;grid-template-columns:300px 1fr;gap:24px;align-items:start;}
    .profile-card{text-align:center;padding:32px 24px;}
    .profile-avatar-wrap{position:relative;display:inline-block;margin-bottom:16px;}
    .profile-avatar{
    width:96px;height:96px;border-radius:99px;
    background:linear-gradient(135deg,#2563EB,#6FA0F8);
    color:#fff;display:grid;place-items:center;
    font-weight:700;font-size:32px;margin:0 auto;
    }
    .avatar-edit-btn{
    position:absolute;bottom:2px;right:2px;
    width:28px;height:28px;border-radius:99px;
    background:var(--surface);border:2px solid var(--border);
    display:grid;place-items:center;cursor:pointer;color:var(--text-2);
    transition:all .15s;
    }
    .avatar-edit-btn:hover{background:var(--blue-50);color:var(--blue-600);border-color:var(--blue-200);}
    .profile-name{font-size:17px;font-weight:600;margin-bottom:4px;}
    .profile-email{font-size:13px;color:var(--text-3);margin-bottom:16px;}
    .profile-meta{display:flex;flex-direction:column;gap:8px;text-align:left;}
    .profile-meta-row{display:flex;align-items:center;gap:10px;padding:10px
    12px;background:var(--slate-50);border-radius:10px;font-size:13px;}
    .profile-meta-icon{color:var(--text-4);flex-shrink:0;}
    .profile-meta-label{font-size:11px;color:var(--text-4);margin-bottom:1px;}
    .profile-meta-val{font-size:13px;font-weight:500;color:var(--text-1);}
    .tab-pills{display:flex;gap:4px;padding:4px;background:var(--slate-100);border-radius:11px;margin-bottom:24px;}
    .tab-pill{
    flex:1;height:38px;border:none;background:transparent;border-radius:8px;
    font-family:var(--font);font-size:13px;font-weight:600;color:var(--text-3);
    cursor:pointer;transition:all .2s;
    }
    .tab-pill.active{background:#fff;color:var(--text-1);box-shadow:var(--shadow-sm);}
    .profile-section{display:none;}
    .profile-section.active{display:block;}
    .activity-row{
    display:flex;align-items:center;gap:14px;
    padding:14px 0;border-bottom:1px solid var(--border);
    }
    .activity-row:last-child{border-bottom:none;}
    .activity-icon{
    width:36px;height:36px;border-radius:10px;
    display:grid;place-items:center;flex-shrink:0;
    }
    .activity-time{font-size:11px;color:var(--text-4);margin-top:2px;}
    .activity-title{font-size:13px;font-weight:500;color:var(--text-1);}
    .save-bar{display:flex;justify-content:flex-end;gap:10px;padding-top:20px;border-top:1px solid
    var(--border);margin-top:24px;}
@endsection

@section('content')

    <div class="profile-layout">

        @if (session('success'))
            <div
                style="grid-column:1/-1;padding:18px;background:#ecfdf5;border:1px solid #d1fae5;color:#065f46;border-radius:14px;margin-bottom:18px;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div
                style="grid-column:1/-1;padding:18px;background:#fef2f2;border:1px solid #fee2e2;color:#991b1b;border-radius:14px;margin-bottom:18px;">
                <strong>There were some problems with your input:</strong>
                <ul style="margin:8px 0 0 18px;padding:0;list-style:disc;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- LEFT: Profile Card -->
        <div class="card profile-card">
            <div class="profile-avatar-wrap">
                <div class="profile-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <button class="avatar-edit-btn">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M17 3a2.8 2.8 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                    </svg>
                </button>
            </div>
            <div class="profile-name">{{ auth()->user()->name }}</div>
            <div class="profile-email">{{ auth()->user()->email }}</div>

            <div class="profile-meta">
                <div>
                    <div class="profile-meta-row">
                        <svg class="profile-meta-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M12 2l2 7h7l-6 4 2 7-5-4-5 4 2-7-6-4h7z" />
                        </svg>
                        <div>
                            <div class="profile-meta-label">Role</div>
                            <div class="profile-meta-val">{{ ucfirst(auth()->user()->role ?? 'Registrar') }}</div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="profile-meta-row">
                        <svg class="profile-meta-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <rect x="3" y="5" width="18" height="16" rx="2" />
                            <path d="M3 10h18M8 3v4M16 3v4" />
                        </svg>
                        <div>
                            <div class="profile-meta-label">Member since</div>
                            <div class="profile-meta-val">{{ auth()->user()->created_at->format('M Y') }}</div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="profile-meta-row">
                        <svg class="profile-meta-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z" />
                            <path d="M9 12l2 2 4-4" />
                        </svg>
                        <div>
                            <div class="profile-meta-label">Certificates issued</div>
                            <div class="profile-meta-val">{{ $certificatesCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Tabs -->
        <div>
            <div class="tab-pills">
                <button class="tab-pill active" onclick="switchProfileTab('info', this)">Personal Info</button>
                <button class="tab-pill" onclick="switchProfileTab('password', this)">Change Password</button>
                <button class="tab-pill" onclick="switchProfileTab('activity', this)">Activity Log</button>
            </div>

            <!-- Personal Info -->
            <div class="profile-section active card" id="prof-info" style="padding:28px;">
                <form method="POST" action="{{ route('dashboard.profile.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="grid-2">
                        <div class="field">
                            <label class="field-label">Full Name</label>
                            <input class="input" name="name" value="{{ auth()->user()->name }}" />
                        </div>
                        <div class="field">
                            <label class="field-label">Role</label>
                            <input class="input" value="{{ ucfirst(auth()->user()->role ?? 'Registrar') }}" readonly
                                style="background:var(--slate-50);" />
                        </div>
                    </div>
                    <div class="field">
                        <label class="field-label">Email Address</label>
                        <input class="input" value="{{ auth()->user()->email }}" type="email" readonly
                            style="background:var(--slate-50);" />
                        <p class="field-help" style="margin-top:8px;font-size:12px;color:var(--text-4);">Email cannot be
                            changed from the profile page.</p>
                    </div>
                    <div class="field">
                        <label class="field-label">Institution</label>
                        <input class="input" value="{{ auth()->user()->institution ?? '' }}" placeholder="e.g. UCAS"
                            readonly style="background:var(--slate-50);" />
                    </div>
                    <div class="save-bar">
                        <button type="reset" class="btn btn-secondary">Discard</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="profile-section card" id="prof-password" style="padding:28px;">
                <form method="POST" action="{{ route('dashboard.profile.password') }}">
                    @csrf
                    @method('PUT')
                    <div class="field">
                        <label class="field-label">Current Password</label>
                        <input class="input" name="current_password" type="password" placeholder="••••••••" />
                    </div>
                    <div class="grid-2">
                        <div class="field">
                            <label class="field-label">New Password</label>
                            <input class="input" name="password" type="password" placeholder="••••••••" />
                        </div>
                        <div class="field">
                            <label class="field-label">Confirm New Password</label>
                            <input class="input" name="password_confirmation" type="password" placeholder="••••••••" />
                        </div>
                    </div>
                    <div
                        style="padding:12px 14px;background:var(--blue-50);border-radius:10px;font-size:12px;color:var(--blue-700);margin-bottom:18px;">
                        Password must be at least 8 characters and include a mix of letters and numbers.
                    </div>
                    <div class="save-bar">
                        <button type="reset" class="btn btn-secondary">Clear</button>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>

            <!-- Activity Log -->
            <div class="profile-section card" id="prof-activity" style="padding:28px;">
                <div class="card-title" style="margin-bottom:18px;">Recent Activity</div>
                @forelse($recentActivity as $log)
                    <div class="activity-row">
                        <div class="activity-icon" style="background:var(--blue-50);color:var(--blue-600);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z" />
                                <path d="M9 12l2 2 4-4" />
                            </svg>
                        </div>
                        <div style="flex:1;">
                            <div class="activity-title">Certificate verified — {{ $log->certificate_id ?? 'N/A' }}</div>
                            <div class="activity-time">
                                {{ $log->verified_at ? $log->verified_at->diffForHumans() : 'Time not available' }}</div>
                        </div>
                        <span class="badge badge-success"><span class="badge-dot"></span>Success</span>
                    </div>
                @empty
                    <div style="text-align:center;padding:32px;color:var(--text-3);">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" style="margin:0 auto 12px;opacity:.4;display:block;">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 2" />
                        </svg>
                        No activity recorded yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    function switchProfileTab(name, el) {
    document.querySelectorAll('.tab-pill').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.profile-section').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('prof-' + name).classList.add('active');
    }
@endsection
