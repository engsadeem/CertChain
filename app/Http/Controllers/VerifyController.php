<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\VerificationLog;
use App\Services\BlockchainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyController extends Controller
{
    public function index()
    {
        return view('dashboard.verify');
    }

    public function check(Request $request, BlockchainService $blockchain)
    {
        $validated = $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
        ]);

        $identifier = trim($validated['identifier']);
        $identifierLower = strtolower($identifier);

        $certificate = Certificate::with(['student', 'issuedBy', 'blockchainRecord'])
            ->where(function ($query) use ($identifier, $identifierLower) {
                $query->whereRaw('LOWER(certificate_id) = ?', [$identifierLower])
                    ->orWhereRaw('LOWER(keccak256_hash) = ?', [$identifierLower])
                    ->orWhere('tx_hash', $identifier)
                    ->orWhereHas('student', function ($studentQuery) use ($identifier, $identifierLower) {
                        $studentQuery->whereRaw('LOWER(student_number) = ?', [$identifierLower])
                            ->orWhere('national_id', $identifier);
                    });
            })
            ->latest()
            ->first();

        if (! $certificate) {
            return response()->json([
                'valid' => false,
                'status' => 'invalid',
                'certificate_id' => $identifier,
                'message' => 'No matching certificate or student record was found.',
                'checked_at' => now()->format('M d, Y, h:i A'),
                'source' => 'CertChain local database',
            ], 200);
        }

        $isIssued = $certificate->status === 'issued';

        $blockchainChecked = false;
        $blockchainValid = false;
        $blockchainError = null;
        $blockchainResult = null;

        try {
            $blockchainResult = $blockchain->verifyCertificate($certificate->certificate_id, $certificate->keccak256_hash);
            $blockchainChecked = true;
            $blockchainValid = (bool) ($blockchainResult['verified'] ?? false);
        } catch (\Throwable $exception) {
            report($exception);
            $blockchainError = $exception->getMessage();
        }

        $isValid = $isIssued && $blockchainValid;

        VerificationLog::create([
            'certificate_id' => $certificate->id,
            'verifier_name' => Auth::user()->name ?? 'System verifier',
            'verifier_org' => Auth::user()->institution ?? 'CertChain',
            'verifier_email' => Auth::user()->email ?? 'system@certchain.local',
            'ip_address' => $request->ip(),
            'is_valid' => $isValid,
            'verified_at' => now(),
        ]);

        return response()->json([
            'valid' => $isValid,
            'status' => $isValid ? 'valid' : 'invalid',
            'certificate_status' => ucfirst($certificate->status),
            'certificate_id' => $certificate->certificate_id,
            'student_id' => $certificate->student->student_number ?? null,
            'student_name' => trim(($certificate->student->first_name ?? '') . ' ' . ($certificate->student->last_name ?? '')),
            'university' => $certificate->issuedBy->name ?? 'Unknown issuer',
            'issuer' => [
                'name' => $certificate->issuedBy->name ?? 'Unknown issuer',
            ],
            'degree' => $certificate->student->degree_level ?? null,
            'proof_fingerprint' => $certificate->keccak256_hash,
            'tx_hash' => $certificate->tx_hash,
            'source' => $blockchainChecked ? 'Ethereum Sepolia smart contract + CertChain database' : 'CertChain database only',
            'blockchain' => [
                'checked' => $blockchainChecked,
                'valid' => $blockchainValid,
                'error' => $blockchainError,
                'contract' => config('blockchain.contract_address'),
                'network' => config('blockchain.network_name'),
                'stored_hash' => $blockchainResult['stored_hash'] ?? null,
                'timestamp' => $blockchainResult['timestamp'] ?? null,
            ],
            'checked_at' => now()->format('M d, Y, h:i A'),
            'message' => $isValid
                ? 'This certificate is issued locally and its fingerprint matches the smart contract record.'
                : 'This certificate could not be validated against the blockchain record.',
        ], 200);
    }
}
