<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CertChain — Sign In</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
  <style>
    /* ── Design Tokens ── */
    :root {
      --blue-50:  #EFF5FF;
      --blue-100: #DBE7FE;
      --blue-200: #BFD3FE;
      --blue-500: #3B7DF7;
      --blue-600: #2563EB;
      --blue-700: #1D4ED8;
      --blue-800: #1e40af;

      --amber-500: orange;
      --emerald-50:  #ECFDF5;
      --emerald-100: #D1FAE5;
      --emerald-500: #10B981;
      --emerald-600: #059669;

      --rose-50:  #FFF1F2;
      --rose-500: #F43F5E;
      --rose-600: #E11D48;

      --slate-50:  #F8FAFC;
      --slate-100: #F1F5F9;
      --slate-200: #E2E8F0;
      --slate-300: #CBD5E1;
      --slate-400: #94A3B8;
      --slate-500: #64748B;
      --slate-600: #475569;
      --slate-700: #334155;
      --slate-800: #1E293B;
      --slate-900: #0F172A;

      --bg: #F6F8FB;
      --surface: #FFFFFF;
      --border: #E6EBF2;
      --border-strong: #D6DEE9;

      --text-1: #0F172A;
      --text-2: #475569;
      --text-3: #64748B;
      --text-4: #94A3B8;

      --radius: 12px;
      --radius-lg: 16px;
      --shadow-sm: 0 1px 3px rgba(15,23,42,0.06), 0 1px 2px rgba(15,23,42,0.04);
      --shadow-md: 0 4px 12px rgba(15,23,42,0.08), 0 1px 2px rgba(15,23,42,0.04);
      --shadow-lg: 0 12px 32px rgba(15,23,42,0.10), 0 2px 6px rgba(15,23,42,0.04);

      --font: 'Inter', -apple-system, sans-serif;
      --display: 'Playfair Display', Georgia, serif;
      --mono: 'JetBrains Mono', monospace;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: var(--font);
      background: var(--bg);
      color: var(--text-1);
      height: 100vh;
      overflow: hidden;
      -webkit-font-smoothing: antialiased;
    }

    /* ── Layout ── */
    .layout {
      display: flex;
      height: 100vh;
    }

    /* ── Left Panel ── */
    .left-panel {
      width: 52%;
      position: relative;
      background: linear-gradient(145deg, #1D4ED8 0%, #2563EB 45%, #3B7DF7 100%);
      color: #fff;
      display: flex;
      flex-direction: column;
      padding: 36px 48px;
      overflow: hidden;
    }

    /* Grid pattern */
    .left-panel::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,0.08) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.08) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
    }

    /* Glow blobs */
    .glow-top {
      position: absolute;
      top: -120px; right: -80px;
      width: 380px; height: 380px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(167,200,255,0.35), transparent 70%);
      pointer-events: none;
    }
    .glow-bottom {
      position: absolute;
      bottom: -120px; left: -60px;
      width: 320px; height: 320px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(99,179,237,0.2), transparent 70%);
      pointer-events: none;
    }

    /* Logo */
    .brand {
      position: relative;
      display: flex;
      align-items: center;
      gap: 10px;
      z-index: 1;
    }
    .brand-icon {
      width: 34px; height: 34px;
      border-radius: 9px;
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(10px);
      display: grid; place-items: center;
      border: 1px solid rgba(255,255,255,0.2);
    }
    .brand-name {
      font-weight: 700;
      font-size: 17px;
      letter-spacing: -0.02em;
    }

    /* Certificate illustration */
    .cert-illustration {
      position: relative;
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1;
      margin: 20px -20px;
    }
    .cert-wrapper {
      position: relative;
      width: 400px;
      height: 300px;
    }
    .cert-back {
      position: absolute;
      top: 30px; left: 35px;
      width: 300px; height: 200px;
      border-radius: 16px;
      background: rgba(255,255,255,0.09);
      border: 1px solid rgba(255,255,255,0.2);
      backdrop-filter: blur(6px);
      transform: rotate(-7deg);
    }
    .cert-mid {
      position: absolute;
      top: 42px; left: 52px;
      width: 300px; height: 200px;
      border-radius: 16px;
      background: rgba(255,255,255,0.14);
      border: 1px solid rgba(255,255,255,0.25);
      transform: rotate(-2deg);
    }
    .cert-main {
      position: absolute;
      top: 54px; left: 68px;
      width: 300px; height: 200px;
      border-radius: 14px;
      background: rgba(255,255,255,0.97);
      color: var(--text-1);
      padding: 20px;
      box-shadow: 0 24px 48px rgba(0,0,0,0.25), 0 8px 16px rgba(0,0,0,0.12);
      transform: rotate(2deg);
      animation: float 4s ease-in-out infinite;
    }
    @keyframes float {
      0%,100% { transform: rotate(2deg) translateY(0); }
      50%      { transform: rotate(2deg) translateY(-8px); }
    }
    .cert-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
    }
    .cert-label {
      font-size: 9px;
      font-weight: 700;
      letter-spacing: 0.12em;
      color: var(--text-4);
      text-transform: uppercase;
    }
    .cert-verified {
      display: flex;
      align-items: center;
      gap: 4px;
      font-size: 10px;
      font-weight: 600;
      color: var(--emerald-600);
    }
    .cert-dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--emerald-500);
    }
    .cert-name {
      font-family: var(--display);
      font-size: 15px;
      font-weight: 600;
      margin-bottom: 3px;
    }
    .cert-degree {
      font-size: 11px;
      color: var(--text-3);
      margin-bottom: 12px;
    }
    .cert-divider {
      height: 1px;
      background: var(--border);
      margin-bottom: 10px;
    }
    .cert-hash {
      font-family: var(--mono);
      font-size: 8.5px;
      color: var(--text-3);
      line-height: 1.6;
      word-break: break-all;
    }
    .cert-footer {
      position: absolute;
      bottom: 14px; right: 14px;
      display: flex;
      align-items: center;
      gap: 4px;
      font-size: 9px;
      font-weight: 600;
      color: var(--emerald-600);
    }

    /* Block pills */
    .blocks {
      position: absolute;
      bottom: -14px; left: 60px;
      display: flex;
      gap: 6px;
      z-index: 1;
    }
    .block-pill {
      width: 48px; height: 42px;
      border-radius: 8px;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.22);
      display: grid; place-items: center;
      font-family: var(--mono);
      font-size: 8px;
      color: rgba(255,255,255,0.65);
      backdrop-filter: blur(4px);
      transition: background 0.3s;
    }
    .block-pill.active {
      background: rgba(16,185,129,0.35);
      border-color: rgba(16,185,129,0.5);
      color: #6ee7b7;
    }

    /* Stats row */
    .stats-row {
      position: relative;
      display: flex;
      gap: 28px;
      font-size: 12px;
      margin-bottom: 6px;
      z-index: 1;
    }
    .stat-item {}
    .stat-val {
      font-family: var(--display);
      font-size: 22px;
      font-weight: 700;
      line-height: 1;
      margin-bottom: 3px;
    }
    .stat-label { opacity: 0.7; }

    /* Hero copy */
    .hero-copy {
      position: relative;
      z-index: 1;
      margin-bottom: 24px;
    }
    .hero-heading {
      font-family: var(--display);
      font-size: 26px;
      font-weight: 700;
      letter-spacing: -0.01em;
      line-height: 1.25;
      margin-bottom: 10px;
    }
    .hero-sub {
      font-size: 14px;
      color: rgba(255,255,255,0.78);
      line-height: 1.6;
      max-width: 380px;
    }

    /* Trust pills */
    .trust-pills {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      margin-top: 16px;
    }
    .trust-pill {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 6px 12px;
      background: rgba(255,255,255,0.12);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 99px;
      font-size: 12px;
      font-weight: 500;
      backdrop-filter: blur(4px);
    }

    /* ── Right Panel ── */
    .right-panel {
      flex: 1;
      background: var(--surface);
      display: flex;
      flex-direction: column;
      padding: 32px 48px;
      overflow-y: auto;
    }

    .form-area {
      flex: 1;
      display: flex;
      align-items: center;
    }
    .form-inner {
      width: 100%;
      max-width: 400px;
      margin: 0 auto;
    }

    /* Tab toggle */
    .tab-row {
      display: flex;
      gap: 4px;
      padding: 4px;
      background: var(--slate-100);
      border-radius: 11px;
      margin-bottom: 28px;
    }
    .tab-btn {
      flex: 1;
      height: 38px;
      border: none;
      background: transparent;
      border-radius: 8px;
      font-family: var(--font);
      font-size: 13.5px;
      font-weight: 600;
      color: var(--text-3);
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .tab-btn.active {
      background: #fff;
      color: var(--text-1);
      box-shadow: var(--shadow-sm);
    }

    .form-heading {
      font-family: var(--display);
      font-size: 28px;
      font-weight: 700;
      letter-spacing: -0.02em;
      margin-bottom: 6px;
    }
    .form-sub {
      font-size: 14px;
      color: var(--text-3);
      margin-bottom: 26px;
      line-height: 1.5;
    }

    /* Fields */
    .field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
    .field-row { display: flex; justify-content: space-between; align-items: center; }
    .field-label {
      font-size: 13px;
      font-weight: 500;
      color: var(--text-2);
    }
    .forgot-link {
      font-size: 12px;
      color: var(--blue-600);
      font-weight: 500;
      cursor: pointer;
      text-decoration: none;
    }
    .forgot-link:hover { text-decoration: underline; }

    .input-wrap { position: relative; }
    .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-4);
      pointer-events: none;
      display: flex;
    }
    .input-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--text-4);
      cursor: pointer;
      display: flex;
      padding: 4px;
      border-radius: 6px;
      transition: color 0.15s;
    }
    .input-toggle:hover { color: var(--text-2); }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      height: 44px;
      padding: 0 14px 0 42px;
      background: var(--surface);
      border: 1.5px solid var(--border-strong);
      border-radius: var(--radius);
      font-family: var(--font);
      font-size: 14px;
      color: var(--text-1);
      outline: none;
      transition: border-color 0.15s, box-shadow 0.15s;
      -webkit-appearance: none;
    }
    input[type="text"]::placeholder,
    input[type="email"]::placeholder,
    input[type="password"]::placeholder { color: var(--text-4); }
    input:focus {
      border-color: var(--blue-500);
      box-shadow: 0 0 0 4px rgba(59,125,247,0.12);
    }
    input.error {
      border-color: var(--rose-500);
      box-shadow: 0 0 0 4px rgba(244,63,94,0.1);
    }
    .error-msg {
      font-size: 12px;
      color: var(--rose-600);
      display: none;
      margin-top: 4px;
    }
    .error-msg.show { display: block; }

    /* Password with toggle */
    input.has-toggle { padding-right: 44px; }

    /* Remember me */
    .remember-row {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: var(--text-2);
      cursor: pointer;
      margin-bottom: 20px;
    }
    .remember-row input[type="checkbox"] {
      width: 16px;
      height: 16px;
      accent-color: var(--blue-600);
      cursor: pointer;
      padding: 0;
      border-radius: 4px;
    }

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      height: 44px;
      padding: 0 18px;
      border-radius: var(--radius);
      font-family: var(--font);
      font-size: 14.5px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.18s ease;
      letter-spacing: -0.01em;
    }
    .btn-block { width: 100%; }
    .btn-primary {
      background: var(--blue-600);
      color: #fff;
      box-shadow: 0 1px 0 rgba(255,255,255,0.15) inset, 0 2px 6px rgba(37,99,235,0.3);
    }
    .btn-primary:hover { background: var(--blue-700); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.35); }
    .btn-primary:active { transform: translateY(0); }
    .btn-secondary {
      background: var(--surface);
      color: var(--text-1);
      border: 1.5px solid var(--border-strong);
      box-shadow: 0 1px 2px rgba(15,23,42,0.04);
    }
    .btn-secondary:hover { background: var(--slate-50); }

    /* Loading spinner on button */
    .btn .spinner {
      width: 16px; height: 16px;
      border: 2px solid rgba(255,255,255,0.4);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.6s linear infinite;
      display: none;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .btn.loading .spinner { display: block; }
    .btn.loading .btn-text { display: none; }

    /* Divider */
    .divider {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 11px;
      font-weight: 600;
      color: var(--text-4);
      letter-spacing: 0.06em;
      margin: 18px 0;
    }
    .divider::before, .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border);
    }

    /* Wallet button */
    .wallet-btn {
      display: flex;
      align-items: center;
      gap: 12px;
      width: 100%;
      padding: 12px 16px;
      background: #fff;
      border: 1.5px solid var(--border-strong);
      border-radius: var(--radius);
      cursor: pointer;
      transition: all 0.18s;
      font-family: var(--font);
    }
    .wallet-btn:hover { background: var(--slate-50); border-color: var(--slate-300); }
    .wallet-icon {
      width: 36px; height: 36px;
      border-radius: 9px;
      background: linear-gradient(135deg, #F59E0B, #FB923C);
      display: grid; place-items: center;
      flex-shrink: 0;
    }
    .wallet-text { flex: 1; text-align: left; }
    .wallet-title { font-size: 13.5px; font-weight: 600; color: var(--text-1); }
    .wallet-sub { font-size: 11px; color: var(--text-3); margin-top: 1px; }

    /* Role cards (register) */
    .role-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
    }
    .role-card {
      padding: 14px;
      border: 1.5px solid var(--border-strong);
      border-radius: var(--radius);
      cursor: pointer;
      transition: all 0.18s;
      background: #fff;
    }
    .role-card:hover { border-color: var(--blue-300); }
    .role-card.selected {
      border-color: var(--blue-600);
      background: var(--blue-50);
    }
    .role-card svg { margin-bottom: 8px; }
    .role-name { font-size: 13px; font-weight: 600; }
    .role-desc { font-size: 11px; color: var(--text-3); margin-top: 2px; }

    /* Alert box */
    .alert {
      padding: 12px 14px;
      border-radius: 10px;
      font-size: 13px;
      margin-bottom: 16px;
      display: none;
      align-items: center;
      gap: 10px;
      line-height: 1.4;
    }
    .alert.show { display: flex; }
    .alert-error { background: var(--rose-50); border: 1px solid #fecdd3; color: var(--rose-600); }
    .alert-success { background: var(--emerald-50); border: 1px solid var(--emerald-100); color: var(--emerald-600); }

    /* Screen panels */
    .screen-panel { display: none; }
    .screen-panel.active { display: block; }

    /* Animations */
    .fade-in {
      animation: fadeIn 0.25s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Scrollbar */
    .right-panel::-webkit-scrollbar { width: 4px; }
    .right-panel::-webkit-scrollbar-track { background: transparent; }
    .right-panel::-webkit-scrollbar-thumb { background: var(--slate-200); border-radius: 4px; }
  </style>
</head>
<body>
@php $activeTab = $errors->hasAny(['name', 'institution']) ? 'register' : 'login'; @endphp

<div class="layout">

  <!-- ───────────── LEFT PANEL ───────────── -->
  <div class="left-panel">
    <div class="glow-top"></div>
    <div class="glow-bottom"></div>

    <!-- Brand -->
    <div class="brand">
      <div class="brand-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
          <path d="M12 2L3 6.5v6c0 5 3.8 8.7 9 9.5 5.2-.8 9-4.5 9-9.5v-6L12 2z"
                stroke="white" stroke-width="2" stroke-linejoin="round" fill="rgba(255,255,255,0.15)"/>
          <path d="M8.5 12l2.5 2.5L15.5 10" stroke="white" stroke-width="2.4"
                stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="brand-name">CertChain</div>
    </div>

    <!-- Certificate Illustration -->
    <div class="cert-illustration">
      <div class="cert-wrapper">
        <div class="cert-back"></div>
        <div class="cert-mid"></div>
        <div class="cert-main">
          <div class="cert-header">
            <div class="cert-label">Certificate of Degree</div>
            <div class="cert-verified">
              <div class="cert-dot"></div>
              Verified
            </div>
          </div>
          <div class="cert-name">Ahmed Mahmoud Ali</div>
          <div class="cert-degree">B.Sc. Computer Science · UCAS Palestine</div>
          <div class="cert-divider"></div>
          <div class="cert-hash">CERT-UCAS-2026-0042 &nbsp;·&nbsp; Keccak-256<br>0x8a3f7b21c4d9e02f…c1b8e6d5</div>
          <div class="cert-footer">
            <div class="cert-dot"></div>
            On-chain confirmed
          </div>
        </div>

        <!-- Chain link SVG -->
        <svg style="position:absolute; top:-10px; right:10px; width:80px; height:80px; opacity:0.7" viewBox="0 0 80 80" fill="none">
          <circle cx="20" cy="20" r="13" stroke="rgba(255,255,255,0.5)" stroke-width="2"/>
          <circle cx="40" cy="40" r="13" stroke="rgba(255,255,255,0.7)" stroke-width="2"/>
          <circle cx="60" cy="60" r="13" stroke="rgba(255,255,255,0.5)" stroke-width="2"/>
        </svg>

        <!-- Block pills -->
        <div class="blocks">
          <div class="block-pill">#48201930</div>
          <div class="block-pill">#48201931</div>
          <div class="block-pill active">#48201932</div>
          <div class="block-pill">#48201933</div>
        </div>
      </div>
    </div>

    <!-- Hero copy -->
    <div class="hero-copy">
      <div class="hero-heading">Credentials you can trust, instantly.</div>
      <div class="hero-sub">
        Universities issue. The chain remembers. Employers verify in one click — no calls, no fakes.
      </div>
      <div class="trust-pills">
        <div class="trust-pill">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z"/><path d="M9 12l2 2 4-4"/></svg>
          Tamper-proof
        </div>
        <div class="trust-pill">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
          Instant verification
        </div>
        <div class="trust-pill">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 1 1 8 0v4"/></svg>
          No wallet needed
        </div>
      </div>
    </div>

    <!-- Stats -->
    <div class="stats-row">
      <div class="stat-item">
        <div class="stat-val">12</div>
        <div class="stat-label">Universities</div>
      </div>
      <div class="stat-item">
        <div class="stat-val">12,847</div>
        <div class="stat-label">Certificates</div>
      </div>
      <div class="stat-item">
        <div class="stat-val">99.9%</div>
        <div class="stat-label">Uptime</div>
      </div>
    </div>
  </div>

    <div class="form-area">
      <div class="form-inner">

        <!-- Tab toggle -->
        <div class="tab-row">
          <button type="button" class="tab-btn {{ $activeTab === 'login' ? 'active' : '' }}" id="tab-login" onclick="switchTab('login')">Sign In</button>
          <button type="button" class="tab-btn {{ $activeTab === 'register' ? 'active' : '' }}" id="tab-register" onclick="switchTab('register')">Register</button>
        </div>

        <!-- ── LOGIN PANEL ── -->
        <div class="screen-panel {{ $activeTab === 'login' ? 'active' : '' }} fade-in" id="panel-login">
          <h1 class="form-heading">Welcome back</h1>
          <p class="form-sub">Sign in to manage credentials and verify certificates.</p>

          <form id="login-form" action="/login" method="POST">
            @csrf

            {{-- Flash error from controller --}}
            @if(session('error') && $activeTab === 'login')
            <div class="alert alert-error show">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3 2 20h20L12 3z"/><path d="M12 10v4M12 18h.01"/></svg>
              <span>{{ session('error') }}</span>
            </div>
            @endif
            @if(session('ok') && $activeTab === 'login')
            <div class="alert show" style="background:#ECFDF5;color:#047857;border-color:#A7F3D0;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
              <span>{{ session('ok') }}</span>
            </div>
            @endif
            {{-- JS-driven alert (client-side validation) --}}
            <div class="alert alert-error" id="login-alert">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3 2 20h20L12 3z"/><path d="M12 10v4M12 18h.01"/></svg>
              <span id="login-alert-msg"></span>
            </div>

            <!-- Email -->
            <div class="field">
              <label class="field-label" for="login-email">Email address</label>
              <div class="input-wrap">
                <span class="input-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                </span>
                <input type="email" id="login-email" name="email"
                       value="{{ old('email') }}"
                       placeholder="you@university.edu" autocomplete="email"
                       class="{{ $errors->has('email') && $activeTab === 'login' ? 'error' : '' }}"/>
              </div>
              <span class="error-msg {{ $errors->has('email') && $activeTab === 'login' ? 'show' : '' }}" id="login-email-err">
                {{ $errors->first('email') ?? 'Please enter a valid email.' }}
              </span>
            </div>

            <!-- Password -->
            <div class="field">
              <div class="field-row">
                <label class="field-label" for="login-pass">Password</label>
                <a class="forgot-link" href="#">Forgot password?</a>
              </div>
              <div class="input-wrap">
                <span class="input-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 1 1 8 0v4"/></svg>
                </span>
                <input type="password" id="login-pass" name="password"
                       class="has-toggle {{ $errors->has('password') && $activeTab === 'login' ? 'error' : '' }}"
                       placeholder="Your password" autocomplete="current-password"/>
                <button class="input-toggle" type="button" onclick="togglePass('login-pass', this)">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
              <span class="error-msg {{ $errors->has('password') && $activeTab === 'login' ? 'show' : '' }}" id="login-pass-err">
                {{ $errors->first('password') ?? 'Password must be at least 8 characters.' }}
              </span>
            </div>

            <!-- Remember -->
            <label class="remember-row">
              <input type="checkbox" name="remember" id="remember-me" checked/>
              Keep me signed in for 30 days
            </label>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary btn-block" id="login-btn">
              <div class="spinner"></div>
              <span class="btn-text">Sign in</span>
            </button>

          </form>
        </div>

        <!-- ── REGISTER PANEL ── -->
        <div class="screen-panel {{ $activeTab === 'register' ? 'active' : '' }} fade-in" id="panel-register">
          <h1 class="form-heading">Create account</h1>
          <p class="form-sub">Start issuing tamper-proof academic certificates.</p>

          <form id="register-form" action="/register" method="POST">
            @csrf

            {{-- JS-driven alert --}}
            <div class="alert alert-error" id="reg-alert">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3 2 20h20L12 3z"/><path d="M12 10v4M12 18h.01"/></svg>
              <span id="reg-alert-msg"></span>
            </div>

            <!-- Full name -->
            <div class="field">
              <label class="field-label" for="reg-name">Full name</label>
              <div class="input-wrap">
                <span class="input-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                </span>
                <input type="text" id="reg-name" name="name"
                       value="{{ old('name') }}"
                       placeholder="Dr. Ahmed M. Ali"
                       class="{{ $errors->has('name') ? 'error' : '' }}"/>
              </div>
              <span class="error-msg {{ $errors->has('name') ? 'show' : '' }}" id="reg-name-err">
                {{ $errors->first('name') ?? 'Full name is required.' }}
              </span>
            </div>

            <!-- Institution -->
            <div class="field">
              <label class="field-label" for="reg-institution">Institution</label>
              <div class="input-wrap">
                <span class="input-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 21v-6h6v6"/><path d="M9 10h.01M12 10h.01M15 10h.01"/></svg>
                </span>
                <input type="text" id="reg-institution" name="institution"
                       value="{{ old('institution') }}"
                       placeholder="e.g. UCAS"
                       class="{{ $errors->has('institution') && $activeTab === 'register' ? 'error' : '' }}"/>
              </div>
              <span class="error-msg {{ $errors->has('institution') && $activeTab === 'register' ? 'show' : '' }}" id="reg-institution-err">
                {{ $errors->first('institution') ?? 'Institution is required.' }}
              </span>
            </div>

            <!-- Email -->
            <div class="field">
              <label class="field-label" for="reg-email">University email</label>
              <div class="input-wrap">
                <span class="input-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                </span>
                <input type="email" id="reg-email" name="email"
                       value="{{ old('email') }}"
                       placeholder="you@university.edu"
                       class="{{ $errors->has('email') && $activeTab === 'register' ? 'error' : '' }}"/>
              </div>
              <span class="error-msg {{ $errors->has('email') && $activeTab === 'register' ? 'show' : '' }}" id="reg-email-err">
                {{ $errors->first('email') ?? 'Please enter a valid email.' }}
              </span>
            </div>

            <!-- Password -->
            <div class="field">
              <label class="field-label" for="reg-pass">Password</label>
              <div class="input-wrap">
                <span class="input-icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 1 1 8 0v4"/></svg>
                </span>
                <input type="password" id="reg-pass" name="password"
                       class="has-toggle {{ $errors->has('password') && $activeTab === 'register' ? 'error' : '' }}"
                       placeholder="At least 8 characters" oninput="checkStrength(this.value)"/>
                <button class="input-toggle" type="button" onclick="togglePass('reg-pass', this)">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
              <span class="error-msg {{ $errors->has('password') && $activeTab === 'register' ? 'show' : '' }}" id="reg-pass-err">
                {{ $errors->first('password') ?? 'Password must be at least 8 characters.' }}
              </span>
              <!-- Strength bar -->
              <div id="strength-bar" style="display:flex; gap:4px; margin-top:6px;">
                <div class="s-seg" style="flex:1; height:4px; border-radius:99px; background:var(--slate-200); transition:background .3s;"></div>
                <div class="s-seg" style="flex:1; height:4px; border-radius:99px; background:var(--slate-200); transition:background .3s;"></div>
                <div class="s-seg" style="flex:1; height:4px; border-radius:99px; background:var(--slate-200); transition:background .3s;"></div>
              </div>
              <span id="strength-label" style="font-size:11px; color:var(--text-3); margin-top:4px;"></span>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary btn-block" id="reg-btn" style="margin-top:4px">
              <div class="spinner"></div>
              <span class="btn-text">Create account</span>
            </button>

            <p style="font-size:12px; color:var(--text-3); text-align:center; margin-top:14px; line-height:1.5;">
              By creating an account you agree to our
              <a href="#" style="color:var(--blue-600)">Terms</a> and
              <a href="#" style="color:var(--blue-600)">Privacy Policy</a>.
            </p>

          </form>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- ─────────────────── JS ─────────────────── -->
<script>
  /* ── Tab switching ── */
  function switchTab(tab) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.screen-panel').forEach(p => p.classList.remove('active'));

    document.getElementById('tab-' + tab).classList.add('active');
    const panel = document.getElementById('panel-' + tab);
    panel.classList.add('active', 'fade-in');

    // Re-trigger animation
    panel.style.animation = 'none';
    requestAnimationFrame(() => { panel.style.animation = ''; });
  }

  /* ── Password visibility toggle ── */
  function togglePass(inputId, btn) {
    const input = document.getElementById(inputId);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.innerHTML = isText
      ? `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>`
      : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.9 17.4C16.3 18.4 14.2 19 12 19c-6.5 0-10-7-10-7a17.5 17.5 0 0 1 4.1-5.4M9.5 4.4A9.8 9.8 0 0 1 12 4c6.5 0 10 7 10 7a17.5 17.5 0 0 1-2.3 3.3M15 12a3 3 0 0 1-4.5 2.6M3 3l18 18"/></svg>`;
  }

  /* ── Password strength ── */
  function checkStrength(val) {
    const segs = document.querySelectorAll('.s-seg');
    const label = document.getElementById('strength-label');
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val) || /[a-z]/.test(val)) score++;
    if (/[0-9]/.test(val) || /[^a-zA-Z0-9]/.test(val)) score++;

    const colors = ['var(--emerald-500)', 'var(--amber-500)', 'var(--rose-500)'];
    const labels = ['', 'Weak', 'Medium', 'Strong'];

    segs.forEach((s, i) => {
      s.style.background = 'var(--slate-200)';
    });

    if (score > 0 && score <= segs.length) {
      segs[score - 1].style.background = colors[score - 1];
    }

    label.textContent = val.length ? labels[score] : '';
    if (score > 0) {
      label.style.color = colors[score - 1];
    } else {
      label.style.color = 'var(--text-3)';
    }
  }

  /* ── Role selection — updates hidden input so the form sends the value ── */
  function selectRole(role) {
    document.getElementById('hidden-role').value = role;
    document.getElementById('role-admin').classList.toggle('selected', role === 'admin');
    document.getElementById('role-verifier').classList.toggle('selected', role === 'verifier');
    document.querySelector('#role-admin svg').setAttribute('stroke', role === 'admin' ? 'var(--blue-600)' : 'var(--text-3)');
    document.querySelector('#role-verifier svg').setAttribute('stroke', role === 'verifier' ? 'var(--blue-600)' : 'var(--text-3)');
  }

  /* ── Validation helpers ── */
  function setError(inputId, errId, show) {
    const inp = document.getElementById(inputId);
    const err = document.getElementById(errId);
    if (show) { inp.classList.add('error'); err.classList.add('show'); }
    else       { inp.classList.remove('error'); err.classList.remove('show'); }
  }
  function showAlert(alertId, msgId, msg) {
    document.getElementById(alertId).classList.add('show');
    document.getElementById(msgId).textContent = msg;
  }
  function hideAlert(alertId) { document.getElementById(alertId).classList.remove('show'); }

  /* ── Login form: client-side validation before native submit ── */
  document.getElementById('login-form').addEventListener('submit', function(e) {
    hideAlert('login-alert');
    const email = document.getElementById('login-email').value.trim();
    const pass  = document.getElementById('login-pass').value;
    let valid = true;

    const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    setError('login-email', 'login-email-err', !emailOk);
    if (!emailOk) valid = false;

    const passOk = pass.length >= 8;
    setError('login-pass', 'login-pass-err', !passOk);
    if (!passOk) valid = false;

    if (!valid) { e.preventDefault(); return; }

    const btn = document.getElementById('login-btn');
    btn.classList.add('loading');
    btn.disabled = true;
  });

  /* ── Register form: client-side validation before native submit ── */
  document.getElementById('register-form').addEventListener('submit', function(e) {
    hideAlert('reg-alert');
    const name  = document.getElementById('reg-name').value.trim();
    const institution = document.getElementById('reg-institution').value.trim();
    const email = document.getElementById('reg-email').value.trim();
    const pass  = document.getElementById('reg-pass').value;
    let valid = true;

    setError('reg-name', 'reg-name-err', !name);
    if (!name) valid = false;

    setError('reg-institution', 'reg-institution-err', !institution);
    if (!institution) valid = false;

    const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    setError('reg-email', 'reg-email-err', !emailOk);
    if (!emailOk) valid = false;

    const passOk = pass.length >= 8;
    setError('reg-pass', 'reg-pass-err', !passOk);
    if (!passOk) valid = false;

    if (!valid) {
      showAlert('reg-alert', 'reg-alert-msg', 'Please fix the errors above before continuing.');
      e.preventDefault();
      return;
    }

    const btn = document.getElementById('reg-btn');
    btn.classList.add('loading');
    btn.disabled = true;
  });
</script>

</body>
</html>
