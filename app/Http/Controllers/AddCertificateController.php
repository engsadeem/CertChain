<?php

namespace App\Http\Controllers;

use App\Models\BlockchainRecord;
use App\Models\Certificate;
use App\Models\Student;
use App\Models\University;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\BlockchainService;
use Throwable;

class AddCertificateController extends Controller
{
    public function index()
    {
        $universities = University::where('is_active', true)->orderBy('name')->get();

        return view('dashboard.add-certificate', compact('universities'));
    }

    public function qrCode(Request $request)
    {
        $request->validate([
            'text' => ['required', 'string', 'max:2048'],
            'size' => ['nullable', 'integer', 'min:100', 'max:512'],
        ]);

        $text = $request->query('text');
        $size = (int) $request->query('size', 250);

        $renderer = new ImageRenderer(
            new RendererStyle($size),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);

        return response($writer->writeString($text), 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('X-Content-Type-Options', 'nosniff');
    }

    public function storeAndSubmit(Request $request, BlockchainService $blockchain)
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'string', 'max:100'],
            'university' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'graduation_date' => ['required', 'date'],
            'certificate_pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        if (! $blockchain->isConfigured()) {
            return back()
                ->withInput($request->except('certificate_pdf'))
                ->withErrors([
                    'blockchain' => 'Blockchain is not configured. Add ETH_RPC_URL, ETH_CONTRACT_ADDRESS, and ETH_PRIVATE_KEY to .env, then run php artisan optimize:clear.',
                ]);
        }

        $filePath = null;

        try {
            $uploadedFile = $request->file('certificate_pdf');
            $pdfHash = hash_file('sha256', $uploadedFile->getRealPath());

            do {
                $certificateId = 'UCAS-' . now()->format('Y') . '-' . strtoupper(Str::random(8));
            } while (Certificate::where('certificate_id', $certificateId)->exists());

            $universityName = trim($validated['university']);

            $canonicalPayload = [
                'certificate_id' => $certificateId,
                'student_name' => trim($validated['student_name']),
                'student_id' => trim($validated['student_id']),
                'university' => $universityName,
                'degree' => trim($validated['degree']),
                'graduation_date' => $validated['graduation_date'],
                'pdf_sha256' => $pdfHash,
            ];

            $hash = $blockchain->keccak256Payload($canonicalPayload);
            $chainResult = $blockchain->registerCertificate($certificateId, $hash);
            $txHash = $chainResult['tx_hash'];
            $contractAddress = $chainResult['smart_contract'] ?? config('blockchain.contract_address');

            $filePath = $uploadedFile->store('certificates', 'public');

            $certificate = DB::transaction(function () use ($validated, $universityName, $certificateId, $filePath, $hash, $txHash, $contractAddress, $chainResult) {
                $university = University::firstOrCreate(
                    ['name' => $universityName],
                    ['is_active' => true]
                );

                $nameParts = preg_split('/\s+/', trim($validated['student_name']), 2);
                $firstName = $nameParts[0] ?? trim($validated['student_name']);
                $lastName = $nameParts[1] ?? '-';

                $student = Student::updateOrCreate(
                    ['student_number' => trim($validated['student_id'])],
                    [
                        'university_id' => $university->id,
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'national_id' => trim($validated['student_id']),
                        'major' => trim($validated['degree']),
                        'degree_level' => trim($validated['degree']),
                        'graduation_date' => $validated['graduation_date'],
                    ]
                );

                $certificate = Certificate::create([
                    'student_id' => $student->id,
                    'issued_by' => $university->id,
                    'certificate_id' => $certificateId,
                    'file_path' => $filePath,
                    'keccak256_hash' => $hash,
                    'tx_hash' => $txHash,
                    'contract_address' => $contractAddress,
                    'status' => 'issued',
                ]);

                BlockchainRecord::create([
                    'certificate_id' => $certificate->id,
                    'tx_hash' => $txHash,
                    'block_number' => (string) ($chainResult['block_number'] ?? 'pending'),
                    'network' => $chainResult['network'] ?? config('blockchain.network', 'sepolia'),
                    'smart_contract' => $contractAddress,
                ]);

                return $certificate;
            });

            $verificationUrl = rtrim(config('app.url'), '/') . route('public.verify.show', ['identifier' => $certificate->certificate_id], false);
            $qrPath = 'qrcodes/' . $certificate->certificate_id . '.svg';

            $qrRenderer = new ImageRenderer(
                new RendererStyle(350),
                new SvgImageBackEnd()
            );

            Storage::disk('public')->put($qrPath, (new Writer($qrRenderer))->writeString($verificationUrl));

            $certificate->update([
                'qr_path' => $qrPath,
            ]);

            return redirect()
                ->route('dashboard.certificates.show', $certificate)
                ->with('success', 'Certificate issued on Ethereum Sepolia successfully. Transaction: ' . $txHash);
        } catch (Throwable $exception) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }

            report($exception);

            return back()
                ->withInput($request->except('certificate_pdf'))
                ->withErrors([
                    'blockchain' => 'Issue failed before the certificate was saved. Reason: ' . $exception->getMessage(),
                ]);
        }
    }
}
