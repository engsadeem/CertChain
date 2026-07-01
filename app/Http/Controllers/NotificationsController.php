<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\RoleRequest;
use App\Models\VerificationLog;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = collect();
        $isAdmin = auth()->check() && auth()->user()->role === 'admin';

        Certificate::with('student')
            ->latest()
            ->limit(5)
            ->get()
            ->each(function (Certificate $cert) use (&$notifications) {
                $studentName = trim(($cert->student->first_name ?? '') . ' ' . ($cert->student->last_name ?? '')) ?: 'Unknown';

                $notifications->push([
                    'type' => 'certificate',
                    'title' => 'Certificate Issued',
                    'body' => $studentName . ' — ' . ($cert->student->degree_level ?? ''),
                    'time' => $cert->created_at?->diffForHumans() ?? '',
                    'read' => $cert->created_at?->lt(now()->subHours(2)) ?? true,
                ]);
            });

        VerificationLog::latest('verified_at')
            ->limit(5)
            ->get()
            ->each(function (VerificationLog $log) use (&$notifications) {
                $verifiedAt = $log->verified_at ?: now();

                $notifications->push([
                    'type' => 'verification',
                    'title' => 'Certificate Verified',
                    'body' => 'Certificate row ID: ' . ($log->certificate_id ?? 'N/A') . ' — ' . ($log->ip_address ?? ''),
                    'time' => $verifiedAt->diffForHumans(),
                    'read' => $verifiedAt->lt(now()->subHours(1)),
                ]);
            });

        if ($isAdmin) {
            RoleRequest::query()
                ->where('status', 'pending')
                ->latest()
                ->limit(10)
                ->with('user')
                ->get()
                ->each(function (RoleRequest $request) use (&$notifications) {
                    $notifications->push([
                        'type' => 'role_request',
                        'title' => 'New verifier request',
                        'body' => ($request->user->name ?? 'Unknown') . ' — ' . ($request->user->email ?? ''),
                        'time' => $request->created_at?->diffForHumans() ?? '',
                        'read' => false,
                        'request_id' => $request->id,
                    ]);
                });
        }

        $merged = $notifications
            ->sortByDesc(fn ($notification) => $notification['read'] ? 0 : 1)
            ->values();

        return response()->json([
            'notifications' => $merged,
            'unread_count' => $merged->where('read', false)->count(),
        ]);
    }

    public function markAllRead()
    {
        return response()->json(['ok' => true]);
    }
}
