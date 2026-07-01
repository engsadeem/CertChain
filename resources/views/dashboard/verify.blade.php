@extends('layouts.main-dashboard')

@section('title', 'CertChain - Verify Certificate')
@section('page-title', 'Verify Certificate')
@section('page-subtitle', 'Check certificate authenticity from the official record')

@section('style')
.verify-hero{text-align:center;padding:28px 0 22px;}
.hero-badge{
  display:inline-flex;align-items:center;gap:7px;
  padding:5px 13px;background:var(--blue-50);color:var(--blue-700);
  border:1px solid var(--blue-100);border-radius:99px;font-size:12px;font-weight:600;margin-bottom:14px;
}
.hero-heading{font-size:clamp(1.5rem,3vw,2rem);font-weight:700;letter-spacing:-.03em;margin-bottom:10px;}
.hero-sub{font-size:14px;color:var(--text-3);line-height:1.65;max-width:540px;margin:0 auto;}
.verify-inner{max-width:760px;margin:0 auto;display:flex;flex-direction:column;gap:20px;}
.field-hint{font-size:12px;color:var(--text-3);margin-top:4px;}
.input-wrap{position:relative;}
.input-icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--text-4);}
.verify-input{
  width:100%;height:48px;padding:0 14px 0 42px;
  background:var(--surface);border:1.5px solid var(--border-strong);border-radius:var(--radius);
  font-family:var(--font);font-size:14px;color:var(--text-1);outline:none;transition:all .15s;
}
.verify-input:focus{border-color:var(--blue-500);box-shadow:0 0 0 4px rgba(59,125,247,.1);}
.spinner-wrap{display:none;align-items:center;justify-content:center;gap:12px;padding:20px 0;}
.spinner-wrap.show{display:flex;}
.spinner{width:22px;height:22px;border:2.5px solid var(--blue-100);border-top-color:var(--blue-600);border-radius:50%;animation:spin .7s linear infinite;}
@keyframes spin{to{transform:rotate(360deg)}}
.result{display:none;}
.result.show{display:block;}
.result-header{display:flex;align-items:flex-start;gap:14px;padding:20px 24px;border-bottom:1px solid var(--border);}
.result-header.valid{background:linear-gradient(90deg,#ECFDF5,#FFFFFF);}
.result-header.invalid{background:linear-gradient(90deg,#FFF1F2,#FFFFFF);}
.result-header.unavailable{background:linear-gradient(90deg,#FFFBEB,#FFFFFF);}
.result-icon{width:44px;height:44px;border-radius:99px;display:grid;place-items:center;flex-shrink:0;}
.result-icon.valid{background:var(--emerald-500);color:#fff;}
.result-icon.invalid{background:var(--rose-500);color:#fff;}
.result-icon.unavailable{background:var(--amber-500);color:#fff;}
.result-title{font-size:17px;font-weight:700;margin-bottom:2px;}
.result-title.valid{color:var(--emerald-700);}
.result-title.invalid{color:var(--rose-600);}
.result-title.unavailable{color:var(--amber-600);}
.result-subtitle{font-size:13px;color:var(--text-2);line-height:1.5;}
.result-body{padding:22px 24px 24px;}
.trust-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px 24px;}
.trust-item{min-width:0;}
.trust-key{font-size:11px;font-weight:700;color:var(--text-4);letter-spacing:.06em;text-transform:uppercase;margin-bottom:5px;}
.trust-val{font-size:14px;font-weight:600;color:var(--text-1);overflow-wrap:anywhere;}
.trust-val.muted{font-weight:500;color:var(--text-2);}
.proof-details{margin-top:20px;border:1px solid var(--border);border-radius:12px;background:var(--slate-50);}
.proof-details summary{cursor:pointer;padding:13px 14px;font-size:13px;font-weight:700;color:var(--text-1);}
.proof-details summary:focus-visible{outline:2px solid var(--blue-500);outline-offset:2px;border-radius:10px;}
.proof-body{border-top:1px solid var(--border);padding:14px;display:grid;gap:12px;}
.proof-row{display:grid;grid-template-columns:150px minmax(0,1fr);gap:12px;font-size:12px;}
.proof-label{font-weight:700;color:var(--text-4);text-transform:uppercase;letter-spacing:.05em;}
.proof-value{font-family:var(--mono);color:var(--text-2);overflow-wrap:anywhere;}
.action-row{display:flex;gap:10px;margin-top:20px;flex-wrap:wrap;}
.verify-note{font-size:12px;color:var(--text-3);line-height:1.5;margin-top:12px;}
.btn[disabled]{opacity:.68;cursor:not-allowed;}
@media (max-width: 720px){
  .trust-grid{grid-template-columns:1fr;}
  .proof-row{grid-template-columns:1fr;gap:4px;}
  .result-header{padding:18px;}
  .result-body{padding:18px;}
}
@media (prefers-reduced-motion: reduce){
  .spinner{animation:none;}
  *,*::before,*::after{scroll-behavior:auto!important;transition-duration:.01ms!important;animation-duration:.01ms!important;animation-iteration-count:1!important;}
}
@endsection

@section('content')
<div class="verify-inner">

  <div class="verify-hero">
    <div class="hero-badge">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z"/><path d="M9 12l2 2 4-4"/></svg>
      Official certificate check
    </div>
    <h1 class="hero-heading">Check certificate authenticity</h1>
    <p class="hero-sub">Enter a certificate ID or student ID to confirm whether it matches an official issued record. Technical proof stays available below the result.</p>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="field" style="margin-bottom:20px;">
        <label class="field-label" for="cert-id-input">Certificate ID or Student ID</label>
        <div class="input-wrap">
          <span class="input-icon" aria-hidden="true">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="14" rx="2"/><path d="M7 9h10M7 13h6"/></svg>
          </span>
          <input class="verify-input" id="cert-id-input" autocomplete="off" placeholder="UCAS-12345 or Student ID"/>
        </div>
        <span class="field-hint">Use the certificate ID shown on the record. Proof fingerprints can be checked when the issuing office provides one.</span>
      </div>

      <button type="button" class="btn btn-primary btn-block" id="verify-btn" style="height:48px;font-size:15px;border-radius:14px;" onclick="doVerify()">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z"/><path d="M9 12l2 2 4-4"/></svg>
        Check authenticity
      </button>
      <p class="verify-note">CertChain will never mark a certificate valid unless the verification service returns a confirmed match.</p>
    </div>
  </div>

  <div class="spinner-wrap" id="loading" role="status" aria-live="polite">
    <div class="spinner" aria-hidden="true"></div>
    <span style="font-size:14px;color:var(--text-2);">Checking the official certificate record...</span>
  </div>

  <div id="verification-status" class="sr-only" aria-live="polite"></div>

  <div class="card result" id="result-valid" data-result-state="valid">
    <div class="result-header valid">
      <div class="result-icon valid" aria-hidden="true">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
      </div>
      <div style="flex:1;min-width:0;">
        <div class="result-title valid">Valid certificate</div>
        <div class="result-subtitle">This certificate matches an official issued record.</div>
      </div>
      <span class="badge badge-success"><span class="badge-dot"></span>Valid</span>
    </div>
    <div class="result-body">
      <div class="trust-grid">
        <div class="trust-item"><div class="trust-key">Student identity</div><div class="trust-val" id="valid-student">Confirmed by issuing record</div></div>
        <div class="trust-item"><div class="trust-key">Issuer</div><div class="trust-val" id="valid-issuer">Official issuing institution</div></div>
        <div class="trust-item"><div class="trust-key">Certificate status</div><div class="trust-val" id="valid-status">Issued</div></div>
        <div class="trust-item"><div class="trust-key">Checked at</div><div class="trust-val muted" id="valid-checked-at"></div></div>
        <div class="trust-item"><div class="trust-key">Source</div><div class="trust-val muted" id="valid-source">CertChain verification service</div></div>
        <div class="trust-item"><div class="trust-key">Certificate ID or Student ID</div><div class="trust-val" id="valid-cert-id"></div></div>
      </div>
      <details class="proof-details">
        <summary>Proof details</summary>
        <div class="proof-body">
          <div class="proof-row"><div class="proof-label">Record fingerprint</div><div class="proof-value" id="valid-proof-fingerprint">Available after confirmed response</div></div>
          <div class="proof-row"><div class="proof-label">Proof source</div><div class="proof-value" id="valid-proof-source">CertChain record</div></div>
        </div>
      </details>
    </div>
  </div>

  <div class="card result" id="result-invalid" data-result-state="invalid">
    <div class="result-header invalid">
      <div class="result-icon invalid" aria-hidden="true">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><path d="M18 6 6 18M6 6l12 12"/></svg>
      </div>
      <div style="flex:1;min-width:0;">
        <div class="result-title invalid">Invalid certificate</div>
        <div class="result-subtitle" id="invalid-reason">This ID does not match an issued certificate record.</div>
      </div>
      <span class="badge badge-error"><span class="badge-dot"></span>Invalid</span>
    </div>
    <div class="result-body">
      <div class="trust-grid">
        <div class="trust-item"><div class="trust-key">Certificate ID or Student ID checked</div><div class="trust-val" id="invalid-cert-id"></div></div>
        <div class="trust-item"><div class="trust-key">Certificate status</div><div class="trust-val">No matching issued record</div></div>
        <div class="trust-item"><div class="trust-key">Checked at</div><div class="trust-val muted" id="invalid-checked-at"></div></div>
        <div class="trust-item"><div class="trust-key">Source</div><div class="trust-val muted" id="invalid-source">CertChain verification service</div></div>
      </div>
      <details class="proof-details">
        <summary>Proof details</summary>
        <div class="proof-body">
          <div class="proof-row"><div class="proof-label">Submitted value</div><div class="proof-value" id="invalid-proof-fingerprint"></div></div>
          <div class="proof-row"><div class="proof-label">Result source</div><div class="proof-value" id="invalid-proof-source">Official record lookup</div></div>
        </div>
      </details>
    </div>
  </div>

  <div class="card result" id="result-unavailable" data-result-state="unavailable">
    <div class="result-header unavailable">
      <div class="result-icon unavailable" aria-hidden="true">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6"><path d="M12 9v4M12 17h.01"/><circle cx="12" cy="12" r="9"/></svg>
      </div>
      <div style="flex:1;min-width:0;">
        <div class="result-title unavailable">Unable to verify</div>
        <div class="result-subtitle" id="unavailable-reason">The verification service did not return a confirmed result. No authenticity decision was made.</div>
      </div>
      <span class="badge badge-warning"><span class="badge-dot"></span>Unable</span>
    </div>
    <div class="result-body">
      <div class="trust-grid">
        <div class="trust-item"><div class="trust-key">Certificate ID or Student ID checked</div><div class="trust-val" id="unavailable-cert-id"></div></div>
        <div class="trust-item"><div class="trust-key">Certificate status</div><div class="trust-val">Not confirmed</div></div>
        <div class="trust-item"><div class="trust-key">Checked at</div><div class="trust-val muted" id="unavailable-checked-at"></div></div>
        <div class="trust-item"><div class="trust-key">Source</div><div class="trust-val muted" id="unavailable-source">Verification service unavailable</div></div>
      </div>
      <div class="action-row">
        <button type="button" class="btn btn-primary" onclick="doVerify()">Try again</button>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('cert-id-input').focus()">Check the ID</button>
      </div>
      <details class="proof-details">
        <summary>Proof details</summary>
        <div class="proof-body">
          <div class="proof-row"><div class="proof-label">Submitted value</div><div class="proof-value" id="unavailable-proof-fingerprint"></div></div>
          <div class="proof-row"><div class="proof-label">Failure type</div><div class="proof-value" id="unavailable-proof-source">No confirmed response</div></div>
        </div>
      </details>
    </div>
  </div>

</div>
@endsection

@section('extra-scripts')
<script>
  const verifyEndpoint = "{{ route('dashboard.verify.check') }}";

  function getQueryParam(name) {
    return new URLSearchParams(window.location.search).get(name);
  }

  function formatCheckTime(date = new Date()) {
    return new Intl.DateTimeFormat(undefined, {
      year: 'numeric',
      month: 'short',
      day: '2-digit',
      hour: '2-digit',
      minute: '2-digit'
    }).format(date);
  }

  function setText(id, value, fallback = 'Not provided') {
    const el = document.getElementById(id);
    if (!el) return;
    el.textContent = value || fallback;
  }

  function readPath(obj, paths) {
    for (const path of paths) {
      const value = path.split('.').reduce((acc, key) => acc && acc[key], obj);
      if (value !== undefined && value !== null && value !== '') return value;
    }
    return '';
  }

  function hideResults() {
    document.querySelectorAll('.result').forEach(result => result.classList.remove('show'));
    document.getElementById('loading').classList.remove('show');
  }

  function announce(message) {
    setText('verification-status', message, '');
  }

  function setBusy(isBusy) {
    const btn = document.getElementById('verify-btn');
    btn.disabled = isBusy;
    btn.setAttribute('aria-busy', isBusy ? 'true' : 'false');
  }

  function showResult(id, announcement) {
    hideResults();
    document.getElementById(id).classList.add('show');
    announce(announcement);
  }

  function normalizeData(data, identifier) {
    const checkedAt = readPath(data, ['checked_at', 'verified_at', 'timestamp']) || formatCheckTime();
    return {
      certificateId: readPath(data, ['certificate_id', 'certificate.id', 'id']) || identifier,
      student: readPath(data, ['student.name', 'student_name', 'studentName', 'name']) || 'Confirmed by issuing record',
      issuer: readPath(data, ['issuer.name', 'issued_by', 'issuer', 'institution', 'university']) || 'Official issuing institution',
      status: readPath(data, ['certificate.status', 'status', 'certificate_status']) || 'Issued',
      checkedAt,
      source: readPath(data, ['source', 'verification_source']) || 'CertChain verification service',
      proofFingerprint: readPath(data, ['proof_fingerprint', 'keccak256_hash', 'hash', 'tx_hash', 'transaction_hash']) || identifier,
      message: readPath(data, ['message', 'reason', 'error'])
    };
  }

  function renderValid(data, identifier) {
    const normalized = normalizeData(data, identifier);
    setText('valid-student', normalized.student);
    setText('valid-issuer', normalized.issuer);
    setText('valid-status', normalized.status);
    setText('valid-checked-at', normalized.checkedAt);
    setText('valid-source', normalized.source);
    setText('valid-cert-id', normalized.certificateId);
    setText('valid-proof-fingerprint', normalized.proofFingerprint);
    setText('valid-proof-source', normalized.source);
    showResult('result-valid', 'Valid certificate. Official record matched.');
  }

  function renderInvalid(data, identifier) {
    const normalized = normalizeData(data || {}, identifier);
    setText('invalid-reason', normalized.message || 'This ID does not match an issued certificate record.', '');
    setText('invalid-cert-id', normalized.certificateId);
    setText('invalid-checked-at', normalized.checkedAt);
    setText('invalid-source', normalized.source || 'CertChain verification service');
    setText('invalid-proof-fingerprint', normalized.proofFingerprint);
    setText('invalid-proof-source', normalized.source || 'Official record lookup');
    showResult('result-invalid', 'Invalid certificate. No official record matched.');
  }

  function renderUnavailable(identifier, reason) {
    const checkedAt = formatCheckTime();
    setText('unavailable-reason', reason || 'The verification service did not return a confirmed result. No authenticity decision was made.', '');
    setText('unavailable-cert-id', identifier);
    setText('unavailable-checked-at', checkedAt);
    setText('unavailable-proof-fingerprint', identifier);
    showResult('result-unavailable', 'Unable to verify. No authenticity decision was made.');
  }

  async function doVerify() {
    const input = document.getElementById('cert-id-input');
    const identifier = input.value.trim();

    if (!identifier) {
      input.focus();
      announce('Please enter a certificate ID before checking authenticity.');
      return;
    }

    hideResults();
    document.getElementById('loading').classList.add('show');
    setBusy(true);
    announce('Checking the official certificate record.');

    try {
      const response = await fetch(verifyEndpoint, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({ identifier })
      });

      if (!response.ok) {
        throw new Error('The verification service is not available right now.');
      }

      const data = await response.json();

      if (data.valid === true || data.status === 'valid') {
        renderValid(data, identifier);
      } else if (data.valid === false || data.status === 'invalid') {
        renderInvalid(data, identifier);
      } else {
        renderUnavailable(identifier, 'The verification service responded, but did not confirm a valid or invalid result.');
      }
    } catch (error) {
      renderUnavailable(identifier, error.message || 'We could not reach the verification service. Try again or ask the issuing office to confirm the record.');
    } finally {
      document.getElementById('loading').classList.remove('show');
      setBusy(false);
    }
  }

  function initVerifyFromQuery() {
    const hashParam = getQueryParam('hash');
    if (!hashParam) return;

    document.getElementById('cert-id-input').value = hashParam;
    doVerify();
  }

  document.getElementById('cert-id-input').addEventListener('keydown', e => {
    if (e.key === 'Enter') doVerify();
  });
  document.addEventListener('DOMContentLoaded', initVerifyFromQuery);
</script>
@endsection
