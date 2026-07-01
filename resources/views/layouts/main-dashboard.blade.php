<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', config('app.name', 'CertChain'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --blue-50: #EFF5FF;
            --blue-100: #DBE7FE;
            --blue-200: #BFD3FE;
            --blue-500: #3B7DF7;
            --blue-600: #2563EB;
            --blue-700: #1D4ED8;
            --emerald-50: #ECFDF5;
            --emerald-100: #D1FAE5;
            --emerald-500: #10B981;
            --emerald-600: #059669;
            --emerald-700: #047857;
            --amber-50: #FFFBEB;
            --amber-100: #FEF3C7;
            --amber-500: #F59E0B;
            --amber-600: #D97706;
            --rose-50: #FFF1F2;
            --rose-100: #FFE4E6;
            --rose-500: #F43F5E;
            --rose-600: #E11D48;
            --slate-50: #F8FAFC;
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
            --shadow-xs: 0 1px 2px rgba(15, 23, 42, .04);
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, .06), 0 1px 2px rgba(15, 23, 42, .04);
            --shadow-md: 0 4px 12px rgba(15, 23, 42, .08), 0 1px 2px rgba(15, 23, 42, .04);
            --font: 'Inter', -apple-system, sans-serif;
            --display: 'Playfair Display', Georgia, serif;
            --mono: 'JetBrains Mono', monospace;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text-1);
            -webkit-font-smoothing: antialiased;
            letter-spacing: -.005em;
            height: 100vh;
            overflow: hidden;
            display: flex;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 248px;
            flex-shrink: 0;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 4px 10px 24px;
            text-decoration: none;
        }

        .sidebar-brand svg {
            flex-shrink: 0;
        }

        .sidebar-brand-name {
            font-weight: 700;
            font-size: 16px;
            color: var(--text-1);
            letter-spacing: -.02em;
        }

        .sidebar-section-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-4);
            letter-spacing: .06em;
            padding: 8px 10px 6px;
            text-transform: uppercase;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            color: var(--text-2);
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }

        .nav-item:hover {
            background: var(--slate-100);
            color: var(--text-1);
        }

        .nav-item.active {
            background: var(--blue-50);
            color: var(--blue-700);
            font-weight: 600;
        }

        .nav-item .badge-new {
            margin-left: auto;
            height: 18px;
            padding: 0 6px;
            background: var(--blue-50);
            color: var(--blue-700);
            border-radius: 99px;
            font-size: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 14px;
            background: linear-gradient(180deg, #EFF5FF, #FFFFFF);
            border: 1px solid var(--blue-100);
            border-radius: 14px;
        }

        .sf-head {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .sf-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--blue-600);
            display: grid;
            place-items: center;
            color: #fff;
            flex-shrink: 0;
        }

        .sf-title {
            font-weight: 600;
            font-size: 13px;
        }

        .sf-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: var(--text-2);
            margin-bottom: 4px;
        }

        .sf-online {
            display: flex;
            align-items: center;
            gap: 4px;
            color: var(--emerald-600);
        }

        .sf-dot {
            width: 6px;
            height: 6px;
            border-radius: 99px;
            background: currentColor;
        }

        .sf-block {
            font-size: 11px;
            color: var(--text-3);
        }

        /* ── MAIN ── */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* ── TOPBAR ── */
        .topbar {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px 32px;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            flex-shrink: 0;
        }

        .topbar-title-wrap {
            flex: 1;
            min-width: 0;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 600;
            letter-spacing: -.02em;
        }

        .topbar-sub {
            font-size: 13px;
            color: var(--text-3);
            margin-top: 2px;
        }

        .search-wrap {
            position: relative;
            width: 280px;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-4);
        }

        .search-input {
            width: 100%;
            height: 38px;
            padding: 0 14px 0 38px;
            background: var(--bg);
            border: 1px solid var(--border-strong);
            border-radius: var(--radius);
            font-family: var(--font);
            font-size: 13px;
            color: var(--text-1);
            outline: none;
            transition: all .15s;
        }

        .search-input:focus {
            border-color: var(--blue-500);
            box-shadow: 0 0 0 3px rgba(59, 125, 247, .1);
            background: var(--surface);
        }

        .topbar-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--surface);
            display: grid;
            place-items: center;
            color: var(--text-2);
            cursor: pointer;
            position: relative;
            transition: all .15s;
        }

        .topbar-btn:hover {
            background: var(--slate-50);
        }

        .notif-dot {
            position: absolute;
            top: 8px;
            right: 9px;
            width: 7px;
            height: 7px;
            border-radius: 99px;
            background: var(--rose-500);
            border: 2px solid #fff;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-left: 12px;
            border-left: 1px solid var(--border);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 99px;
            background: linear-gradient(135deg, #2563EB, #6FA0F8);
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 600;
            font-size: 13px;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            line-height: 1.2;
        }

        .user-role {
            font-size: 11px;
            color: var(--text-3);
        }

        /* ── CONTENT ── */
        .content {
            flex: 1;
            overflow-y: auto;
            padding: 28px 32px 40px;
        }

        .content::-webkit-scrollbar {
            width: 4px;
        }

        .content::-webkit-scrollbar-thumb {
            background: var(--slate-200);
            border-radius: 4px;
        }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow-sm);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: grid;
            place-items: center;
        }

        .stat-delta {
            font-size: 12px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 99px;
        }

        .delta-pos {
            color: var(--emerald-600);
            background: var(--emerald-50);
        }

        .delta-neg {
            color: var(--rose-600);
            background: var(--rose-50);
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-3);
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -.02em;
        }

        /* ── CHART + QUICK ACTIONS ── */
        .mid-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
        }

        .card-body {
            padding: 24px;
        }

        .card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 15px;
            font-weight: 600;
        }

        .card-sub {
            font-size: 12px;
            color: var(--text-3);
            margin-top: 2px;
        }

        .time-tabs {
            display: flex;
            gap: 4px;
            padding: 3px;
            background: var(--slate-100);
            border-radius: 8px;
        }

        .time-tab {
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all .15s;
            background: transparent;
            color: var(--text-3);
            font-family: var(--font);
        }

        .time-tab.active {
            background: #fff;
            color: var(--text-1);
            box-shadow: var(--shadow-xs);
        }

        /* ── QUICK ACTIONS ── */
        .qa-primary {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px;
            background: linear-gradient(135deg, #2563EB, #3B7DF7);
            color: #fff;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            width: 100%;
            text-align: left;
            box-shadow: 0 4px 12px rgba(37, 99, 235, .25);
            margin-bottom: 10px;
            text-decoration: none;
            transition: all .18s;
        }

        .qa-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, .35);
        }

        .qa-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .2);
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .qa-text {
            flex: 1;
        }

        .qa-title {
            font-weight: 600;
            font-size: 14px;
        }

        .qa-desc {
            font-size: 12px;
            opacity: .85;
            margin-top: 1px;
        }

        .qa-secondary {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px;
            background: var(--surface);
            border: 1px solid var(--border-strong);
            border-radius: 12px;
            cursor: pointer;
            width: 100%;
            text-align: left;
            text-decoration: none;
            transition: all .15s;
        }

        .qa-secondary:hover {
            background: var(--slate-50);
        }

        .qa-sec-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .qa-metrics {
            padding: 14px;
            background: var(--slate-50);
            border-radius: 10px;
            margin-top: 10px;
        }

        .qa-metric-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .qa-metric-row:last-child {
            margin-bottom: 0;
        }

        .qa-metric-label {
            color: var(--text-2);
            font-weight: 500;
        }

        .qa-metric-val {
            font-weight: 600;
        }

        /* ── TABLE ── */
        .table-card {
            overflow: hidden;
        }

        .table-head-row {
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: var(--slate-50);
        }

        th {
            text-align: left;
            padding: 10px 24px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .06em;
            color: var(--text-3);
            text-transform: uppercase;
        }

        td {
            padding: 14px 24px;
            border-top: 1px solid var(--border);
            font-size: 13px;
        }

        tr:hover td {
            background: var(--slate-50);
        }

        .cert-id {
            font-family: var(--mono);
            font-size: 12px;
            color: var(--text-2);
        }

        .student-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 30px;
            height: 30px;
            border-radius: 99px;
            background: var(--slate-100);
            display: grid;
            place-items: center;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-2);
            flex-shrink: 0;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            height: 24px;
            padding: 0 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge svg {
            width: 11px;
            height: 11px;
        }

        .badge-success {
            background: var(--emerald-50);
            color: var(--emerald-700);
        }

        .badge-warning {
            background: var(--amber-50);
            color: var(--amber-600);
        }

        .badge-error {
            background: var(--rose-50);
            color: var(--rose-600);
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 99px;
            background: currentColor;
        }

        .icon-btn {
            background: transparent;
            border: none;
            color: var(--text-3);
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
        }

        .icon-btn:hover {
            background: var(--slate-100);
            color: var(--text-1);
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            height: 38px;
            padding: 0 14px;
            border-radius: var(--radius);
            font-family: var(--font);
            font-size: 13.5px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
            letter-spacing: -.01em;
            white-space: nowrap;
        }

        .btn-sm {
            height: 32px;
            padding: 0 12px;
            font-size: 12.5px;
            border-radius: 8px;
        }

        .btn-block {
            width: 100%;
            justify-content: center;
        }

        .btn-primary {
            background: var(--blue-600);
            color: #fff;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .12) inset, 0 2px 4px rgba(37, 99, 235, .2);
        }

        .btn-primary:hover {
            background: var(--blue-700);
        }

        .btn-secondary {
            background: var(--surface);
            color: var(--text-1);
            border: 1px solid var(--border-strong);
            box-shadow: var(--shadow-xs);
        }

        .btn-secondary:hover {
            background: var(--slate-50);
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-2);
        }

        .btn-ghost:hover {
            background: var(--slate-100);
            color: var(--text-1);
        }

        .btn-danger {
            background: var(--rose-50);
            color: var(--rose-600);
            border: 1px solid var(--rose-100);
        }

        .btn-danger:hover {
            background: var(--rose-100);
        }

        /* ── FORM FIELDS ── */
        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 18px;
        }

        .field-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-2);
        }

        .input,
        .select,
        .textarea {
            width: 100%;
            height: 42px;
            padding: 0 14px;
            background: var(--surface);
            border: 1.5px solid var(--border-strong);
            border-radius: var(--radius);
            font-family: var(--font);
            font-size: 13px;
            color: var(--text-1);
            outline: none;
            transition: all .15s;
        }

        .input:focus,
        .select:focus,
        .textarea:focus {
            border-color: var(--blue-500);
            box-shadow: 0 0 0 4px rgba(59, 125, 247, .1);
        }

        .textarea {
            height: auto;
            padding: 12px 14px;
            resize: vertical;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
        }

        /* ── SEARCH DROPDOWN ── */
        .search-wrap {
            position: relative;
        }

        .search-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            min-width: 320px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            z-index: 300;
            overflow: hidden;
            display: none;
        }

        .search-dropdown.open {
            display: block;
        }

        .search-group-label {
            font-size: 10.5px;
            font-weight: 600;
            color: var(--text-4);
            letter-spacing: .07em;
            text-transform: uppercase;
            padding: 10px 14px 4px;
        }

        .search-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            cursor: pointer;
            transition: background .12s;
            text-decoration: none;
            color: inherit;
        }

        .search-item:hover,
        .search-item.focused {
            background: var(--slate-50);
        }

        .search-item-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .search-item-title {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-1);
        }

        .search-item-sub {
            font-size: 11px;
            color: var(--text-3);
            margin-top: 1px;
        }

        .search-empty {
            padding: 24px 14px;
            text-align: center;
            font-size: 13px;
            color: var(--text-3);
        }

        .search-footer {
            padding: 10px 14px;
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            color: var(--blue-600);
            cursor: pointer;
        }

        .search-footer:hover {
            background: var(--blue-50);
        }

        .search-loading {
            padding: 16px 14px;
            text-align: center;
        }

        .search-spinner {
            width: 18px;
            height: 18px;
            border: 2px solid var(--blue-100);
            border-top-color: var(--blue-600);
            border-radius: 50%;
            animation: spin .7s linear infinite;
            margin: 0 auto;
        }

        /* ── NOTIFICATION PANEL ── */
        .notif-wrap {
            position: relative;
        }

        .notif-panel {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 340px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            z-index: 300;
            display: none;
            overflow: hidden;
        }

        .notif-panel.open {
            display: block;
        }

        .notif-panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
        }

        .notif-panel-title {
            font-size: 14px;
            font-weight: 600;
        }

        .notif-mark-read {
            font-size: 12px;
            font-weight: 500;
            color: var(--blue-600);
            cursor: pointer;
            border: none;
            background: transparent;
        }

        .notif-mark-read:hover {
            text-decoration: underline;
        }

        .notif-body-area {
            max-height: 340px;
            overflow-y: auto;
        }

        .notif-body-area::-webkit-scrollbar {
            width: 3px;
        }

        .notif-body-area::-webkit-scrollbar-thumb {
            background: var(--slate-200);
            border-radius: 4px;
        }

        .notif-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
            transition: background .12s;
        }

        .notif-item:last-child {
            border-bottom: none;
        }

        .notif-item:hover {
            background: var(--slate-50);
        }

        .notif-item.unread {
            background: #F0F5FF;
        }

        .notif-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .notif-title {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-1);
            margin-bottom: 2px;
        }

        .notif-body-text {
            font-size: 12px;
            color: var(--text-3);
            line-height: 1.4;
        }

        .notif-time {
            font-size: 11px;
            color: var(--text-4);
            margin-top: 4px;
        }

        .notif-unread-dot {
            width: 7px;
            height: 7px;
            border-radius: 99px;
            background: var(--blue-500);
            flex-shrink: 0;
            margin-top: 4px;
        }

        .notif-empty {
            padding: 32px 16px;
            text-align: center;
            color: var(--text-3);
            font-size: 13px;
        }

        .notif-panel-footer {
            padding: 10px 16px;
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            color: var(--blue-600);
            cursor: pointer;
        }

        .notif-panel-footer:hover {
            background: var(--blue-50);
        }

        .notif-count-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            min-width: 16px;
            height: 16px;
            border-radius: 99px;
            background: var(--rose-500);
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            display: none;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
            padding: 0 3px;
        }

        .notif-count-badge.visible {
            display: flex;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible,
        summary:focus-visible,
        [tabindex]:focus-visible {
            outline: 2px solid var(--blue-500);
            outline-offset: 2px;
        }

        button:disabled,
        .btn:disabled {
            opacity: .65;
            cursor: not-allowed;
        }

        .proof-details {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--slate-50);
        }

        .proof-details summary {
            cursor: pointer;
            padding: 13px 14px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-1);
        }

        .proof-body {
            border-top: 1px solid var(--border);
            padding: 14px;
            display: grid;
            gap: 12px;
        }

        .proof-row {
            display: grid;
            grid-template-columns: 150px minmax(0, 1fr);
            gap: 12px;
            font-size: 12px;
        }

        .proof-label {
            font-weight: 700;
            color: var(--text-4);
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .proof-value {
            font-family: var(--mono);
            color: var(--text-2);
            overflow-wrap: anywhere;
        }

        .large-grid {
            display: grid;
            gap: 16px;
        }

        [dir="rtl"] th,
        [dir="rtl"] td,
        [dir="rtl"] .nav-item,
        [dir="rtl"] .settings-nav-item {
            text-align: right;
        }

        [dir="rtl"] .search-icon,
        [dir="rtl"] .input-icon {
            left: auto;
            right: 12px;
        }

        [dir="rtl"] .search-input,
        [dir="rtl"] .input.icon-pad,
        [dir="rtl"] .verify-input {
            padding-left: 14px;
            padding-right: 40px;
        }

        @media (max-width: 1024px) {
            .stats-grid,
            .users-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .mid-grid,
            .two-col,
            .profile-layout,
            .settings-layout {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 900px) {
            body {
                display: block;
                height: auto;
                min-height: 100vh;
                overflow: auto;
            }

            .sidebar {
                width: 100%;
                padding: 12px;
                border-right: none;
                border-bottom: 1px solid var(--border);
            }

            .sidebar-brand {
                padding: 4px 6px 12px;
            }

            .sidebar-section-label,
            .sidebar-footer {
                display: none;
            }

            .sidebar nav {
                display: flex !important;
                flex-direction: row !important;
                gap: 6px !important;
                overflow-x: auto;
                padding-bottom: 4px;
            }

            .nav-item {
                min-height: 44px;
                white-space: nowrap;
            }

            .main {
                min-height: calc(100vh - 118px);
            }

            .topbar {
                padding: 16px;
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .topbar-title-wrap {
                flex-basis: 100%;
            }

            .search-wrap {
                order: 2;
                width: min(100%, 420px);
                flex: 1 1 260px;
            }

            .topbar-user {
                max-width: 100%;
                min-width: 0;
            }

            .content {
                padding: 18px;
            }

            .table-card {
                overflow-x: auto;
            }

            table {
                min-width: 720px;
            }

            .modal {
                max-width: min(480px, calc(100vw - 28px));
                padding: 24px;
            }
        }

        @media (max-width: 640px) {
            .stats-grid,
            .users-stats,
            .grid-2,
            .grid-3 {
                grid-template-columns: 1fr !important;
            }

            .topbar-btn,
            .btn,
            .icon-btn,
            .settings-nav-item,
            .tab-pill,
            .tab-btn {
                min-height: 44px;
            }

            .table-head-row,
            .page-header {
                align-items: flex-start !important;
                flex-direction: column;
            }

            .proof-row {
                grid-template-columns: 1fr;
                gap: 4px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        @yield('style')
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <a href="{{ route('index') }}" class="sidebar-brand">
            <svg width="28" height="28" viewBox="0 0 32 32" fill="none">
                <rect width="32" height="32" rx="8" fill="#EFF5FF" />
                <path d="M16 4L6 8.5v7.5c0 6.3 4.3 10.9 10 11.5 5.7-.6 10-5.2 10-11.5V8.5L16 4z" stroke="#2563EB"
                    stroke-width="1.8" stroke-linejoin="round" fill="#DBE7FE" />
                <path d="M12 16l3 3 5-5" stroke="#2563EB" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
            <span class="sidebar-brand-name">CertChain</span>
        </a>

        <div class="sidebar-section-label">Main</div>
        <nav style="display:flex;flex-direction:column;gap:2px;">
            <a class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}"
                href="{{ route('dashboard.index') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="3" width="7" height="9" rx="1.5" />
                    <rect x="14" y="3" width="7" height="5" rx="1.5" />
                    <rect x="14" y="12" width="7" height="9" rx="1.5" />
                    <rect x="3" y="16" width="7" height="5" rx="1.5" />
                </svg>
                Dashboard
            </a>

            <a class="nav-item {{ request()->routeIs('dashboard.add-certificate') ? 'active' : '' }}"
                href="{{ route('dashboard.add-certificate') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="4" width="18" height="14" rx="2" />
                    <path d="M7 9h10M7 13h6" />
                    <circle cx="17" cy="18" r="2.5" />
                </svg>
                Certificates
            </a>
            <a class="nav-item {{ request()->routeIs('dashboard.verify') ? 'active' : '' }}"
                href="{{ route('dashboard.verify') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z" />
                    <path d="M9 12l2 2 4-4" />
                </svg>
                Verify
            </a>
            @if(auth()->check() && auth()->user()->role === 'admin')
            <a class="nav-item {{ request()->routeIs('dashboard.users') ? 'active' : '' }}"
                href="{{ route('dashboard.users') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="9" cy="8" r="3.5" />
                    <path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6" />
                    <circle cx="17" cy="9" r="2.5" />
                    <path d="M21 19.5c0-2.5-1.7-4.5-4-5" />
                </svg>
                Users
            </a>
            @endif
        </nav>

        <div class="sidebar-section-label" style="margin-top:12px;">Account</div>
        <nav style="display:flex;flex-direction:column;gap:2px;">
            <a class="nav-item {{ request()->routeIs('dashboard.profile') ? 'active' : '' }}"
                href="{{ route('dashboard.profile') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                </svg>
                Profile
            </a>
            <a class="nav-item {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}"
                href="{{ route('dashboard.settings') }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="3" />
                    <path
                        d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1A1.7 1.7 0 0 0 4.6 9a1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1A1.7 1.7 0 0 0 9 4.6A1.7 1.7 0 0 0 10 3V3a2 2 0 1 1 4 0v.1A1.7 1.7 0 0 0 15 4.6a1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1A1.7 1.7 0 0 0 19.4 9v0A1.7 1.7 0 0 0 20.9 10H21a2 2 0 1 1 0 4h-.1A1.7 1.7 0 0 0 19.4 15z" />
                </svg>
                Settings
            </a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="nav-item" style="color:var(--rose-600);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    Logout
                </button>
            </form>
        </nav>

        <div class="sidebar-footer">
            <div class="sf-head">
                <div class="sf-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="white"
                        stroke-width="2">
                        <path d="M21 7.5 12 12 3 7.5M12 12v9.5M21 7.5v9L12 21l-9-4.5v-9L12 3l9 4.5z" />
                    </svg>
                </div>
                <span class="sf-title">Proof service</span>
            </div>
            <div class="sf-row">
                <span>Verification records</span>
                <span class="sf-online"><span class="sf-dot"></span>Online</span>
            </div>
            <div class="sf-block">Ready for authenticity checks</div>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main">
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-title-wrap">
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                <div class="topbar-sub">@yield('page-subtitle', '')</div>
            </div>
            <div class="search-wrap">
                <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7" />
                    <path d="m20 20-3.5-3.5" />
                </svg>
                <input class="search-input" id="search-input" aria-label="Search certificates and users" placeholder="Search certificates, users…"
                    autocomplete="off" />
                <div class="search-dropdown" id="search-dropdown"></div>
            </div>
            <div class="notif-wrap">
                <button type="button" class="topbar-btn" id="notif-btn" aria-label="Open notifications" aria-expanded="false" aria-controls="notif-panel">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M6 8a6 6 0 1 1 12 0c0 7 3 9 3 9H3s3-2 3-9z" />
                        <path d="M10 21a2 2 0 0 0 4 0" />
                    </svg>
                    <span class="notif-count-badge" id="notif-count">3</span>
                </button>
                <div class="notif-panel" id="notif-panel">
                    <div class="notif-panel-head">
                        <span class="notif-panel-title">Notifications</span>
                        <button class="notif-mark-read" id="mark-all-read">Mark all read</button>
                    </div>
                    <div class="notif-body-area" id="notif-body">
                        <div class="notif-empty">Loading…</div>
                    </div>
                    <div class="notif-panel-footer" onclick="window.location='{{ route('dashboard.index') }}'">View
                        all activity →</div>

                </div>
            </div>
            <div class="topbar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                </div>
                <div>
                    <div class="user-name">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="user-role">{{ auth()->user()->email ?? '' }}</div>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/web3@1.10.0/dist/web3.min.js"></script>
    <script>
        // Draw bar chart (dashboard only)
        const barsEl = document.getElementById('bars');
        if (barsEl) {
            const heights = [60, 80, 55, 90, 70, 85, 110, 95, 75, 100, 120, 95, 85, 130, 110, 140, 120, 100, 135, 150, 130,
                145, 160, 140, 155, 170, 145, 160, 175, 165
            ];
            heights.forEach((h, i) => {
                const x = 5 + i * 22;
                const rect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
                rect.setAttribute('x', x);
                rect.setAttribute('y', 170 - h);
                rect.setAttribute('width', '13');
                rect.setAttribute('height', h);
                rect.setAttribute('rx', '3');
                rect.setAttribute('fill', i === 22 ? '#1D4ED8' : 'url(#barG)');
                barsEl.appendChild(rect);
            });
        }

        function setTab(el) {
            el.closest('.time-tabs').querySelectorAll('.time-tab').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
        }

        // Dashboard cert table
        const tbody = document.getElementById('cert-table-body');
        if (tbody && tbody.dataset.serverRendered !== 'true') {
            const certs = [{
                    id: 'CERT-UCAS-2026-0042',
                    name: 'أحمد محمود الشيخ',
                    initials: 'أش',
                    degree: 'B.Sc. Computer Science',
                    date: 'May 14, 2026',
                    status: 'Confirmed'
                },
                {
                    id: 'CERT-BIRZ-2026-0189',
                    name: 'Liam Rodríguez',
                    initials: 'LR',
                    degree: 'M.Eng. Electrical',
                    date: 'May 14, 2026',
                    status: 'Confirmed'
                },
                {
                    id: 'CERT-NAJH-2026-0037',
                    name: 'Sofia Andersson',
                    initials: 'SA',
                    degree: 'B.A. Economics',
                    date: 'May 13, 2026',
                    status: 'Pending'
                },
                {
                    id: 'CERT-POLY-2026-0211',
                    name: 'Jonas Weber',
                    initials: 'JW',
                    degree: 'Ph.D. Mathematics',
                    date: 'May 13, 2026',
                    status: 'Confirmed'
                },
                {
                    id: 'CERT-UCAS-2026-0041',
                    name: 'Amara Okafor',
                    initials: 'AO',
                    degree: 'B.Sc. Biology',
                    date: 'May 12, 2026',
                    status: 'Confirmed'
                },
                {
                    id: 'CERT-BIRZ-2026-0188',
                    name: 'Hiroshi Tanaka',
                    initials: 'HT',
                    degree: 'M.B.A.',
                    date: 'May 12, 2026',
                    status: 'Failed'
                },
            ];
            const statusMap = {
                Confirmed: ['badge-success', '<path d="M20 6 9 17l-5-5"/>'],
                Pending: ['badge-warning', '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>'],
                Failed: ['badge-error', '<path d="M18 6 6 18M6 6l12 12"/>'],
            };
            certs.forEach(c => {
                const [cls, icon] = statusMap[c.status];
                tbody.innerHTML += `
        <tr>
          <td><span class="cert-id">${c.id}</span></td>
          <td><div class="student-cell"><div class="avatar">${c.initials}</div><span style="font-weight:500;">${c.name}</span></div></td>
          <td style="color:var(--text-2);">${c.degree}</td>
          <td style="color:var(--text-2);">${c.date}</td>
          <td><span class="badge ${cls}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">${icon}</svg>${c.status}</span></td>
          <td style="text-align:right;"><button class="icon-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="19" cy="12" r="1.5"/></svg></button></td>
        </tr>`;
            });
        }

        @yield('scripts')

            // ── SEARCH ──────────────────────────────────────
            (function() {
                const input = document.getElementById('search-input');
                const dropdown = document.getElementById('search-dropdown');
                if (!input) return;

                let timer;

                input.addEventListener('input', function() {
                    clearTimeout(timer);
                    const q = this.value.trim();
                    if (q.length < 2) {
                        dropdown.classList.remove('open');
                        return;
                    }

                    dropdown.innerHTML = '<div class="search-loading"><div class="search-spinner"></div></div>';
                    dropdown.classList.add('open');

                    timer = setTimeout(() => {
                        fetch(@json(route('dashboard.search')) + '?q=' + encodeURIComponent(q), {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(r => r.json())
                            .then(renderSearch)
                            .catch(() => {
                                dropdown.innerHTML =
                                    '<div class="search-empty">Search unavailable.</div>';
                            });
                    }, 300);
                });

                input.addEventListener('keydown', e => {
                    if (e.key === 'Escape') {
                        dropdown.classList.remove('open');
                        input.blur();
                    }
                });

                document.addEventListener('click', e => {
                    if (!input.closest('.search-wrap').contains(e.target)) dropdown.classList.remove('open');
                });

                function renderSearch(data) {
                    const certs = data.certificates || [];
                    const users = data.users || [];
                    if (!certs.length && !users.length) {
                        dropdown.innerHTML = '<div class="search-empty">No results for that query.</div>';
                        dropdown.classList.add('open');
                        return;
                    }
                    let html = '';
                    if (certs.length) {
                        html += '<div class="search-group-label">Certificates</div>';
                        certs.forEach(c => {
                            const name = (c.student && c.student.name) ? c.student.name : 'Unknown';
                            const sub = (c.degree || '') + (c.issued_at ? ' · ' + c.issued_at : '');
                            html += `<a href="${@json(route('dashboard.index'))}" class="search-item">
            <div class="search-item-icon" style="background:var(--blue-50);color:var(--blue-600);">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="14" rx="2"/><path d="M7 9h10M7 13h6"/></svg>
            </div>
            <div><div class="search-item-title">${esc(name)}</div><div class="search-item-sub">${esc(sub)}</div></div>
          </a>`;
                        });
                    }
                    if (users.length) {
                        html += '<div class="search-group-label">Users</div>';
                        users.forEach(u => {
                            html += `<a href="${@json(route('dashboard.users'))}" class="search-item">
            <div class="search-item-icon" style="background:var(--emerald-50);color:var(--emerald-600);">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            </div>
            <div><div class="search-item-title">${esc(u.name)}</div><div class="search-item-sub">${esc(u.email)} · ${esc(u.role||'user')}</div></div>
          </a>`;
                        });
                    }
                    html +=
                        `<div class="search-footer" onclick="window.location='${@json(route('dashboard.search'))}'+'?q='+encodeURIComponent(document.getElementById('search-input').value)">View all results →</div>`;
                    dropdown.innerHTML = html;
                    dropdown.classList.add('open');
                }

                function esc(s) {
                    return String(s || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(
                        /"/g, '&quot;');
                }
            })();

        // ── NOTIFICATIONS ────────────────────────────────
        (function() {
            const btn = document.getElementById('notif-btn');
            const panel = document.getElementById('notif-panel');
            const body = document.getElementById('notif-body');
            const badge = document.getElementById('notif-count');
            const markBtn = document.getElementById('mark-all-read');
            if (!btn) return;

            let loaded = false;

            // Show badge if count > 0
            if (badge && parseInt(badge.textContent) > 0) badge.classList.add('visible');

            btn.addEventListener('click', e => {
                e.stopPropagation();
                panel.classList.toggle('open');
                btn.setAttribute('aria-expanded', panel.classList.contains('open') ? 'true' : 'false');
                if (panel.classList.contains('open') && !loaded) loadNotifications();
            });

            markBtn && markBtn.addEventListener('click', e => {
                e.stopPropagation();
                document.querySelectorAll('.notif-item.unread').forEach(el => el.classList.remove('unread'));
                if (badge) {
                    badge.textContent = '0';
                    badge.classList.remove('visible');
                }
                fetch(@json(route('dashboard.notifications.read-all')), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ||
                            '',
                        'Accept': 'application/json'
                    }
                }).catch(() => {});
            });

            document.addEventListener('click', e => {
                if (!btn.contains(e.target) && !panel.contains(e.target)) {
                    panel.classList.remove('open');
                    btn.setAttribute('aria-expanded', 'false');
                }
            });

            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') {
                    panel.classList.remove('open');
                    btn.setAttribute('aria-expanded', 'false');
                }
            });

            function loadNotifications() {
                body.innerHTML = '<div class="notif-empty">Loading…</div>';
                fetch(@json(route('dashboard.notifications')), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        loaded = true;
                        renderNotifications(data.notifications || []);
                        if (badge) {
                            const count = (data.notifications || []).filter(n => !n.read).length;
                            badge.textContent = count;
                            count > 0 ? badge.classList.add('visible') : badge.classList.remove('visible');
                        }
                    })
                    .catch(() => {
                        body.innerHTML = '<div class="notif-empty">Could not load notifications.</div>';
                    });
            }


            function escText(value) {
                return String(value || '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function renderNotifications(items) {
                if (!items.length) {
                    body.innerHTML = '<div class="notif-empty">You\'re all caught up ✓</div>';
                    return;
                }
                const icons = {
                    certificate: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="14" rx="2"/><path d="M7 9h10M7 13h6"/></svg>`,
                    verification: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z"/><path d="M9 12l2 2 4-4"/></svg>`,
                    user: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>`,
                    role_request: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l8 4v6c0 5-3.3 8.5-8 10-4.7-1.5-8-5-8-10V6l8-4z"/><path d="M9 12l2 2 4-4"/></svg>`,
                    error: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3 2 20h20L12 3z"/><path d="M12 10v4M12 18h.01"/></svg>`,
                };
                const colors = {
                    certificate: 'background:var(--blue-50);color:var(--blue-600)',
                    verification: 'background:var(--emerald-50);color:var(--emerald-600)',
                    user: 'background:var(--amber-50);color:var(--amber-600)',
                    role_request: 'background:var(--amber-50);color:var(--amber-600)',
                    error: 'background:var(--rose-50);color:var(--rose-600)',
                };
                body.innerHTML = items.map(n => `
        <div class="notif-item ${n.read ? '' : 'unread'}">
          <div class="notif-icon" style="${colors[n.type] || colors.certificate}">
            ${icons[n.type] || icons.certificate}
          </div>
          <div style="flex:1;min-width:0;">
            <div class="notif-title">${escText(n.title)}</div>
            <div class="notif-body-text">${escText(n.body)}</div>
            <div class="notif-time">${escText(n.time)}</div>
          </div>
          ${!n.read ? '<div class="notif-unread-dot"></div>' : ''}
        </div>
      `).join('');

                // عند ظهور request للـ admin، اجعل النوتيفيكيشن يفتح صفحة الطلبات
                document.querySelectorAll('.notif-item').forEach(item => {
                    const text = item.querySelector('.notif-title')?.textContent || '';
                    if (text.includes('New verifier request')) {
                        item.style.cursor = 'pointer';
                        item.addEventListener('click', () => {
                            window.location = @json(route('dashboard.admin.role-requests.pending'));
                        });
                    }
                });
            }
        })();
    </script>


    @yield('extra-scripts')

</body>

</html>
