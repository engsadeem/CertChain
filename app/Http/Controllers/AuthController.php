<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use App\Models\User;
use App\Notifications\RoleRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->with('error', 'Email or password is incorrect.');
        }

        if (!Auth::user()->is_active) {
            Auth::logout();

            return redirect()->back()
                ->withInput($request->only('email'))
                ->with('error', 'This account is pending admin approval.');
        }

        $request->session()->regenerate();

        return redirect('/dashboard');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'institution' => 'required|string|max:255',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'institution' => $request->institution,
            'password'    => Hash::make($request->password),
            'role'        => 'verifier',
            'is_active'   => false,
        ]);

        $roleRequest = RoleRequest::create([
            'user_id' => $user->id,
            'requested_role' => 'verifier',
            'status' => 'pending',
        ]);

        User::where('role', 'admin')->get()->each(function (User $admin) use ($roleRequest, $user) {
            $admin->notify(new RoleRequestNotification(
                requestId: $roleRequest->id,
                userId: $user->id,
                userName: $user->name,
                email: $user->email
            ));
        });

        $request->session()->regenerate();

        return redirect()
            ->route('login')
            ->with('ok', 'Registration sent. Please wait for admin approval.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showLoginForm()
    {
        return view('login', ['activeTab' => 'login']);
    }

    public function showRegisterForm()
    {
        return view('login', ['activeTab' => 'register']);
    }
}
