<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with(['student', 'issuedBy', 'verificationLogs'])
            ->latest()
            ->paginate(15);

        return view('dashboard.certificates.index', compact('certificates'));
    }

    public function show(Certificate $certificate)
    {
        $certificate->load(['student', 'issuedBy', 'verificationLogs', 'blockchainRecord']);
        $latestVerification = $certificate->verificationLogs()->latest('verified_at')->first();

        return view('dashboard.certificates.show', compact('certificate', 'latestVerification'));
    }

    public function approve(Request $request, Certificate $certificate)
    {
        if (! Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $certificate->status = 'issued';
        $certificate->save();

        return back()->with('success', 'Certificate has been approved.');
    }
}
