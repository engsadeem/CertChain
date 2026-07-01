@extends('layouts.main-dashboard')
@section('title', 'CertChain - Dashboard')

@section('content')

    <!-- STAT CARDS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon" style="background:var(--blue-50);color:var(--blue-600);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="14" rx="2" />
                        <path d="M7 9h10M7 13h6" />
                        <circle cx="17" cy="18" r="2.5" />
                    </svg>
                </div>
                <span class="stat-delta delta-pos">+8.2%</span>
            </div>
            <div class="stat-label">Total Certificates</div>
            <div class="stat-value">12,847</div>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon" style="background:var(--emerald-50);color:var(--emerald-600);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z" />
                        <path d="M9 12l2 2 4-4" />
                    </svg>
                </div>
                <span class="stat-delta delta-pos">+12.4%</span>
            </div>
            <div class="stat-label">Verified</div>
            <div class="stat-value">11,206</div>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon" style="background:var(--amber-50);color:var(--amber-600);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 7v5l3 2" />
                    </svg>
                </div>
                <span class="stat-delta delta-neg">−3.1%</span>
            </div>
            <div class="stat-label">Pending</div>
            <div class="stat-value">184</div>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon" style="background:var(--slate-100);color:var(--slate-600);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M21 7.5 12 12 3 7.5M12 12v9.5M21 7.5v9L12 21l-9-4.5v-9L12 3l9 4.5z" />
                    </svg>
                </div>
                <span class="stat-delta delta-pos">+8.0%</span>
            </div>
            <div class="stat-label">Proof Records</div>
            <div class="stat-value">12,663</div>
        </div>
    </div>

    <!-- MID GRID -->
    <div class="large-grid">
        <!-- Recent Certificates -->
        <div class="card table-card">
            <div class="table-head-row">
                <div>
                    <div class="card-title">Recent Certificates</div>
                    <div class="card-sub" style="margin-top:2px;">Latest 6 issuances across departments</div>
                </div>
                <div style="display:flex;gap:8px;">
                    <button class="btn btn-ghost btn-sm">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M3 5h18l-7 9v6l-4-2v-4L3 5z" />
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('dashboard.certificates.index') }}" class="btn btn-secondary btn-sm">
                        View all
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14M13 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Certificate ID</th>
                        <th>Student</th>
                        <th>Degree</th>
                        <th>Issued</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="cert-table-body" data-server-rendered="true">
                    @foreach ($recentCertificates as $certificate)
                        <tr>
                            <td><span class="cert-id">{{ $certificate->certificate_id }}</span></td>
                            <td>
                                <div class="student-cell">
                                    <div class="avatar">
                                        {{ strtoupper(substr($certificate->student->first_name ?? '', 0, 1) . substr($certificate->student->last_name ?? '', 0, 1)) }}
                                    </div>
                                    <span
                                        style="font-weight:500;">{{ trim(($certificate->student->first_name ?? '') . ' ' . ($certificate->student->last_name ?? '')) ?: 'Unknown' }}</span>
                                </div>
                            </td>
                            <td style="color:var(--text-2);">{{ $certificate->student->degree_level ?? 'N/A' }}</td>
                            <td style="color:var(--text-2);">{{ $certificate->created_at->format('M d, Y') }}</td>
                            <td>
                                <span
                                    class="badge {{ $certificate->status === 'issued' ? 'badge-success' : ($certificate->status === 'pending' ? 'badge-warning' : 'badge-error') }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.2">
                                        @if ($certificate->status === 'issued')
                                            <path d="M20 6 9 17l-5-5" />
                                        @elseif($certificate->status === 'pending')
                                            <circle cx="12" cy="12" r="9" />
                                            <path d="M12 7v5l3 2" />
                                        @else
                                            <path d="M18 6 6 18M6 6l12 12" />
                                        @endif
                                    </svg>
                                    {{ ucfirst($certificate->status) }}
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <a href="{{ route('dashboard.certificates.show', $certificate) }}" class="icon-btn"
                                    aria-label="View certificate details">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
