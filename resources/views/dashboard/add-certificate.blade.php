@extends('layouts.main-dashboard')
@section('title', 'CertChain - Add Certificate')

@section('style')
    :root{
    --blue-50:#EFF5FF;--blue-100:#DBE7FE;--blue-200:#BFD3FE;
    --blue-500:#3B7DF7;--blue-600:#2563EB;--blue-700:#1D4ED8;
    --emerald-50:#ECFDF5;--emerald-100:#D1FAE5;--emerald-300:#6EE7B7;
    --emerald-500:#10B981;--emerald-600:#059669;--emerald-700:#047857;
    --amber-50:#FFFBEB;--amber-100:#FEF3C7;--amber-500:#F59E0B;--amber-600:#D97706;
    --rose-50:#FFF1F2;--rose-500:#F43F5E;--rose-600:#E11D48;
    --slate-50:#F8FAFC;--slate-100:#F1F5F9;--slate-150:#E8EDF3;
    --slate-200:#E2E8F0;--slate-300:#CBD5E1;--slate-400:#94A3B8;
    --slate-500:#64748B;--slate-600:#475569;--slate-700:#334155;--slate-900:#0F172A;
    --bg:#F6F8FB;--surface:#FFFFFF;--border:#E6EBF2;--border-strong:#D6DEE9;
    --text-1:#0F172A;--text-2:#475569;--text-3:#64748B;--text-4:#94A3B8;
    --radius:12px;--radius-lg:16px;
    --shadow-xs:0 1px 2px rgba(15,23,42,.04);
    --shadow-sm:0 1px 3px rgba(15,23,42,.06),0 1px 2px rgba(15,23,42,.04);
    --shadow-md:0 4px 12px rgba(15,23,42,.08),0 1px 2px rgba(15,23,42,.04);
    --font:'Inter',-apple-system,sans-serif;
    --display:'Playfair Display',Georgia,serif;
    --mono:'JetBrains Mono',monospace;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:var(--font);background:var(--bg);color:var(--text-1);
    -webkit-font-smoothing:antialiased;letter-spacing:-.005em;height:100vh;overflow:hidden;display:flex;}
    ::-webkit-scrollbar{width:4px;} ::-webkit-scrollbar-thumb{background:var(--slate-200);border-radius:4px;}

    /* ── SIDEBAR (shared) ── */
    .sidebar{width:248px;flex-shrink:0;background:var(--surface);border-right:1px solid
    var(--border);display:flex;flex-direction:column;padding:24px 16px;}
    .sidebar-brand{display:flex;align-items:center;gap:9px;padding:4px 10px 24px;text-decoration:none;}
    .sidebar-brand-name{font-weight:700;font-size:16px;color:var(--text-1);letter-spacing:-.02em;}
    .sidebar-section-label{font-size:11px;font-weight:600;color:var(--text-4);letter-spacing:.06em;padding:8px 10px
    6px;text-transform:uppercase;}
    .nav-item{display:flex;align-items:center;gap:12px;padding:10px
    12px;border-radius:10px;color:var(--text-2);font-weight:500;font-size:14px;cursor:pointer;text-decoration:none;transition:all
    .15s;border:none;background:transparent;width:100%;text-align:left;}
    .nav-item:hover{background:var(--slate-100);color:var(--text-1);}
    .nav-item.active{background:var(--blue-50);color:var(--blue-700);font-weight:600;}
    .nav-item .badge-new{margin-left:auto;height:18px;padding:0
    6px;background:var(--blue-50);color:var(--blue-700);border-radius:99px;font-size:10px;font-weight:600;display:flex;align-items:center;}
    .sidebar-footer{margin-top:auto;padding:14px;background:linear-gradient(180deg,#EFF5FF,#FFFFFF);border:1px solid
    var(--blue-100);border-radius:14px;}
    .sf-head{display:flex;align-items:center;gap:8px;margin-bottom:8px;}
    .sf-icon{width:28px;height:28px;border-radius:8px;background:var(--blue-600);display:grid;place-items:center;color:#fff;flex-shrink:0;}
    .sf-title{font-weight:600;font-size:13px;}
    .sf-row{display:flex;justify-content:space-between;font-size:12px;color:var(--text-2);margin-bottom:4px;}
    .sf-online{display:flex;align-items:center;gap:4px;color:var(--emerald-600);}
    .sf-dot{width:6px;height:6px;border-radius:99px;background:currentColor;}
    .sf-block{font-size:11px;color:var(--text-3);}

    /* ── MAIN ── */
    .main{flex:1;display:flex;flex-direction:column;overflow:hidden;}
    .topbar{display:flex;align-items:center;gap:16px;padding:20px 32px;border-bottom:1px solid
    var(--border);background:var(--surface);flex-shrink:0;}
    .topbar-title{font-size:20px;font-weight:600;letter-spacing:-.02em;}
    .topbar-sub{font-size:13px;color:var(--text-3);margin-top:2px;}
    .topbar-user{display:flex;align-items:center;gap:10px;padding-left:12px;border-left:1px solid
    var(--border);margin-left:auto;}
    .user-avatar{width:36px;height:36px;border-radius:99px;background:linear-gradient(135deg,#2563EB,#6FA0F8);color:#fff;display:grid;place-items:center;font-weight:600;font-size:13px;flex-shrink:0;}
    .user-name{font-size:13px;font-weight:600;line-height:1.2;}
    .user-role{font-size:11px;color:var(--text-3);}

    .content{flex:1;overflow-y:auto;padding:24px 32px 40px;}

    /* BUTTONS */
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;height:38px;padding:0
    14px;border-radius:var(--radius);font-family:var(--font);font-size:13.5px;font-weight:600;border:none;cursor:pointer;text-decoration:none;transition:all
    .15s;letter-spacing:-.01em;white-space:nowrap;}
    .btn-sm{height:32px;padding:0 12px;font-size:12.5px;border-radius:8px;}
    .btn-block{width:100%;}
    .btn-primary{background:var(--blue-600);color:#fff;box-shadow:0 1px 0 rgba(255,255,255,.12) inset,0 2px 4px
    rgba(37,99,235,.2);}
    .btn-primary:hover{background:var(--blue-700);}
    .btn-secondary{background:var(--surface);color:var(--text-1);border:1px solid
    var(--border-strong);box-shadow:var(--shadow-xs);}
    .btn-secondary:hover{background:var(--slate-50);}
    .btn-success{background:var(--emerald-600);color:#fff;}
    .btn-success:hover{background:var(--emerald-700);}

    /* CARD */
    .card{background:var(--surface);border:1px solid
    var(--border);border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);}

    /* STEPPER */
    .stepper{display:flex;align-items:center;gap:0;padding:18px 28px;}
    .step-node{display:flex;align-items:center;gap:10px;}
    .step-circle{width:28px;height:28px;border-radius:99px;display:grid;place-items:center;font-size:12px;font-weight:600;flex-shrink:0;}
    .step-circle.done{background:var(--emerald-500);color:#fff;}
    .step-circle.active{background:var(--blue-600);color:#fff;}
    .step-circle.idle{background:var(--slate-100);color:var(--text-3);}
    .step-label{font-size:13px;font-weight:600;}
    .step-label.active{color:var(--text-1);}
    .step-label.idle{color:var(--text-3);font-weight:500;}
    .step-bar{flex:1;height:2px;border-radius:99px;margin:0 18px;}
    .step-bar.done{background:var(--emerald-300);}
    .step-bar.idle{background:var(--slate-150);}

    /* FORM */
    .two-col{display:grid;grid-template-columns:1.6fr 1fr;gap:20px;margin-top:20px;}
    .field{display:flex;flex-direction:column;gap:6px;margin-bottom:16px;}
    .field-label{font-size:13px;font-weight:500;color:var(--text-2);}
    .field-hint{font-size:12px;color:var(--text-3);}
    .input-wrap{position:relative;}
    .input-icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--text-4);pointer-events:none;}
    .input,.select{width:100%;height:42px;padding:0 14px;background:var(--surface);border:1.5px solid
    var(--border-strong);border-radius:var(--radius);font-family:var(--font);font-size:14px;color:var(--text-1);outline:none;transition:all
    .15s;-webkit-appearance:none;}
    .input.icon-pad{padding-left:40px;}
    .input::placeholder{color:var(--text-4);}
    .input:focus,.select:focus{border-color:var(--blue-500);box-shadow:0 0 0 4px rgba(59,125,247,.1);}
    .input.error{border-color:var(--rose-500);}
    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .grid-3{display:grid;grid-template-columns:2fr 1fr 1fr;gap:16px;}

    /* UPLOAD */
    .upload-zone{border:1.5px dashed
    var(--border-strong);border-radius:12px;padding:24px;text-align:center;background:var(--slate-50);display:flex;flex-direction:column;align-items:center;gap:10px;cursor:pointer;transition:all
    .2s;margin-bottom:10px;}
    .upload-zone:hover{border-color:var(--blue-300);background:var(--blue-50);}
    .upload-icon{width:44px;height:44px;border-radius:10px;background:var(--blue-50);color:var(--blue-600);display:grid;place-items:center;}
    .file-row{display:flex;align-items:center;gap:12px;padding:10px
    14px;background:var(--blue-50);border-radius:10px;border:1px solid var(--blue-100);display:none;}
    .file-icon{width:32px;height:32px;border-radius:8px;background:#fff;color:var(--blue-600);display:grid;place-items:center;flex-shrink:0;}

    /* HASH BOX */
    .hash-box{background:var(--slate-900);border-radius:10px;padding:12px
    14px;font-family:var(--mono);font-size:12px;color:#A5C0F2;word-break:break-all;display:flex;align-items:center;gap:8px;margin-bottom:12px;}
    .copy-btn{background:rgba(255,255,255,.08);border:none;color:#CBD5E1;border-radius:6px;padding:6px;cursor:pointer;flex-shrink:0;display:flex;transition:background
    .15s;}
    .copy-btn:hover{background:rgba(255,255,255,.15);}

    /* BLOCKCHAIN STATUS */
    .bc-step{display:flex;align-items:center;gap:12px;margin-bottom:14px;}
    .bc-circle{width:24px;height:24px;border-radius:99px;display:grid;place-items:center;flex-shrink:0;}
    .bc-circle.done{background:var(--emerald-500);color:#fff;}
    .bc-circle.pending{background:var(--amber-100);}
    .bc-circle.idle{background:var(--slate-100);}
    .bc-dot-amber{width:8px;height:8px;border-radius:99px;background:var(--amber-500);}
    .bc-dot-slate{width:8px;height:8px;border-radius:99px;background:var(--slate-300);}
    .bc-label{font-size:13px;font-weight:600;}
    .bc-sub{font-size:11px;color:var(--text-3);}
    .badge{display:inline-flex;align-items:center;gap:5px;height:24px;padding:0
    10px;border-radius:99px;font-size:12px;font-weight:500;}
    .badge-warning{background:var(--amber-50);color:var(--amber-600);}
    .badge-dot{width:6px;height:6px;border-radius:99px;background:currentColor;}

    /* TOAST */
    .toast{
    position:fixed;bottom:28px;right:28px;z-index:999;
    background:var(--slate-900);color:#fff;padding:12px 18px;border-radius:12px;
    font-size:13px;font-weight:500;display:flex;align-items:center;gap:10px;
    box-shadow:0 8px 24px rgba(15,23,42,.25);
    transform:translateY(80px);opacity:0;transition:all .3s ease;
    }
    .toast.show{transform:translateY(0);opacity:1;}

    /* SPINNER */
    .btn .spinner{width:14px;height:14px;border:2px solid
    rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite;display:none;}
    @keyframes spin{to{transform:rotate(360deg)}}
    .btn.loading .spinner{display:block;}
    .btn.loading .btn-label{display:none;}
@endsection

@section('content')
    @if ($errors->any())
        <div class="card" style="padding:16px;margin-bottom:18px;background:#FEF2F2;border-color:#FCA5A5;color:#991B1B;">
            <div style="font-weight:700;margin-bottom:8px;">Issue failed</div>
            <ul style="margin-left:18px;line-height:1.7;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="card" style="padding:16px;margin-bottom:18px;background:#ECFDF5;border-color:#6EE7B7;color:#065F46;">
            {{ session('success') }}
        </div>
    @endif
    <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--text-3);margin-bottom:20px;">
        <a href="{{ route('dashboard.index') }}" style="cursor:pointer;text-decoration:none;color:inherit;">Certificates</a>
        <span>/</span>
        <span style="color:var(--text-1);font-weight:500;">New</span>
    </div>

    <!-- STEPPER -->
    <div class="card stepper" style="margin-bottom:20px;">
        <div class="step-node">
            <div class="step-circle done" id="sc-1">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3">
                    <path d="M20 6 9 17l-5-5" />
                </svg>
            </div>
            <span class="step-label active" id="sl-1">Student details</span>
        </div>
        <div class="step-bar done" id="sb-1"></div>
        <div class="step-node">
            <div class="step-circle active" id="sc-2">2</div>
            <span class="step-label active" id="sl-2">Review proof record</span>
        </div>
        <div class="step-bar idle" id="sb-2"></div>
        <div class="step-node">
            <div class="step-circle idle" id="sc-3">3</div>
            <span class="step-label idle" id="sl-3">Issue certificate</span>
        </div>
    </div>

    <!-- TWO COLUMNS -->
    <form method="POST" action="{{ route('dashboard.certificates.store-and-submit') }}" enctype="multipart/form-data" class="two-col">
        @csrf
        <input type="hidden" id="keccak256_hash" name="keccak256_hash">

        <!-- LEFT: FORM -->
        <div class="card" style="padding:28px;">
            <div style="font-size:15px;font-weight:600;margin-bottom:4px;">Student & credential details</div>
            <div style="font-size:13px;color:var(--text-3);margin-bottom:24px;">All fields are required. The official record keeps certificate details readable for review while technical proof stays in Proof details.</div>

            <div class="grid-2">
                <div class="field">
                    <label class="field-label">Student name</label>
                    <input class="input" id="f-name" name="student_name" placeholder="Full name" />
                </div>
                <div class="field">
                    <label class="field-label">Student ID</label>
                    <input class="input" id="f-sid" name="student_id" placeholder="e.g. UCAS-2026-04812" />
                </div>
            </div>

            <div class="field">
                <label class="field-label">University</label>
                <div class="input-wrap">
                    <span class="input-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <rect x="4" y="3" width="16" height="18" rx="1" />
                            <path d="M9 8h.01M14 8h.01M9 12h.01M14 12h.01M9 16h.01M14 16h.01" />
                        </svg></span>
                    <select class="select" style="padding-left:40px;" id="f-uni" name="university">
                        <option>University College of Applied Sciences (UCAS)</option>
                        <option>Birzeit University</option>
                        <option>An-Najah National University</option>
                        <option>Islamic University of Gaza</option>
                        <option>Al-Azhar University – Gaza</option>
                        <option>Palestine Polytechnic University</option>
                        <option>Arab American University</option>
                    </select>
                </div>
            </div>

            <div class="grid-3">
                <div class="field">
                    <label class="field-label">Degree</label>
                    <input class="input" id="f-degree" name="degree" placeholder="e.g. B.Sc. Computer Science" />
                </div>
                {{-- <div class="field">
            <label class="field-label">GPA</label>
            <input class="input" id="f-gpa" placeholder="3.00" value="3.87"/>
          </div> --}}
                <div class="field">
                    <label class="field-label">Graduation</label>
                    <div class="input-wrap">
                        <span class="input-icon"><svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <rect x="3" y="5" width="18" height="16" rx="2" />
                                <path d="M3 10h18M8 3v4M16 3v4" />
                            </svg></span>
                        <input class="input icon-pad" id="f-date" name="graduation_date" type="date" />
                    </div>
                </div>
            </div>

            <!-- UPLOAD -->
            <div class="field">
                <label class="field-label">Certificate document (PDF)</label>
                <div class="upload-zone" onclick="document.getElementById('pdf-input').click()">
                    <input type="file" id="pdf-input" name="certificate_pdf" accept=".pdf" style="display:none" onchange="handlePdf(this)" required />
                    <div class="upload-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <path d="M17 8l-5-5-5 5" />
                            <path d="M12 3v12" />
                        </svg>
                    </div>
                    <div>
                        <span style="font-weight:600;color:var(--blue-600);">Click to upload</span>
                        <span style="color:var(--text-2);"> or drag & drop</span>
                        <div style="font-size:12px;color:var(--text-3);margin-top:4px;">PDF up to 10 MB · signed by
                            registrar</div>
                    </div>
                </div>
                <div class="file-row" id="file-row">
                    <div class="file-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z" />
                            <path d="M14 3v6h6" />
                        </svg></div>
                    <div style="flex:1;">
                        <div id="file-name" style="font-size:13px;font-weight:600;"></div>
                        <div id="file-size" style="font-size:11px;color:var(--text-3);"></div>
                    </div>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--emerald-600)"
                        stroke-width="2.5">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- RIGHT: HASH + SUBMIT -->
        <div style="display:flex;flex-direction:column;gap:16px;">

            <!-- Proof record card -->
            <div class="card" style="padding:24px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <div
                        style="width:36px;height:36px;border-radius:9px;background:var(--blue-50);color:var(--blue-600);display:grid;place-items:center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M4 9h16M4 15h16M10 3 8 21M16 3l-2 18" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:600;">Proof record</div>
                        <div style="font-size:12px;color:var(--text-3);">Prepared from the certificate details and document.</div>
                    </div>
                </div>
                <div
                    style="font-size:11px;color:var(--text-3);margin-top:10px;padding:10px;background:var(--blue-50);border-radius:8px;line-height:1.5;">
                    Review the student identity, credential details, and attached PDF before issuing. Technical proof is generated again on the server and then stored on-chain.
                </div>
                <details class="proof-details" style="margin-top:12px;">
                    <summary>Proof details</summary>
                    <div class="proof-body">
                        <div class="proof-row">
                            <div class="proof-label">Fingerprint method</div>
                            <div class="proof-value" id="hash-algorithm">Keccak-256</div>
                        </div>
                        <div class="hash-box" style="margin-bottom:0;">
                            <span id="hash-display" style="flex:1;">0x8a3f7b21c4d9e02f1a6c8b5d4e9f3a72c1b8e6d5</span>
                            <button class="copy-btn" type="button" onclick="copyHash()" aria-label="Copy proof fingerprint">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <rect x="8" y="8" width="13" height="13" rx="2" />
                                    <path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3" />
                                </svg>
                            </button>
                        </div>
                        <button type="button" class="btn btn-secondary btn-block btn-sm" onclick="regenerateHash()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M3 12a9 9 0 0 1 15-6.7L21 8" />
                                <path d="M21 3v5h-5" />
                                <path d="M21 12a9 9 0 0 1-15 6.7L3 16" />
                                <path d="M3 21v-5h5" />
                            </svg>
                            Regenerate proof fingerprint
                        </button>
                    </div>
                </details>
            </div>

            <!-- QR code card -->
            <div class="card" id="qr-code-card" style="padding:24px;display:none;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <div
                        style="width:36px;height:36px;border-radius:9px;background:var(--blue-50);color:var(--blue-600);display:grid;place-items:center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M5 3h4v4H5V3Zm6 0h4v4h-4V3Zm6 0h4v4h-4V3ZM5 13h4v4H5v-4Zm6 0h4v4h-4v-4Zm6 0h4v4h-4v-4Z" />
                        </svg>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:600;">QR Code</div>
                        <div style="font-size:12px;color:var(--text-3);">Scan to verify this certificate instantly.</div>
                    </div>
                </div>
                <div
                    style="display:flex;align-items:center;justify-content:center;padding:10px;background:var(--slate-50);border-radius:14px;">
                    <img id="qr-code-img" src="" alt="QR code"
                        style="max-width:100%;height:auto;display:block;" />
                </div>
                <div
                    style="font-size:11px;color:var(--text-3);margin-top:10px;padding:10px;background:var(--blue-50);border-radius:8px;line-height:1.5;">
                    The QR opens the verification page for this prepared proof record.
                </div>
            </div>

            <!-- Issuance status card -->
            <div class="card" style="padding:24px;">
                <div style="font-size:14px;font-weight:600;margin-bottom:14px;">Issuance status</div>

                <div class="bc-step">
                    <div class="bc-circle done"><svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                            stroke="white" stroke-width="3">
                            <path d="M20 6 9 17l-5-5" />
                        </svg></div>
                    <div style="flex:1;">
                        <div class="bc-label">Draft details</div>
                        <div class="bc-sub">Student and credential data entered</div>
                    </div>
                </div>
                <div class="bc-step">
                    <div class="bc-circle pending">
                        <div class="bc-dot-amber"></div>
                    </div>
                    <div style="flex:1;">
                        <div class="bc-label">Proof record prepared</div>
                        <div class="bc-sub">Ready for registrar review</div>
                    </div>
                    <span class="badge badge-warning"><span class="badge-dot"></span>Review</span>
                </div>
                <div class="bc-step" style="margin-bottom:18px;">
                    <div class="bc-circle idle">
                        <div class="bc-dot-slate"></div>
                    </div>
                    <div style="flex:1;">
                        <div class="bc-label">Certificate issued</div>
                        <div class="bc-sub">Official record created</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block" id="submit-btn">
                    <div class="spinner"></div>
                    <span class="btn-label" style="display:flex;align-items:center;gap:7px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="3" y="4" width="18" height="14" rx="2" />
                            <path d="M7 9h10M7 13h6" />
                            <circle cx="17" cy="18" r="2.5" />
                        </svg>
                        Issue certificate
                    </span>
                </button>
                <div style="font-size:11px;color:var(--text-3);text-align:center;margin-top:10px;">
                    On submit, the backend sends the Certificate ID and Keccak-256 fingerprint to the Ethereum smart contract.
                </div>
            </div>

        </div>
    </form>

    <!-- TOAST -->
    <div class="toast" id="toast">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2.5">
            <path d="M20 6 9 17l-5-5" />
        </svg>
        <span id="toast-msg">Proof fingerprint copied!</span>
    </div>

@endsection

@section('scripts')
    (function() {
    const nameInput = document.getElementById('f-name');
    const sidInput = document.getElementById('f-sid');
    const uniSelect = document.getElementById('f-uni');
    const degreeInput = document.getElementById('f-degree');
    const dateInput = document.getElementById('f-date');
    const pdfInput = document.getElementById('pdf-input');
    const hashDisplay = document.getElementById('hash-display');
    const hashInput = document.getElementById('keccak256_hash');
    const hashAlgorithm = document.getElementById('hash-algorithm');
    const fileRow = document.getElementById('file-row');
    const fileNameEl = document.getElementById('file-name');
    const fileSizeEl = document.getElementById('file-size');
    const qrCard = document.getElementById('qr-code-card');
    const qrCodeImage = document.getElementById('qr-code-img');
    const toastEl = document.getElementById('toast');
    const toastMsg = document.getElementById('toast-msg');
    const qrRoute = @json(route('dashboard.qr-code'));
    const verifyRoute = @json(route('dashboard.verify'));
    let debounceTimer = null;

    function debounce(fn, delay = 300) {
    return function(...args) {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => fn(...args), delay);
    };
    }

    function formatBytes(bytes) {
    if (!bytes) return '0 B';
    const units = ['B','KB','MB','GB'];
    let value = bytes;
    let i = 0;
    while (value >= 1024 && i < units.length - 1) { value /=1024; i++; } return `${value.toFixed(1)} ${units[i]}`; }
        function showToast(message) { toastMsg.textContent=message; toastEl.classList.add('show'); setTimeout(()=>
        toastEl.classList.remove('show'), 2200);
        }

        function readFileAsBase64(file) {
        return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result.split(',')[1] || '');
        reader.onerror = () => reject(new Error('Failed to read file'));
        reader.readAsDataURL(file);
        });
        }

        async function buildHashPayload() {
        const file = pdfInput.files[0];
        let fileContents = '';
        if (file) {
        try {
        fileContents = await readFileAsBase64(file);
        } catch (e) {
        fileContents = '';
        }
        }

        return {
        student_name: nameInput.value.trim(),
        student_id: sidInput.value.trim(),
        university: uniSelect.value || '',
        degree: degreeInput.value.trim(),
        graduation_date: dateInput.value || '',
        file_name: file ? file.name : '',
        file_size: file ? file.size : 0,
        file_contents: fileContents,
        };
        }

        async function sha256Hex(value) {
        if (!window.crypto || !window.crypto.subtle) {
        throw new Error('No browser hashing API available');
        }

        const bytes = new TextEncoder().encode(value);
        const digest = await window.crypto.subtle.digest('SHA-256', bytes);
        return '0x' + Array.from(new Uint8Array(digest))
        .map(byte => byte.toString(16).padStart(2, '0'))
        .join('');
        }

        async function generateCertificateHash(payloadStr) {
        if (window.Web3?.utils?.keccak256) {
        hashAlgorithm.textContent = 'Keccak-256';
        return window.Web3.utils.keccak256(payloadStr);
        }

        if (window.web3?.utils?.keccak256) {
        hashAlgorithm.textContent = 'Keccak-256';
        return window.web3.utils.keccak256(payloadStr);
        }

        hashAlgorithm.textContent = 'SHA-256 fallback';
        return sha256Hex(payloadStr);
        }
        async function updateHash() {
        try {
        const payload = await buildHashPayload();
        hashDisplay.textContent = 'Generating...';

        const payloadStr = JSON.stringify(payload);
        const hash = await generateCertificateHash(payloadStr);
        hashDisplay.textContent = hash;
        if (hashInput) {
            hashInput.value = hash;
        }
        updateQrForHash(hash);
        } catch (error) {
        console.error('Hash generation error:', error);
        hashDisplay.textContent = 'Error generating hash';
        hideQr();
        }
        }

        function showQr(url) {
        if (!qrCodeImage || !qrCard) {
        return;
        }

        qrCodeImage.src = qrRoute + '?text=' + encodeURIComponent(url) + '&size=250';
        qrCodeImage.alt = 'QR code for verify link';
        qrCard.style.display = 'block';
        }

        function hideQr() {
        if (!qrCodeImage || !qrCard) {
        return;
        }

        qrCodeImage.src = '';
        qrCard.style.display = 'none';
        }

        function updateQrForHash(hash) {
        if (!hash || !hash.startsWith('0x') || hash === 'Generating...' || hash === 'Error generating hash') {
        hideQr();
        return;
        }

        const verifyUrl = verifyRoute + '?hash=' + encodeURIComponent(hash);
        showQr(verifyUrl);
        }

        function updateFileInfo(file) {
        if (!file) {
        fileRow.style.display = 'none';
        fileNameEl.textContent = '';
        fileSizeEl.textContent = '';
        return;
        }

        fileRow.style.display = 'flex';
        fileNameEl.textContent = file.name;
        fileSizeEl.textContent = formatBytes(file.size);
        }

        window.handlePdf = function(input) {
        const file = input.files[0];
        updateFileInfo(file);
        updateHash();
        };

        window.copyHash = async function() {
        const hashText = hashDisplay.textContent || '';
        if (!hashText.startsWith('0x')) {
        showToast('No proof fingerprint to copy');
        return;
        }
        try {
        await navigator.clipboard.writeText(hashText);
        showToast('Proof fingerprint copied');
        } catch (err) {
        showToast('Copy failed');
        }
        };

        window.regenerateHash = function() {
        updateHash();
        showToast('Proof fingerprint regenerated');
        };

        window.submitToChain = function() {
        const btn = document.getElementById('submit-btn');
        btn.classList.add('loading');
        setTimeout(() => {
        btn.classList.remove('loading');
        showToast('Certificate issued');
        }, 2000);
        };

        document.addEventListener('DOMContentLoaded', () => {
        const inputs = [nameInput, sidInput, uniSelect, degreeInput, dateInput];
        const throttledUpdate = debounce(updateHash, 250);

        inputs.forEach(el => el.addEventListener('input', throttledUpdate));
        uniSelect.addEventListener('change', throttledUpdate);
        pdfInput.addEventListener('change', () => {
        updateFileInfo(pdfInput.files[0]);
        updateHash();
        });

        updateHash();
        });
        })();
    @endsection
