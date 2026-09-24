<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =========================
    // HALAMAN LOGIN
    // =========================
    public function showLogin()
    {
        return view('auth.login');
    }

    // =========================
    // PROSES LOGIN
    // =========================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // Jika admin
            if ($user->role === 'admin') {
                return redirect()->route('dashboard.admin');
            }

            // Jika pembeli
            if ($user->role === 'pembeli') {
                return redirect()->route('dashboard.pembeli');
            }

            // Jika kasir
            if ($user->role === 'kasir') {
                return redirect()->route('dashboard.kasir');
            }

            return redirect()->route('dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->withInput();
    }

    // =========================
    // HALAMAN REGISTER
    // =========================
    public function showRegister()
    {
        return view('auth.register');
    }

    // =========================
    // PROSES REGISTER
    // =========================
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email',

            'password' => 'required|min:6|confirmed',

            'role' => 'required|in:pembeli,kasir',
        ]);

        User::create([
            'name' => $validated['name'],

            'email' => $validated['email'],

            'password' => Hash::make($validated['password']),

            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
