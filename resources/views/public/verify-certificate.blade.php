<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #111827; }
        .page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .card { width: 100%; max-width: 760px; background: #ffffff; border-radius: 18px; box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12); padding: 32px; }
        .status { display: inline-block; padding: 8px 14px; border-radius: 999px; font-weight: 700; font-size: 14px; margin-bottom: 18px; }
        .valid { color: #065f46; background: #d1fae5; }
        .invalid { color: #991b1b; background: #fee2e2; }
        .neutral { color: #1d4ed8; background: #dbeafe; }
        h1 { margin: 0 0 8px; font-size: 28px; }
        .subtitle { color: #6b7280; margin-bottom: 28px; line-height: 1.6; }
        .grid { display: grid; grid-template-columns: 180px 1fr; gap: 12px 18px; margin-top: 20px; }
        .label { color: #6b7280; font-weight: 600; }
        .value { word-break: break-word; }
        .proof { margin-top: 26px; padding: 16px; border-radius: 12px; background: #f9fafb; border: 1px solid #e5e7eb; font-size: 14px; word-break: break-word; }
        .warning { margin-top: 24px; color: #6b7280; font-size: 14px; line-height: 1.6; }
        .verify-form { display: flex; gap: 10px; margin-top: 20px; }
        .verify-form input { flex: 1; min-width: 0; height: 44px; border: 1px solid #d1d5db; border-radius: 10px; padding: 0 12px; font-size: 14px; }
        .verify-form button, .link-button { height: 44px; border: 0; border-radius: 10px; background: #2563eb; color: #fff; padding: 0 16px; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; }
        @media (max-width: 640px) { .grid { grid-template-columns: 1fr; } .card { padding: 22px; } .verify-form { flex-direction: column; } }
    </style>
</head>
<body>
<div class="page">
    <div class="card">
        @if($isValid === null)
            <div class="status neutral">CERTIFICATE VERIFICATION</div>
            <h1>Verify a certificate</h1>
            <div class="subtitle">Enter the certificate ID or proof fingerprint printed on the certificate.</div>

            <form class="verify-form" method="GET" action="{{ route('public.verify.index') }}">
                <input name="identifier" placeholder="UCAS-2026-XXXX or 0x..." autocomplete="off" required>
                <button type="submit">Verify</button>
            </form>
        @elseif($isValid)
            <div class="status valid">VALID CERTIFICATE</div>
            <h1>Certificate verified successfully</h1>
            <div class="subtitle">This certificate matches an official issued record and the smart contract fingerprint on Ethereum Sepolia.</div>

            <div class="grid">
                <div class="label">Certificate ID</div>
                <div class="value">{{ $certificate->certificate_id }}</div>

                <div class="label">Student Name</div>
                <div class="value">{{ trim(($certificate->student->first_name ?? '') . ' ' . ($certificate->student->last_name ?? '')) }}</div>

                <div class="label">Student ID</div>
                <div class="value">{{ $certificate->student->student_number ?? 'N/A' }}</div>

                <div class="label">University</div>
                <div class="value">{{ $certificate->issuedBy->name ?? 'Unknown issuer' }}</div>

                <div class="label">Degree</div>
                <div class="value">{{ $certificate->student->degree_level ?? 'N/A' }}</div>

                <div class="label">Status</div>
                <div class="value">{{ ucfirst($certificate->status) }}</div>

                <div class="label">Transaction</div>
                <div class="value">
                    @php
                        $etherscanBase = rtrim(config('blockchain.etherscan_base_url', 'https://sepolia.etherscan.io'), '/');
                        $txUrl = $certificate->tx_hash && !str_starts_with($certificate->tx_hash, 'local-') ? $etherscanBase . '/tx/' . $certificate->tx_hash : null;
                    @endphp
                    @if($txUrl)
                        <a href="{{ $txUrl }}" target="_blank" rel="noopener">{{ $certificate->tx_hash }}</a>
                    @else
                        {{ $certificate->tx_hash ?? 'N/A' }}
                    @endif
                </div>

                <div class="label">Blockchain</div>
                <div class="value">{{ config('blockchain.network_name', 'Sepolia Testnet') }} · {{ $blockchainResult['smart_contract'] ?? $certificate->contract_address ?? 'N/A' }}</div>
            </div>

            <div class="proof">
                <strong>Proof fingerprint:</strong><br>
                {{ $certificate->keccak256_hash ?? 'N/A' }}
                @if(!empty($blockchainResult))
                    <br><br><strong>On-chain check:</strong> {{ ($blockchainResult['verified'] ?? false) ? 'Matched' : 'Not matched' }}
                    @if(!empty($blockchainResult['timestamp']))
                        <br><strong>Registered timestamp:</strong> {{ $blockchainResult['timestamp'] }}
                    @endif
                @endif
            </div>
        @else
            <div class="status invalid">INVALID / NOT FOUND</div>
            <h1>Certificate could not be verified</h1>
            <div class="subtitle">
                No valid issued certificate was found for:
                <strong>{{ $identifier }}</strong>
                @if(!empty($blockchainError))
                    <br><br>Blockchain check error: {{ $blockchainError }}
                @endif
            </div>
            <a class="link-button" href="{{ route('public.verify.index') }}">Try another certificate</a>
        @endif

        <div class="warning">
            Always make sure this page is opened from the official CertChain verification domain.
            A QR code is only a shortcut to the verification page; the actual trust comes from the official system record and proof fingerprint.
        </div>
    </div>
</div>
</body>
</html>
