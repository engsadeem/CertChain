@extends('layouts.main-dashboard')

@section('title', 'CertChain - Certificate Details')

@section('content')
  <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;">
    <div>
      <div style="font-size:18px;font-weight:700;">Certificate details</div>
      <div style="font-size:13px;color:var(--text-3);margin-top:4px;">Review identity, issuer, document, and proof details before approving the certificate.</div>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
      <a href="{{ route('dashboard.certificates.index') }}" class="btn btn-secondary btn-sm">Back to list</a>
      <a href="{{ route('dashboard.verify') }}?hash={{ urlencode($certificate->keccak256_hash) }}" class="btn btn-ghost btn-sm">Check authenticity</a>
    </div>
  </div>

  @if(session('success'))
    <div class="card" style="padding:18px;margin-bottom:20px;background:#ECFDF5;border:1px solid #D1FAE5;color:#166534;">
      {{ session('success') }}
    </div>
  @endif

  <div class="two-col" style="gap:20px;">
    <div class="card" style="padding:24px;">
      <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px;">
        <div>
          <div style="font-size:15px;font-weight:600;">Certificate ID</div>
          <div style="font-size:13px;color:var(--text-3);">{{ $certificate->certificate_id }}</div>
        </div>
        <span class="badge {{ $certificate->status === 'issued' ? 'badge-success' : ($certificate->status === 'pending' ? 'badge-warning' : 'badge-error') }}">
          {{ ucfirst($certificate->status) }}
        </span>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
        <div>
          <div style="font-size:13px;color:var(--text-4);margin-bottom:6px;">Student name</div>
          <div style="font-weight:600;">{{ trim(($certificate->student->first_name ?? '') . ' ' . ($certificate->student->last_name ?? '')) ?: 'Unknown' }}</div>
        </div>
        <div>
          <div style="font-size:13px;color:var(--text-4);margin-bottom:6px;">Student ID</div>
          <div style="font-weight:600;">{{ $certificate->student->student_number ?? 'N/A' }}</div>
        </div>
        <div>
          <div style="font-size:13px;color:var(--text-4);margin-bottom:6px;">University</div>
          <div style="font-weight:600;">{{ $certificate->issuedBy->name ?? 'N/A' }}</div>
        </div>
        <div>
          <div style="font-size:13px;color:var(--text-4);margin-bottom:6px;">Degree</div>
          <div style="font-weight:600;">{{ $certificate->student->degree_level ?? 'N/A' }}</div>
        </div>
        <div>
          <div style="font-size:13px;color:var(--text-4);margin-bottom:6px;">Graduation</div>
          <div style="font-weight:600;">{{ optional($certificate->student->graduation_date)->format('M d, Y') ?? 'N/A' }}</div>
        </div>
        <div>
          <div style="font-size:13px;color:var(--text-4);margin-bottom:6px;">Issued at</div>
          <div style="font-weight:600;">{{ $certificate->created_at->format('M d, Y') }}</div>
        </div>
      </div>

      @php
        $etherscanBase = rtrim(config('blockchain.etherscan_base_url', 'https://sepolia.etherscan.io'), '/');
        $txUrl = $certificate->tx_hash && !str_starts_with($certificate->tx_hash, 'local-') ? $etherscanBase . '/tx/' . $certificate->tx_hash : null;
        $contractUrl = $certificate->contract_address && $certificate->contract_address !== 'local-dev' ? $etherscanBase . '/address/' . $certificate->contract_address : null;
      @endphp

      <details class="proof-details" style="margin-top:24px;">
        <summary>Blockchain proof details</summary>
        <div class="proof-body">
          <div class="proof-row">
            <div class="proof-label">Keccak-256 fingerprint</div>
            <div class="proof-value">{{ $certificate->keccak256_hash }}</div>
          </div>
          <div class="proof-row">
            <div class="proof-label">Transaction hash</div>
            <div class="proof-value">
              @if($txUrl)
                <a href="{{ $txUrl }}" target="_blank" rel="noopener">{{ $certificate->tx_hash }}</a>
              @else
                {{ $certificate->tx_hash }}
              @endif
            </div>
          </div>
          <div class="proof-row">
            <div class="proof-label">Block number</div>
            <div class="proof-value">{{ $certificate->blockchainRecord->block_number ?? 'Pending / unavailable' }}</div>
          </div>
          <div class="proof-row">
            <div class="proof-label">Smart contract</div>
            <div class="proof-value">
              @if($contractUrl)
                <a href="{{ $contractUrl }}" target="_blank" rel="noopener">{{ $certificate->contract_address }}</a>
              @else
                {{ $certificate->contract_address }}
              @endif
            </div>
          </div>
        </div>
      </details>

      @if(auth()->check() && auth()->user()->role === 'admin')
        <form method="POST" action="{{ route('dashboard.certificates.approve', $certificate) }}" style="margin-top:24px;" onsubmit="return confirm('Approve this certificate? This confirms that the student identity, issuer, attached PDF, and proof details have been reviewed.');">
          @csrf
          <div style="padding:16px;border:1px solid var(--border);border-radius:12px;background:var(--slate-50);margin-bottom:14px;">
            <div style="font-size:14px;font-weight:700;margin-bottom:10px;">Approval checklist</div>
            <div style="display:grid;gap:8px;font-size:13px;color:var(--text-2);">
              <label style="display:flex;gap:8px;align-items:flex-start;">
                <input type="checkbox" checked disabled style="margin-top:2px;">
                <span>Student identity and certificate ID are visible.</span>
              </label>
              <label style="display:flex;gap:8px;align-items:flex-start;">
                <input type="checkbox" checked disabled style="margin-top:2px;">
                <span>Issuing institution and degree details are present.</span>
              </label>
              <label style="display:flex;gap:8px;align-items:flex-start;">
                <input type="checkbox" {{ $certificate->file_url ? 'checked' : '' }} disabled style="margin-top:2px;">
                <span>Attached PDF is available for review.</span>
              </label>
              @if($certificate->status !== 'issued')
                <label style="display:flex;gap:8px;align-items:flex-start;font-weight:600;color:var(--text-1);">
                  <input id="approval-confirm-{{ $certificate->id }}" type="checkbox" style="margin-top:2px;" onchange="document.getElementById('approve-cert-btn-{{ $certificate->id }}').disabled = !this.checked;">
                  <span>I reviewed the record and confirm this certificate can be approved.</span>
                </label>
              @endif
            </div>
          </div>
          <button id="approve-cert-btn-{{ $certificate->id }}" type="submit" class="btn btn-success btn-block" {{ $certificate->status === 'issued' ? 'disabled' : 'disabled' }}>
            {{ $certificate->status === 'issued' ? 'Already approved' : 'Confirm approval' }}
          </button>
        </form>
      @endif
    </div>

    <div class="card" style="padding:24px;">
      <div style="font-size:15px;font-weight:600;margin-bottom:14px;">Verifier record</div>
      @if($latestVerification)
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
          <div>
            <div style="font-size:13px;color:var(--text-4);margin-bottom:6px;">Verifier name</div>
            <div style="font-weight:600;">{{ $latestVerification->verifier_name }}</div>
          </div>
          <div>
            <div style="font-size:13px;color:var(--text-4);margin-bottom:6px;">Organization</div>
            <div style="font-weight:600;">{{ $latestVerification->verifier_org }}</div>
          </div>
          <div>
            <div style="font-size:13px;color:var(--text-4);margin-bottom:6px;">Email</div>
            <div style="font-weight:600;">{{ $latestVerification->verifier_email }}</div>
          </div>
          <div>
            <div style="font-size:13px;color:var(--text-4);margin-bottom:6px;">Verified at</div>
            <div style="font-weight:600;">{{ optional($latestVerification->verified_at)->format('M d, Y H:i') ?? 'N/A' }}</div>
          </div>
          <div style="grid-column:span 2;">
            <div style="font-size:13px;color:var(--text-4);margin-bottom:6px;">Verification status</div>
            <div class="badge {{ $latestVerification->is_valid ? 'badge-success' : 'badge-error' }}" style="display:inline-flex;align-items:center;gap:6px;">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                @if($latestVerification->is_valid)
                  <path d="M20 6 9 17l-5-5"/>
                @else
                  <path d="M18 6 6 18M6 6l12 12"/>
                @endif
              </svg>
              {{ $latestVerification->is_valid ? 'Valid' : 'Invalid' }}
            </div>
          </div>
          <div style="grid-column:span 2;">
            <div style="font-size:13px;color:var(--text-4);margin-bottom:6px;">IP address</div>
            <div style="font-weight:600;">{{ $latestVerification->ip_address }}</div>
          </div>
        </div>
      @else
        <div style="font-size:13px;color:var(--text-3);">No verifier record found for this certificate yet.</div>
      @endif
    </div>
  </div>

  <div class="card" style="margin-top:24px;padding:24px;">
    <div style="font-size:15px;font-weight:600;margin-bottom:14px;">Attached PDF Document</div>
    @if($certificate->file_url)
      <iframe src="{{ $certificate->file_url }}" width="100%" height="700" style="border:1px solid var(--border);border-radius:16px;"></iframe>
      <div style="margin-top:16px;display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ $certificate->file_url }}" target="_blank" class="btn btn-secondary btn-sm">Open PDF in new tab</a>
      </div>
    @else
      <div style="font-size:13px;color:var(--text-3);">No attached PDF is available for this certificate.</div>
    @endif
  </div>

@if(!empty($certificate->qr_path))
    <div style="margin-top: 24px; padding: 20px; background: #fff; border-radius: 14px; border: 1px solid #e5e7eb;">
        <h3 style="margin-bottom: 12px;">Certificate QR Code</h3>

        <p style="color:#6b7280; margin-bottom: 14px;">
            Scan this QR code to verify the certificate from the public verification page.
        </p>

        <img
            src="{{ route('public.files.show', ['path' => $certificate->qr_path]) }}"
            alt="Certificate QR Code"
            style="width:180px; height:180px; border:1px solid #e5e7eb; padding:8px; border-radius:10px;"
        >

        <div style="margin-top: 12px;">
            <a href="{{ route('public.verify.show', ['identifier' => $certificate->certificate_id]) }}" target="_blank">
                Open public verification page
            </a>
        </div>
    </div>
@endif

@endsection
