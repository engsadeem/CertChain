@extends('layouts.main-dashboard')

@section('title', 'CertChain - Certificates')

@section('content')
  <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;">
    <div>
      <div style="font-size:18px;font-weight:700;">All Certificates</div>
      <div style="font-size:13px;color:var(--text-3);margin-top:4px;">Browse every issued certificate and open details for verification.</div>
    </div>
    <a href="{{ route('dashboard.add-certificate') }}" class="btn btn-primary btn-sm">Add certificate</a>
  </div>

  <div class="card table-card" style="padding:24px;">
    <table>
      <thead>
        <tr>
          <th>Certificate ID</th><th>Student</th><th>Degree</th><th>Issued</th><th>Status</th><th></th>
        </tr>
      </thead>
      <tbody id="cert-table-body" data-server-rendered="true">
        @forelse($certificates as $certificate)
          <tr>
            <td><span class="cert-id">{{ $certificate->certificate_id }}</span></td>
            <td>
              <div class="student-cell">
                <div class="avatar">{{ strtoupper(substr($certificate->student->first_name ?? '', 0, 1) . substr($certificate->student->last_name ?? '', 0, 1)) }}</div>
                <span style="font-weight:500;">{{ trim(($certificate->student->first_name ?? '') . ' ' . ($certificate->student->last_name ?? '')) ?: 'Unknown' }}</span>
              </div>
            </td>
            <td style="color:var(--text-2);">{{ $certificate->student->degree_level ?? 'N/A' }}</td>
            <td style="color:var(--text-2);">{{ $certificate->created_at->format('M d, Y') }}</td>
            <td>
              <span class="badge {{ $certificate->status === 'issued' ? 'badge-success' : ($certificate->status === 'pending' ? 'badge-warning' : 'badge-error') }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                  @if($certificate->status === 'issued')
                    <path d="M20 6 9 17l-5-5"/>
                  @elseif($certificate->status === 'pending')
                    <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
                  @else
                    <path d="M18 6 6 18M6 6l12 12"/>
                  @endif
                </svg>
                {{ ucfirst($certificate->status) }}
              </span>
            </td>
            <td style="text-align:right;">
              <a href="{{ route('dashboard.certificates.show', $certificate) }}" class="icon-btn" aria-label="View certificate details">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="padding:24px;text-align:center;color:var(--text-3);">No certificates found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div style="margin-top:18px;display:flex;justify-content:flex-end;">
      {{ $certificates->links() }}
    </div>
  </div>
@endsection
