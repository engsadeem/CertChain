<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        if (mb_strlen($q) < 2) {
            return response()->json(['certificates' => [], 'users' => []]);
        }

        $certificates = Certificate::with('student')
            ->where(function ($query) use ($q) {
                $query->where('certificate_id', 'like', "%{$q}%")
                    ->orWhere('keccak256_hash', 'like', "%{$q}%")
                    ->orWhereHas('student', function ($studentQuery) use ($q) {
                        $studentQuery->where('first_name', 'like', "%{$q}%")
                            ->orWhere('last_name', 'like', "%{$q}%")
                            ->orWhere('student_number', 'like', "%{$q}%")
                            ->orWhere('national_id', 'like', "%{$q}%");
                    });
            })
            ->latest()
            ->limit(5)
            ->get()
            ->map(function (Certificate $certificate) {
                $studentName = trim(($certificate->student->first_name ?? '') . ' ' . ($certificate->student->last_name ?? ''));

                return [
                    'id' => $certificate->id,
                    'certificate_id' => $certificate->certificate_id,
                    'student' => [
                        'name' => $studentName ?: 'Unknown',
                    ],
                    'degree' => $certificate->student->degree_level ?? '',
                    'issued_at' => optional($certificate->created_at)->format('M d, Y'),
                    'status' => $certificate->status,
                ];
            })
            ->values();

        $users = collect();
        if (Auth::user()?->role === 'admin') {
            $users = User::where('name', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")
                ->limit(4)
                ->get(['id', 'name', 'email', 'role']);
        }

        return response()->json([
            'certificates' => $certificates,
            'users' => $users,
        ]);
    }
}
