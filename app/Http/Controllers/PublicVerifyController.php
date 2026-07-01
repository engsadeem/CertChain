<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Services\BlockchainService;
use Illuminate\Http\Request;

class PublicVerifyController extends Controller
{
    public function index(Request $request)
    {
        $identifier = trim((string) $request->query('identifier', ''));

        if ($identifier !== '') {
            return redirect()->route('public.verify.show', ['identifier' => $identifier]);
        }

        return view('public.verify-certificate', [
            'identifier' => null,
            'certificate' => null,
            'isValid' => null,
        ]);
    }

    public function show(string $identifier, BlockchainService $blockchain)
    {
        $identifier = trim($identifier);
        $identifierLower = strtolower($identifier);

        $certificate = Certificate::with(['student', 'issuedBy', 'blockchainRecord'])
            ->where(function ($query) use ($identifierLower) {
                $query->whereRaw('LOWER(certificate_id) = ?', [$identifierLower])
                    ->orWhereRaw('LOWER(keccak256_hash) = ?', [$identifierLower]);
            })
            ->latest()
            ->first();

        $blockchainResult = null;
        $blockchainError = null;
        $blockchainValid = false;

        if ($certificate) {
            try {
                $blockchainResult = $blockchain->verifyCertificate($certificate->certificate_id, $certificate->keccak256_hash);
                $blockchainValid = (bool) ($blockchainResult['verified'] ?? false);
            } catch (\Throwable $exception) {
                report($exception);
                $blockchainError = $exception->getMessage();
            }
        }

        return view('public.verify-certificate', [
            'identifier' => $identifier,
            'certificate' => $certificate,
            'isValid' => $certificate && $certificate->status === 'issued' && $blockchainValid,
            'blockchainResult' => $blockchainResult,
            'blockchainError' => $blockchainError,
        ]);
    }
}
