<?php

namespace App\Http\Controllers;

use App\Models\Certificate;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCertificates = Certificate::count();
        $verified          = Certificate::where('status', 'issued')->count();
        $pending           = Certificate::where('status', 'pending')->count();
        $recentCertificates = Certificate::with(['student', 'issuedBy'])
            ->latest()
            ->limit(6)
            ->get();

        return view('dashboard.index', compact(

            'totalCertificates',
            'verified',
            'pending',
            'recentCertificates'
        ));
    }
}
