<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    private function ensureAdmin(): void
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $users = User::query()->orderBy('created_at', 'desc')->get();

        $usersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $pendingRoleRequests = RoleRequest::with('user')
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard.users', compact('users', 'usersThisMonth', 'pendingRoleRequests'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'role'                  => 'required|in:admin,verifier',
            'password'              => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'password'  => Hash::make($request->password),
            'is_active' => true,
        ]);

        return redirect()->route('dashboard.users')->with('ok', 'User created successfully.');
    }

    public function update(Request $request, int $id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);
        if (Auth::user()->id === $user->id) {
            abort(403);
        }

        $request->validate([
            'role' => 'required|in:admin,verifier,registrar,viewer',
            'is_active' => 'required|boolean',
        ]);

        $user->role = $request->input('role');
        $user->is_active = $request->boolean('is_active');
        $user->save();

        return redirect()->route('dashboard.users')->with('ok', 'User updated');
    }

    public function destroy(int $id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);
        if (Auth::user()->id === $user->id) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('dashboard.users')->with('ok', 'User removed');
    }
}

