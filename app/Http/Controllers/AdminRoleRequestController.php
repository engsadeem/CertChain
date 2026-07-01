<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use App\Models\User;
use App\Notifications\RoleRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRoleRequestController extends Controller
{
    private function ensureAdmin(): void
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403);
        }
    }


    public function pending()
    {
        $this->ensureAdmin();

        $requests = RoleRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('dashboard.admin.role-requests', compact('requests'));
    }

    public function accept(int $id)
    {
        $this->ensureAdmin();

        $req = RoleRequest::with('user')->findOrFail($id);
        if ($req->status !== 'pending') {
            return redirect()->back();
        }

        $req->status = 'accepted';
        $req->decided_at = now();
        $req->decided_by = Auth::id();
        $req->save();

        $req->user->role = $req->requested_role;
        $req->user->is_active = true;
        $req->user->save();

        return redirect()->back()->with('ok', 'Request accepted');
    }

    public function reject(int $id)
    {
        $this->ensureAdmin();

        $req = RoleRequest::with('user')->findOrFail($id);
        if ($req->status !== 'pending') {
            return redirect()->back();
        }

        $req->status = 'rejected';
        $req->decided_at = now();
        $req->decided_by = Auth::id();
        $req->save();

        // اتركه غير مفعّل
        $req->user->is_active = false;
        $req->user->save();

        return redirect()->back()->with('ok', 'Request rejected');
    }
}

