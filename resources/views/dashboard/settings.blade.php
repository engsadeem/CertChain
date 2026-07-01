@extends('layouts.main-dashboard')

@section('title', 'CertChain - Settings')
@section('page-title', 'Settings')
@section('page-subtitle', 'Configure platform, blockchain, and notification preferences')

@section('style')
.settings-layout{display:grid;grid-template-columns:220px 1fr;gap:24px;align-items:start;}
.settings-nav{display:flex;flex-direction:column;gap:2px;}
.settings-nav-item{
  display:flex;align-items:center;gap:10px;
  padding:10px 14px;border-radius:10px;font-size:13.5px;font-weight:500;
  color:var(--text-2);cursor:pointer;text-decoration:none;transition:all .15s;border:none;
  background:transparent;width:100%;text-align:left;
}
.settings-nav-item:hover{background:var(--slate-100);color:var(--text-1);}
.settings-nav-item.active{background:var(--blue-50);color:var(--blue-700);font-weight:600;}
.settings-panel{display:none;}
.settings-panel.active{display:block;}
.settings-section{margin-bottom:28px;}
.settings-section-title{font-size:14px;font-weight:600;margin-bottom:4px;}
.settings-section-desc{font-size:13px;color:var(--text-3);margin-bottom:18px;}
.settings-divider{height:1px;background:var(--border);margin:24px 0;}
.toggle-row{
  display:flex;align-items:center;justify-content:space-between;
  padding:14px 0;border-bottom:1px solid var(--border);
}
.toggle-row:last-child{border-bottom:none;}
.toggle-info{flex:1;}
.toggle-title{font-size:13.5px;font-weight:500;color:var(--text-1);}
.toggle-desc{font-size:12px;color:var(--text-3);margin-top:2px;}
.toggle{
  width:44px;height:24px;border-radius:99px;background:var(--slate-200);
  border:none;cursor:pointer;position:relative;transition:background .2s;flex-shrink:0;
}
.toggle.on{background:var(--blue-600);}
.toggle::after{
  content:'';position:absolute;top:3px;left:3px;
  width:18px;height:18px;border-radius:99px;background:#fff;
  box-shadow:0 1px 3px rgba(0,0,0,.2);transition:transform .2s;
}
.toggle.on::after{transform:translateX(20px);}
.hash-display{
  font-family:var(--mono);font-size:12px;color:var(--text-2);
  background:var(--slate-50);border:1px solid var(--border);border-radius:8px;
  padding:10px 14px;word-break:break-all;line-height:1.6;margin-top:8px;
}
.save-bar{
  display:flex;justify-content:flex-end;gap:10px;
  padding-top:20px;border-top:1px solid var(--border);margin-top:24px;
}
@endsection

@section('content')

<div class="settings-layout">

  <!-- LEFT NAV -->
  <div class="card" style="padding:12px;">
    <nav class="settings-nav">
      <button class="settings-nav-item active" onclick="switchTab('general', this)">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
        General
      </button>
      <button class="settings-nav-item" onclick="switchTab('blockchain', this)">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 7.5 12 12 3 7.5M12 12v9.5M21 7.5v9L12 21l-9-4.5v-9L12 3l9 4.5z"/></svg>
        Blockchain
      </button>
      <button class="settings-nav-item" onclick="switchTab('notifications', this)">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8a6 6 0 1 1 12 0c0 7 3 9 3 9H3s3-2 3-9z"/><path d="M10 21a2 2 0 0 0 4 0"/></svg>
        Notifications
      </button>
      <button class="settings-nav-item" onclick="switchTab('security', this)">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        Security
      </button>
    </nav>
  </div>

  <!-- RIGHT PANELS -->
  <div>

    <!-- GENERAL -->
    <div class="settings-panel active" id="panel-general">
      <div class="card" style="padding:28px;">
        <div class="settings-section">
          <div class="settings-section-title">Platform Information</div>
          <div class="settings-section-desc">Basic details about your CertChain instance.</div>
          <div class="grid-2">
            <div class="field">
              <label class="field-label">Platform Name</label>
              <input class="input" value="{{ config('app.name', 'CertChain') }}"/>
            </div>
            <div class="field">
              <label class="field-label">Institution Name</label>
              <input class="input" value="University College of Applied Sciences"/>
            </div>
          </div>
          <div class="field">
            <label class="field-label">Platform URL</label>
            <input class="input" value="{{ config('app.url') }}"/>
          </div>
          <div class="field">
            <label class="field-label">Support Email</label>
            <input class="input" type="email" value="support@certchain.ps"/>
          </div>
        </div>

        <div class="settings-divider"></div>

        <div class="settings-section">
          <div class="settings-section-title">Localization</div>
          <div class="settings-section-desc">Language and timezone settings.</div>
          <div class="grid-2">
            <div class="field">
              <label class="field-label">Language</label>
              <select class="select">
                <option selected>English</option>
                <option>Arabic (عربي)</option>
              </select>
            </div>
            <div class="field">
              <label class="field-label">Timezone</label>
              <select class="select">
                <option selected>Asia/Gaza (GMT+3)</option>
                <option>UTC</option>
                <option>Asia/Jerusalem (GMT+3)</option>
              </select>
            </div>
          </div>
        </div>

        <div class="save-bar">
          <button class="btn btn-secondary">Discard</button>
          <button class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </div>

    <!-- BLOCKCHAIN -->
    <div class="settings-panel" id="panel-blockchain">
      @php
          $etherscanBase = rtrim(config('blockchain.etherscan_base_url', 'https://sepolia.etherscan.io'), '/');

          $contractAddress = config('blockchain.contract_address');
          $lastTxHash = config('blockchain.last_tx_hash');
          $chainId = config('blockchain.chain_id', '11155111');
          $networkName = config('blockchain.network_name', 'Sepolia Testnet');
          $rpcEndpoint = config('blockchain.rpc_endpoint');

          $contractUrl = $contractAddress ? $etherscanBase . '/address/' . $contractAddress : null;
          $txUrl = $lastTxHash ? $etherscanBase . '/tx/' . $lastTxHash : null;

          if ($rpcEndpoint) {
              $maskedRpc = preg_replace('/\/v2\/.+$/', '/v2/' . str_repeat('•', 8), $rpcEndpoint);
          } else {
              $maskedRpc = 'Not configured';
          }
      @endphp

      <div class="card" style="padding:28px;">
        <div class="settings-section">
          <div class="settings-section-title">Network Configuration</div>
          <div class="settings-section-desc">Ethereum network and smart contract settings.</div>

          <div class="grid-2">
            <div class="field">
              <label class="field-label">Network</label>
              <input class="input"
                     value="{{ $networkName }}"
                     readonly
                     style="background:var(--slate-50);"/>
            </div>

            <div class="field">
              <label class="field-label">Chain ID</label>
              <input class="input"
                     value="{{ $chainId }}"
                     readonly
                     style="background:var(--slate-50);"/>
            </div>
          </div>

          <div class="field">
            <label class="field-label">Smart Contract Address</label>
            <input class="input"
                   value="{{ $contractAddress ?? 'Not configured' }}"
                   readonly
                   style="font-family:var(--mono);font-size:12px;background:var(--slate-50);"/>
          </div>

          <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:12px;">
            @if($contractUrl)
              <a href="{{ $contractUrl }}"
                 target="_blank"
                 rel="noopener noreferrer"
                 class="btn btn-secondary btn-sm">
                Open smart contract
              </a>
            @else
              <button class="btn btn-secondary btn-sm" disabled>
                Smart contract not configured
              </button>
            @endif

            @if($txUrl)
              <a href="{{ $txUrl }}"
                 target="_blank"
                 rel="noopener noreferrer"
                 class="btn btn-primary btn-sm">
                Blockchain
              </a>
            @else
              <button class="btn btn-secondary btn-sm" disabled>
                No transaction hash configured
              </button>
            @endif
          </div>
        </div>

        <div class="settings-divider"></div>

        <div class="settings-section">
          <div class="settings-section-title">RPC Endpoint</div>
          <div class="settings-section-desc">RPC key is masked for security. Update the real endpoint from the .env file.</div>

          <div class="field">
            <label class="field-label">RPC Endpoint</label>
            <input class="input"
                   value="{{ $maskedRpc }}"
                   readonly
                   style="font-family:var(--mono);font-size:12px;background:var(--slate-50);"/>
          </div>
        </div>

        <div class="settings-divider"></div>

        <div class="settings-section">
          <div class="settings-section-title">Gas & Fees</div>
          <div class="settings-section-desc">Transaction cost settings used by the wallet/provider.</div>

          <div class="grid-2">
            <div class="field">
              <label class="field-label">Gas Limit</label>
              <input class="input"
                     value="Estimated automatically"
                     readonly
                     style="background:var(--slate-50);"/>
            </div>

            <div class="field">
              <label class="field-label">Fee Network</label>
              <input class="input"
                     value="Sepolia"
                     readonly
                     style="background:var(--slate-50);"/>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- NOTIFICATIONS -->
    <div class="settings-panel" id="panel-notifications">
      <div class="card" style="padding:28px;">
        <div class="settings-section">
          <div class="settings-section-title">Email Notifications</div>
          <div class="settings-section-desc">Choose which events trigger an email.</div>
          <div class="toggle-row">
            <div class="toggle-info">
              <div class="toggle-title">Certificate Issued</div>
              <div class="toggle-desc">Send a confirmation when an official certificate record is created</div>
            </div>
            <button class="toggle on" onclick="this.classList.toggle('on')"></button>
          </div>
          <div class="toggle-row">
            <div class="toggle-info">
              <div class="toggle-title">Certificate Verified</div>
              <div class="toggle-desc">Notify when a public verification is performed</div>
            </div>
            <button class="toggle on" onclick="this.classList.toggle('on')"></button>
          </div>
          <div class="toggle-row">
            <div class="toggle-info">
              <div class="toggle-title">Issuance Failed</div>
              <div class="toggle-desc">Alert when the proof service cannot complete a certificate record</div>
            </div>
            <button class="toggle on" onclick="this.classList.toggle('on')"></button>
          </div>
          <div class="toggle-row">
            <div class="toggle-info">
              <div class="toggle-title">New User Registered</div>
              <div class="toggle-desc">Notify admins when a new account is created</div>
            </div>
            <button class="toggle" onclick="this.classList.toggle('on')"></button>
          </div>
        </div>

        <div class="save-bar">
          <button class="btn btn-secondary">Discard</button>
          <button class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </div>

    <!-- SECURITY -->
    <div class="settings-panel" id="panel-security">
      <div class="card" style="padding:28px;">
        <div class="settings-section">
          <div class="settings-section-title">Authentication</div>
          <div class="settings-section-desc">Login and session security options.</div>
          <div class="toggle-row">
            <div class="toggle-info">
              <div class="toggle-title">Two-Factor Authentication</div>
              <div class="toggle-desc">Require a one-time code on each login</div>
            </div>
            <button class="toggle" onclick="this.classList.toggle('on')"></button>
          </div>
          <div class="toggle-row">
            <div class="toggle-info">
              <div class="toggle-title">Session Timeout</div>
              <div class="toggle-desc">Automatically log out after 30 minutes of inactivity</div>
            </div>
            <button class="toggle on" onclick="this.classList.toggle('on')"></button>
          </div>
          <div class="toggle-row">
            <div class="toggle-info">
              <div class="toggle-title">Login Notifications</div>
              <div class="toggle-desc">Send an email on every new login</div>
            </div>
            <button class="toggle on" onclick="this.classList.toggle('on')"></button>
          </div>
        </div>

        <div class="settings-divider"></div>

        <div class="settings-section">
          <div class="settings-section-title">Danger Zone</div>
          <div class="settings-section-desc">Irreversible actions — proceed with caution.</div>
          <div style="padding:16px;border:1px solid var(--rose-100);border-radius:12px;background:var(--rose-50);">
            <div style="font-size:13.5px;font-weight:600;color:var(--rose-600);margin-bottom:6px;">Clear Verification Logs</div>
            <div style="font-size:12px;color:var(--text-2);margin-bottom:14px;">Permanently delete all certificate verification history. This cannot be undone.</div>
            <button class="btn btn-danger btn-sm">Delete All Logs</button>
          </div>
        </div>

        <div class="save-bar">
          <button class="btn btn-secondary">Discard</button>
          <button class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('scripts')
function switchTab(name, el) {
  document.querySelectorAll('.settings-nav-item').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.settings-panel').forEach(p => p.classList.remove('active'));
  el.classList.add('active');
  document.getElementById('panel-' + name).classList.add('active');
}
@endsection
