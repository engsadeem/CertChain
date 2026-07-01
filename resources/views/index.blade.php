<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CertChain — Blockchain Academic Certificate Verification</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    /* ────────────────────────────────────────
       DESIGN TOKENS  (matching /login)
    ──────────────────────────────────────── */
    :root {
      --blue-50:   #EFF5FF;
      --blue-100:  #DBE7FE;
      --blue-200:  #BFD3FE;
      --blue-500:  #3B7DF7;
      --blue-600:  #2563EB;
      --blue-700:  #1D4ED8;
      --blue-800:  #1e40af;

      --emerald-50:  #ECFDF5;
      --emerald-100: #D1FAE5;
      --emerald-500: #10B981;
      --emerald-600: #059669;
      --emerald-700: #047857;

      --amber-50:  #FFFBEB;
      --amber-500: #F59E0B;

      --rose-50:   #FFF1F2;
      --rose-500:  #F43F5E;
      --rose-600:  #E11D48;

      --slate-25:  #FBFCFD;
      --slate-50:  #F8FAFC;
      --slate-100: #F1F5F9;
      --slate-150: #E8EDF3;
      --slate-200: #E2E8F0;
      --slate-300: #CBD5E1;
      --slate-400: #94A3B8;
      --slate-500: #64748B;
      --slate-600: #475569;
      --slate-700: #334155;
      --slate-800: #1E293B;
      --slate-900: #0F172A;

      --bg:      #F6F8FB;
      --surface: #FFFFFF;
      --border:  #E6EBF2;
      --border-strong: #D6DEE9;

      --text-1: #0F172A;
      --text-2: #475569;
      --text-3: #64748B;
      --text-4: #94A3B8;

      --radius:    12px;
      --radius-lg: 16px;
      --radius-xl: 20px;
      --shadow-xs: 0 1px 2px rgba(15,23,42,0.04);
      --shadow-sm: 0 1px 3px rgba(15,23,42,0.06), 0 1px 2px rgba(15,23,42,0.04);
      --shadow-md: 0 4px 12px rgba(15,23,42,0.08), 0 1px 2px rgba(15,23,42,0.04);
      --shadow-lg: 0 12px 32px rgba(15,23,42,0.10), 0 2px 6px rgba(15,23,42,0.04);

      --font:    'Inter', -apple-system, sans-serif;
      --display: 'Playfair Display', Georgia, serif;
      --mono:    'JetBrains Mono', monospace;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html { scroll-behavior: smooth; }

    body {
      font-family: var(--font);
      background: var(--bg);
      color: var(--text-1);
      -webkit-font-smoothing: antialiased;
      letter-spacing: -0.005em;
      overflow-x: hidden;
    }

    /* ──── SCROLLBAR ──── */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--slate-200); border-radius: 4px; }

    /* ──────────────────────────────────────────
       NAVBAR
    ────────────────────────────────────────── */
    .navbar {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 100;
      height: 64px;
      background: rgba(246,248,251,0.85);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      padding: 0 40px;
      gap: 24px;
    }

    .nav-brand {
      display: flex;
      align-items: center;
      gap: 9px;
      text-decoration: none;
      flex-shrink: 0;
    }
    .nav-logo-icon {
      width: 32px; height: 32px;
      flex-shrink: 0;
    }
    .nav-brand-name {
      font-weight: 700;
      font-size: 16px;
      color: var(--text-1);
      letter-spacing: -0.02em;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 4px;
      list-style: none;
      margin-left: 24px;
    }
    .nav-links a {
      display: block;
      padding: 6px 12px;
      font-size: 13.5px;
      font-weight: 500;
      color: var(--text-2);
      text-decoration: none;
      border-radius: 8px;
      transition: all 0.15s;
    }
    .nav-links a:hover { color: var(--text-1); background: var(--slate-100); }

    .nav-spacer { flex: 1; }

    .nav-actions { display: flex; align-items: center; gap: 10px; }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 7px;
      height: 38px;
      padding: 0 16px;
      border-radius: var(--radius);
      font-family: var(--font);
      font-size: 13.5px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.18s ease;
      white-space: nowrap;
      letter-spacing: -0.01em;
    }
    .btn-ghost {
      background: transparent;
      color: var(--text-2);
    }
    .btn-ghost:hover { background: var(--slate-100); color: var(--text-1); }
    .btn-secondary {
      background: var(--surface);
      color: var(--text-1);
      border: 1.5px solid var(--border-strong);
      box-shadow: var(--shadow-xs);
    }
    .btn-secondary:hover { background: var(--slate-50); }
    .btn-primary {
      background: var(--blue-600);
      color: #fff;
      box-shadow: 0 1px 0 rgba(255,255,255,0.12) inset, 0 2px 6px rgba(37,99,235,0.28);
    }
    .btn-primary:hover { background: var(--blue-700); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.35); }
    .btn-primary:active { transform: translateY(0); }
    .btn-lg { height: 48px; padding: 0 24px; font-size: 15px; border-radius: 14px; }
    .btn-sm { height: 32px; padding: 0 12px; font-size: 12.5px; border-radius: 8px; }

    /* ──────────────────────────────────────────
       HERO
    ────────────────────────────────────────── */
    .hero {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 120px 24px 80px;
      position: relative;
      overflow: hidden;
    }

    /* Soft radial glow */
    .hero::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background:
        radial-gradient(ellipse 70% 55% at 50% 25%, rgba(37,99,235,0.07) 0%, transparent 70%),
        radial-gradient(ellipse 50% 40% at 80% 75%, rgba(16,185,129,0.05) 0%, transparent 60%),
        radial-gradient(ellipse 40% 30% at 15% 60%, rgba(59,125,247,0.05) 0%, transparent 60%);
      pointer-events: none;
    }

    /* Dot grid */
    .hero-grid {
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle, rgba(37,99,235,0.12) 1px, transparent 1px);
      background-size: 32px 32px;
      mask-image: radial-gradient(ellipse 80% 70% at 50% 40%, black 30%, transparent 80%);
      pointer-events: none;
    }

    .hero-inner { position: relative; z-index: 1; max-width: 780px; width: 100%; }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 14px;
      background: var(--blue-50);
      border: 1px solid var(--blue-100);
      border-radius: 99px;
      font-family: var(--mono);
      font-size: 11.5px;
      font-weight: 500;
      color: var(--blue-700);
      margin-bottom: 28px;
      letter-spacing: 0.02em;
    }
    .badge-pulse {
      width: 7px; height: 7px;
      border-radius: 50%;
      background: var(--blue-500);
      animation: pulse 2s ease-in-out infinite;
      flex-shrink: 0;
    }
    @keyframes pulse {
      0%,100% { opacity: 1; box-shadow: 0 0 0 0 rgba(59,125,247,0.4); }
      50%      { opacity: 0.7; box-shadow: 0 0 0 5px rgba(59,125,247,0); }
    }

    .hero-headline {
      font-family: var(--display);
      font-size: clamp(2.8rem, 6vw, 4.6rem);
      font-weight: 700;
      line-height: 1.12;
      letter-spacing: -0.03em;
      color: var(--text-1);
      margin-bottom: 22px;
    }
    .hero-headline .accent {
      background: linear-gradient(135deg, var(--blue-600) 0%, #3B7DF7 50%, #60A5FA 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero-sub {
      font-size: 17px;
      color: var(--text-3);
      line-height: 1.7;
      max-width: 560px;
      margin: 0 auto 40px;
      font-weight: 400;
    }

    .hero-actions {
      display: flex;
      gap: 12px;
      justify-content: center;
      flex-wrap: wrap;
      margin-bottom: 64px;
    }

    /* Stats bar */
    .stats-bar {
      display: flex;
      gap: 0;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      box-shadow: var(--shadow-md);
      overflow: hidden;
      /* max-width: 640px;  */
      width: 100%;
    }
    .stat-cell {
      flex: 1;
      padding: 20px 24px;
      text-align: center;
      position: relative;
    }
    .stat-cell + .stat-cell::before {
      content: '';
      position: absolute;
      left: 0; top: 20%; bottom: 20%;
      width: 1px;
      background: var(--border);
    }
    .stat-val {
      display: block;
      font-family: var(--mono);
      font-size: 22px;
      font-weight: 600;
      color: var(--blue-600);
      line-height: 1;
      margin-bottom: 6px;
    }
    .stat-label {
      font-size: 11.5px;
      font-weight: 500;
      color: var(--text-4);
      letter-spacing: 0.02em;
    }

    /* Trust pills below stats */
    .trust-row {
      display: flex;
      gap: 10px;
      justify-content: center;
      flex-wrap: wrap;
      margin-top: 28px;
    }
    .trust-pill {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 6px 13px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 99px;
      font-size: 12px;
      font-weight: 500;
      color: var(--text-2);
      box-shadow: var(--shadow-xs);
    }
    .trust-pill svg { color: var(--emerald-500); }

    /* ──────────────────────────────────────────
       SECTION COMMONS
    ────────────────────────────────────────── */
    section { padding: 96px 40px; }

    .section-inner { max-width: 1100px; margin: 0 auto; }
    .section-inner-sm { max-width: 800px; margin: 0 auto; }
    .section-inner-md { max-width: 960px; margin: 0 auto; }

    .section-tag {
      display: inline-block;
      font-family: var(--mono);
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--blue-600);
      background: var(--blue-50);
      border: 1px solid var(--blue-100);
      border-radius: 99px;
      padding: 4px 12px;
      margin-bottom: 16px;
    }

    .section-heading {
      font-family: var(--display);
      font-size: clamp(1.9rem, 3.5vw, 2.8rem);
      font-weight: 700;
      letter-spacing: -0.025em;
      color: var(--text-1);
      margin-bottom: 14px;
      line-height: 1.2;
    }

    .section-desc {
      font-size: 15.5px;
      color: var(--text-3);
      max-width: 520px;
      line-height: 1.7;
    }

    .section-header { margin-bottom: 48px; }
    .section-header-center { text-align: center; }
    .section-header-center .section-desc { margin: 0 auto; }

    /* ──────────────────────────────────────────
       BLOCKCHAIN VIZ SECTION
    ────────────────────────────────────────── */
    .chain-section {
      background: var(--surface);
      border-top: 1px solid var(--border);
      border-bottom: 1px solid var(--border);
    }

    .blockchain-scroll {
      overflow-x: auto;
      padding: 8px 0 24px;
    }
    .blockchain-scroll::-webkit-scrollbar { height: 4px; }
    .blockchain-scroll::-webkit-scrollbar-thumb { background: var(--slate-200); border-radius: 4px; }

    .blockchain-track {
      display: flex;
      align-items: center;
      min-width: max-content;
      padding: 8px 0;
      gap: 0;
    }

    .block-card {
      background: var(--bg);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 18px 20px;
      min-width: 180px;
      position: relative;
      transition: all 0.2s;
      box-shadow: var(--shadow-xs);
    }
    .block-card:hover {
      border-color: var(--blue-200);
      box-shadow: var(--shadow-md);
      transform: translateY(-2px);
    }
    .block-card.genesis {
      border-color: var(--blue-200);
      background: var(--blue-50);
    }
    .block-card.active {
      border-color: var(--emerald-500);
      background: var(--emerald-50);
      box-shadow: 0 0 0 3px rgba(16,185,129,0.12);
    }

    .block-num {
      font-family: var(--mono);
      font-size: 10px;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--blue-600);
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .block-card.genesis .block-num { color: var(--blue-700); }
    .block-card.active .block-num { color: var(--emerald-700); }

    .block-status {
      width: 7px; height: 7px;
      border-radius: 50%;
      background: var(--blue-500);
    }
    .block-card.active .block-status { background: var(--emerald-500); }

    .block-hash-text {
      font-family: var(--mono);
      font-size: 10.5px;
      color: var(--text-4);
      word-break: break-all;
      line-height: 1.5;
      margin-bottom: 10px;
    }

    .block-body {
      font-size: 12px;
      color: var(--text-2);
      line-height: 1.5;
      font-weight: 500;
    }
    .block-body .uni { font-size: 11px; color: var(--text-3); margin-top: 2px; }

    .block-arrow {
      display: flex;
      align-items: center;
      padding: 0 10px;
      flex-shrink: 0;
    }
    .arrow-line {
      width: 32px;
      height: 1.5px;
      background: linear-gradient(90deg, var(--border-strong), var(--blue-200));
    }
    .arrow-head {
      width: 0; height: 0;
      border-top: 5px solid transparent;
      border-bottom: 5px solid transparent;
      border-left: 7px solid var(--blue-200);
    }

    /* ──────────────────────────────────────────
       FEATURES GRID
    ────────────────────────────────────────── */
    .features-section { background: var(--bg); }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
    }

    .feature-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      padding: 28px;
      transition: all 0.22s ease;
      box-shadow: var(--shadow-xs);
      position: relative;
      overflow: hidden;
    }
    .feature-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--blue-200), transparent);
      opacity: 0;
      transition: opacity 0.22s;
    }
    .feature-card:hover {
      border-color: var(--blue-100);
      box-shadow: var(--shadow-md);
      transform: translateY(-3px);
    }
    .feature-card:hover::before { opacity: 1; }

    .feature-icon-wrap {
      width: 48px; height: 48px;
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 22px;
      margin-bottom: 18px;
      border: 1px solid var(--border);
      background: var(--bg);
    }

    .feature-title {
      font-size: 15px;
      font-weight: 600;
      color: var(--text-1);
      margin-bottom: 8px;
      letter-spacing: -0.01em;
    }
    .feature-desc {
      font-size: 13.5px;
      color: var(--text-3);
      line-height: 1.7;
    }

    .feature-tag {
      display: inline-block;
      margin-top: 14px;
      font-size: 11px;
      font-weight: 600;
      color: var(--blue-700);
      background: var(--blue-50);
      padding: 3px 9px;
      border-radius: 99px;
      border: 1px solid var(--blue-100);
    }
    .feature-tag.emerald {
      color: var(--emerald-700);
      background: var(--emerald-50);
      border-color: var(--emerald-100);
    }

    /* ──────────────────────────────────────────
       HOW IT WORKS
    ────────────────────────────────────────── */
    .how-section {
      background: var(--surface);
      border-top: 1px solid var(--border);
      border-bottom: 1px solid var(--border);
    }

    .steps-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 0;
      position: relative;
      margin-top: 48px;
    }

    /* Connecting line */
    .steps-grid::before {
      content: '';
      position: absolute;
      top: 36px;
      left: calc(12.5% + 24px);
      right: calc(12.5% + 24px);
      height: 1.5px;
      background: linear-gradient(90deg, var(--blue-200), var(--blue-100), var(--blue-200));
      z-index: 0;
    }

    .step-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 0 20px;
      position: relative;
      z-index: 1;
    }

    .step-circle {
      width: 72px; height: 72px;
      border-radius: 50%;
      background: var(--surface);
      border: 2px solid var(--blue-200);
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      margin-bottom: 22px;
      position: relative;
      box-shadow: var(--shadow-sm);
      transition: all 0.25s;
    }
    .step-item:hover .step-circle {
      border-color: var(--blue-500);
      box-shadow: 0 0 0 6px rgba(37,99,235,0.08);
    }

    .step-n {
      font-family: var(--mono);
      font-size: 11px;
      font-weight: 600;
      color: var(--text-4);
      letter-spacing: 0.05em;
    }
    .step-icon { font-size: 22px; }

    .step-title {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-1);
      margin-bottom: 8px;
      letter-spacing: -0.01em;
    }
    .step-desc {
      font-size: 13px;
      color: var(--text-3);
      line-height: 1.65;
    }

    /* ──────────────────────────────────────────
       TECH STACK
    ────────────────────────────────────────── */
    .tech-section { background: var(--bg); }

    .tech-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: center;
      margin-top: 40px;
    }

    .tech-pill {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 18px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 99px;
      font-family: var(--mono);
      font-size: 13px;
      font-weight: 500;
      color: var(--text-2);
      box-shadow: var(--shadow-xs);
      transition: all 0.18s;
    }
    .tech-pill:hover {
      border-color: var(--blue-200);
      color: var(--blue-700);
      box-shadow: var(--shadow-sm);
      transform: translateY(-1px);
    }
    .tech-dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      background: var(--blue-500);
      flex-shrink: 0;
    }
    .tech-dot.emerald { background: var(--emerald-500); }
    .tech-dot.amber   { background: var(--amber-500); }

    /* ──────────────────────────────────────────
       CTA BANNER
    ────────────────────────────────────────── */
    .cta-section {
      padding: 80px 40px;
      background: var(--surface);
      border-top: 1px solid var(--border);
    }

    .cta-card {
      max-width: 820px;
      margin: 0 auto;
      background: linear-gradient(135deg, #1D4ED8 0%, #2563EB 50%, #3B7DF7 100%);
      border-radius: 24px;
      padding: 56px 64px;
      text-align: center;
      position: relative;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(37,99,235,0.25);
    }

    .cta-card::before {
      content: '';
      position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
      background-size: 40px 40px;
    }

    .cta-glow {
      position: absolute;
      top: -80px; right: -80px;
      width: 300px; height: 300px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(167,200,255,0.3), transparent 70%);
      pointer-events: none;
    }

    .cta-inner { position: relative; z-index: 1; }

    .cta-heading {
      font-family: var(--display);
      font-size: clamp(1.8rem, 3vw, 2.6rem);
      font-weight: 700;
      color: #fff;
      letter-spacing: -0.025em;
      margin-bottom: 14px;
    }
    .cta-sub {
      font-size: 15px;
      color: rgba(255,255,255,0.78);
      line-height: 1.65;
      max-width: 480px;
      margin: 0 auto 36px;
    }
    .cta-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

    .btn-white {
      background: #fff;
      color: var(--blue-700);
      height: 48px;
      padding: 0 24px;
      font-size: 14.5px;
      font-weight: 700;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    .btn-white:hover { background: var(--blue-50); transform: translateY(-1px); }

    .btn-outline-white {
      background: rgba(255,255,255,0.1);
      color: #fff;
      border: 1.5px solid rgba(255,255,255,0.3);
      height: 48px;
      padding: 0 24px;
      font-size: 14.5px;
      font-weight: 600;
      border-radius: 12px;
      backdrop-filter: blur(4px);
    }
    .btn-outline-white:hover { background: rgba(255,255,255,0.2); }

    /* ──────────────────────────────────────────
       FOOTER
    ────────────────────────────────────────── */
    footer {
      background: var(--surface);
      border-top: 1px solid var(--border);
      padding: 40px;
    }

    .footer-inner {
      max-width: 1100px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 24px;
      flex-wrap: wrap;
    }

    .footer-brand {
      display: flex;
      align-items: center;
      gap: 9px;
      text-decoration: none;
    }
    .footer-brand-name {
      font-weight: 700;
      font-size: 15px;
      color: var(--text-1);
      letter-spacing: -0.02em;
    }

    .footer-desc {
      font-size: 13px;
      color: var(--text-3);
      margin-top: 6px;
      max-width: 340px;
    }

    .footer-links {
      display: flex;
      gap: 20px;
      list-style: none;
    }
    .footer-links a {
      font-size: 13px;
      color: var(--text-3);
      text-decoration: none;
      transition: color 0.15s;
    }
    .footer-links a:hover { color: var(--text-1); }

    .footer-copy {
      font-size: 12.5px;
      color: var(--text-4);
      margin-top: 28px;
      padding-top: 20px;
      border-top: 1px solid var(--border);
      text-align: center;
      max-width: 1100px;
      margin-left: auto; margin-right: auto;
    }

    /* ──────────────────────────────────────────
       SCROLL ANIMATIONS
    ────────────────────────────────────────── */
    .fade-up {
      opacity: 0;
      transform: translateY(28px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .fade-up.visible {
      opacity: 1;
      transform: translateY(0);
    }
    .fade-up-delay-1 { transition-delay: 0.1s; }
    .fade-up-delay-2 { transition-delay: 0.2s; }
    .fade-up-delay-3 { transition-delay: 0.3s; }

    /* ──────────────────────────────────────────
       RESPONSIVE
    ────────────────────────────────────────── */
    @media (max-width: 900px) {
      .features-grid { grid-template-columns: repeat(2, 1fr); }
      .steps-grid { grid-template-columns: 1fr 1fr; }
      .steps-grid::before { display: none; }
      .navbar { padding: 0 20px; }
      .nav-links { display: none; }
      section { padding: 64px 20px; }
    }
    @media (max-width: 600px) {
      .features-grid { grid-template-columns: 1fr; }
      .steps-grid { grid-template-columns: 1fr; }
      .cta-card { padding: 36px 24px; }
      .footer-inner { flex-direction: column; align-items: flex-start; }
      .stats-bar { flex-wrap: wrap; }
    }
  </style>
</head>
<body>

<!-- ══════════════════════════════
     NAVBAR
══════════════════════════════ -->
<nav class="navbar">
  <a href="#" class="nav-brand">
    <!-- CertChain Shield Logo -->
    <svg class="nav-logo-icon" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect width="32" height="32" rx="8" fill="#EFF5FF"/>
      <path d="M16 4L6 8.5v7.5c0 6.3 4.3 10.9 10 11.5 5.7-.6 10-5.2 10-11.5V8.5L16 4z" stroke="#2563EB" stroke-width="1.8" stroke-linejoin="round" fill="#DBE7FE"/>
      <path d="M12 16l3 3 5-5" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <span class="nav-brand-name">CertChain</span>
  </a>

  <ul class="nav-links">
    <li><a href="#features">Features</a></li>
    <li><a href="#how">How It Works</a></li>
    <li><a href="#tech">Technology</a></li>
  </ul>

  <div class="nav-spacer"></div>

  <div class="nav-actions">
    <a href="/verify" class="btn btn-secondary">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z"/><path d="M9 12l2 2 4-4"/></svg>
      Verify Certificate
    </a>
    <a href="/login" class="btn btn-primary">
      Get Started
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
    </a>
  </div>
</nav>


<!-- ══════════════════════════════
     HERO
══════════════════════════════ -->
<section class="hero">
  <div class="hero-grid"></div>

  <div class="hero-inner">

    <div class="hero-badge">
      <span class="badge-pulse"></span>
      Palestinian Platform · Ethereum Sepolia · Solidity · Laravel
    </div>

    <h1 class="hero-headline">
      Academic Credentials<br>
      <span class="accent">Impossible to Forge</span>
    </h1>

    <p class="hero-sub">
      A unified platform for Palestinian universities to issue and verify academic certificates using blockchain technology — transparent, secure, and decentralized.
    </p>

    <div class="hero-actions">
      <a href="/login" class="btn btn-primary btn-lg">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="4" y="4" width="16" height="14" rx="2"/><path d="M7 9h10M7 13h6"/><circle cx="17" cy="18" r="2.5"/></svg>
        Issue a Certificate
      </a>
      <a href="/verify" class="btn btn-secondary btn-lg">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z"/><path d="M9 12l2 2 4-4"/></svg>
        Verify a Certificate
      </a>
    </div>

    <!-- Stats bar -->
    <div class="stats-bar fade-up">
      <div class="stat-cell">
        <span class="stat-val">0%</span>
        <span class="stat-label">Fraud Rate</span>
      </div>
      <div class="stat-cell">
        <span class="stat-val">&lt;3s</span>
        <span class="stat-label">Verification Time</span>
      </div>
      <div class="stat-cell">
        <span class="stat-val">∞</span>
        <span class="stat-label">Storage Duration</span>
      </div>
      <div class="stat-cell">
        <span class="stat-val">100%</span>
        <span class="stat-label">Transparency</span>
      </div>
    </div>

    <!-- Trust pills -->
    <div class="trust-row fade-up fade-up-delay-1">
      <div class="trust-pill">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 1 1 8 0v4"/></svg>
        No MetaMask needed
      </div>
      <div class="trust-pill">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z"/><path d="M9 12l2 2 4-4"/></svg>
        Tamper-proof on-chain
      </div>
      <div class="trust-pill">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
        Instant verification
      </div>
      <div class="trust-pill">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M2 9 12 4l10 5-10 5L2 9z"/><path d="M6 11v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"/></svg>
        12 Palestinian universities
      </div>
    </div>

  </div>
</section>


<!-- ══════════════════════════════
     BLOCKCHAIN VIZ
══════════════════════════════ -->
<section class="chain-section fade-up">
  <div class="section-inner">
    <div class="section-header section-header-center">
      <span class="section-tag">Infrastructure</span>
      <h2 class="section-heading">An Immutable Chain of Trust</h2>
      <p class="section-desc">
        Every certificate is recorded as a transaction on Ethereum — public, verifiable, and permanent.
      </p>
    </div>

    <div class="blockchain-scroll">
      <div class="blockchain-track">

        <div class="block-card genesis">
          <div class="block-num">
            Block #0 · Genesis
            <span class="block-status"></span>
          </div>
          <div class="block-hash-text">0x0000000...000000</div>
          <div class="block-body">Origin block</div>
        </div>

        <div class="block-arrow"><div class="arrow-line"></div><div class="arrow-head"></div></div>

        <div class="block-card">
          <div class="block-num">
            Block #48201930
            <span class="block-status"></span>
          </div>
          <div class="block-hash-text">0x3a7f…c12e9b41</div>
          <div class="block-body">
            B.Sc. Engineering
            <div class="uni">UCAS · 2025</div>
          </div>
        </div>

        <div class="block-arrow"><div class="arrow-line"></div><div class="arrow-head"></div></div>

        <div class="block-card">
          <div class="block-num">
            Block #48201931
            <span class="block-status"></span>
          </div>
          <div class="block-hash-text">0x9b2c…f83a2e05</div>
          <div class="block-body">
            M.Sc. Technology
            <div class="uni">Birzeit · 2025</div>
          </div>
        </div>

        <div class="block-arrow"><div class="arrow-line"></div><div class="arrow-head"></div></div>

        <div class="block-card active">
          <div class="block-num">
            Block #48201932 · Latest
            <span class="block-status"></span>
          </div>
          <div class="block-hash-text">0xe5a1…2d7b4f19</div>
          <div class="block-body">
            B.Sc. Computer Science
            <div class="uni">An-Najah · 2025</div>
          </div>
        </div>

        <div class="block-arrow"><div class="arrow-line"></div><div class="arrow-head"></div></div>

        <div class="block-card" style="opacity:0.45; pointer-events:none;">
          <div class="block-num">Block #48201933 · Pending</div>
          <div class="block-hash-text">Awaiting confirmation…</div>
          <div class="block-body" style="color:var(--text-4)">Mining…</div>
        </div>

      </div>
    </div>
  </div>
</section>


<!-- ══════════════════════════════
     FEATURES
══════════════════════════════ -->
<section id="features" class="features-section">
  <div class="section-inner">
    <div class="section-header section-header-center fade-up">
      <span class="section-tag">Features</span>
      <h2 class="section-heading">Why CertChain?</h2>
      <p class="section-desc">
        Built specifically for Palestinian universities across the West Bank and Gaza Strip.
      </p>
    </div>

    <div class="features-grid">

      <div class="feature-card fade-up">
        <div class="feature-icon-wrap">🛡️</div>
        <div class="feature-title">Fraud-Proof by Design</div>
        <div class="feature-desc">Keccak-256 cryptographic hashing combined with immutable blockchain storage makes forgery mathematically impossible.</div>
        <span class="feature-tag">Keccak-256</span>
      </div>

      <div class="feature-card fade-up fade-up-delay-1">
        <div class="feature-icon-wrap">🌐</div>
        <div class="feature-title">Free Public Verification</div>
        <div class="feature-desc">Any employer or institution can verify a certificate with no account, no subscription, and no technical knowledge — just the certificate code.</div>
        <span class="feature-tag emerald">Open Access</span>
      </div>

      <div class="feature-card fade-up fade-up-delay-2">
        <div class="feature-icon-wrap">🔓</div>
        <div class="feature-title">No MetaMask Required</div>
        <div class="feature-desc">Users need no crypto wallet whatsoever. The university handles all gas fees on the backend — fully abstracted from end users.</div>
        <span class="feature-tag">Key Differentiator</span>
      </div>

      <div class="feature-card fade-up">
        <div class="feature-icon-wrap">🇵🇸</div>
        <div class="feature-title">Built for Palestine</div>
        <div class="feature-desc">Covers 12 Palestinian universities across the West Bank and Gaza, each managing their own certificates with full autonomy.</div>
        <span class="feature-tag emerald">12 Universities</span>
      </div>

      <div class="feature-card fade-up fade-up-delay-1">
        <div class="feature-icon-wrap">⚡</div>
        <div class="feature-title">Sepolia Testnet — Current</div>
        <div class="feature-desc">Deployed on Ethereum Sepolia (not the deprecated Ropsten or Rinkeby networks), ensuring long-term stability and active ecosystem support.</div>
        <span class="feature-tag">Ethereum Sepolia</span>
      </div>

      <div class="feature-card fade-up fade-up-delay-2">
        <div class="feature-icon-wrap">📱</div>
        <div class="feature-title">Simple, Accessible Interface</div>
        <div class="feature-desc">An intuitive admin dashboard for registrars and a clean public verification page — no technical expertise required on either side.</div>
        <span class="feature-tag emerald">UX-First</span>
      </div>

    </div>
  </div>
</section>


<!-- ══════════════════════════════
     HOW IT WORKS
══════════════════════════════ -->
<section id="how" class="how-section">
  <div class="section-inner-md">
    <div class="section-header section-header-center fade-up">
      <span class="section-tag">Process</span>
      <h2 class="section-heading">How the System Works</h2>
      <p class="section-desc">
        From data entry to on-chain confirmation in four simple steps.
      </p>
    </div>

    <div class="steps-grid fade-up">

      <div class="step-item">
        <div class="step-circle">
          <span class="step-n">01</span>
          <span class="step-icon">📝</span>
        </div>
        <div class="step-title">Enter Graduate Data</div>
        <div class="step-desc">The university registrar enters the graduate's name, degree, GPA, and specialization through the admin dashboard.</div>
      </div>

      <div class="step-item">
        <div class="step-circle">
          <span class="step-n">02</span>
          <span class="step-icon">🔐</span>
        </div>
        <div class="step-title">Generate Digital Hash</div>
        <div class="step-desc">The system generates a unique fingerprint using the Keccak-256 algorithm, derived from the full certificate data.</div>
      </div>

      <div class="step-item">
        <div class="step-circle">
          <span class="step-n">03</span>
          <span class="step-icon">⛓️</span>
        </div>
        <div class="step-title">Record on Blockchain</div>
        <div class="step-desc">The hash is sent to the smart contract on Ethereum Sepolia and permanently anchored — immutable and timestamped.</div>
      </div>

      <div class="step-item">
        <div class="step-circle">
          <span class="step-n">04</span>
          <span class="step-icon">✅</span>
        </div>
        <div class="step-title">Instant Verification</div>
        <div class="step-desc">Any employer enters the certificate ID and receives a cryptographic verification result within seconds, no account needed.</div>
      </div>

    </div>
  </div>
</section>


<!-- ══════════════════════════════
     TECH STACK
══════════════════════════════ -->
<section id="tech" class="tech-section">
  <div class="section-inner">
    <div class="section-header section-header-center fade-up">
      <span class="section-tag">Technology</span>
      <h2 class="section-heading">Built on Proven Foundations</h2>
      <p class="section-desc">
        A carefully chosen stack combining battle-tested backend infrastructure with modern blockchain tooling.
      </p>
    </div>

    <div class="tech-grid fade-up">
      <div class="tech-pill"><span class="tech-dot"></span>Laravel PHP</div>
      <div class="tech-pill"><span class="tech-dot"></span>Ethereum Sepolia</div>
      <div class="tech-pill"><span class="tech-dot emerald"></span>Solidity Smart Contracts</div>
      <div class="tech-pill"><span class="tech-dot"></span>MySQL</div>
      <div class="tech-pill"><span class="tech-dot emerald"></span>Keccak-256</div>
      <div class="tech-pill"><span class="tech-dot"></span>Web3.php</div>
      <div class="tech-pill"><span class="tech-dot amber"></span>REST API</div>
      <div class="tech-pill"><span class="tech-dot"></span>Hybrid Off-chain / On-chain</div>
    </div>
  </div>
</section>


<!-- ══════════════════════════════
     CTA BANNER
══════════════════════════════ -->
<section class="cta-section fade-up">
  <div class="cta-card">
    <div class="cta-glow"></div>
    <div class="cta-inner">
      <h2 class="cta-heading">Ready to issue your first certificate?</h2>
      <p class="cta-sub">
        Join the universities already securing academic credentials on the blockchain — transparent, permanent, and instantly verifiable.
      </p>
      <div class="cta-actions">
        <a href="/login" class="btn btn-white">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M2 9 12 4l10 5-10 5L2 9z"/><path d="M6 11v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"/></svg>
          Issue a Certificate
        </a>
        <a href="/verify" class="btn btn-outline-white">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z"/><path d="M9 12l2 2 4-4"/></svg>
          Verify a Certificate
        </a>
      </div>
    </div>
  </div>
</section>


<!-- ══════════════════════════════
     FOOTER
══════════════════════════════ -->
<footer>
  <div class="footer-inner">
    <div>
      <a href="#" class="footer-brand">
        <svg width="28" height="28" viewBox="0 0 32 32" fill="none">
          <rect width="32" height="32" rx="8" fill="#EFF5FF"/>
          <path d="M16 4L6 8.5v7.5c0 6.3 4.3 10.9 10 11.5 5.7-.6 10-5.2 10-11.5V8.5L16 4z" stroke="#2563EB" stroke-width="1.8" stroke-linejoin="round" fill="#DBE7FE"/>
          <path d="M12 16l3 3 5-5" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="footer-brand-name">CertChain</span>
      </a>
      <p class="footer-desc">
        A unified platform for Palestinian universities to issue and verify academic certificates on the blockchain.
      </p>
    </div>

    <ul class="footer-links">
      <li><a href="#features">Features</a></li>
      <li><a href="#how">How It Works</a></li>
      <li><a href="#tech">Technology</a></li>
      <li><a href="/verify">Verify</a></li>
      <li><a href="/login">Sign In</a></li>
    </ul>
  </div>

  <p class="footer-copy">© 2024 CertChain Palestine 🇵🇸 — Securing Academic Credentials on the Blockchain</p>
</footer>


<!-- ══════════════════════════════
     JS — Scroll Animations
══════════════════════════════ -->
<script>
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        observer.unobserve(e.target); // fire once
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

  // Navbar scroll shadow
  const navbar = document.querySelector('.navbar');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 10) {
      navbar.style.boxShadow = '0 2px 16px rgba(15,23,42,0.08)';
    } else {
      navbar.style.boxShadow = 'none';
    }
  });
</script>

</body>
</html>
