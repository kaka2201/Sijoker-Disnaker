<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Menampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        // Coba melakukan login dengan kredensial
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Regenerasi session untuk keamanan
        
            $user = Auth::user(); // Ambil role pengguna yang login
        
            // Redirect sesuai role
            if ($user->hasRole('admin') || $user->hasRole('super_admin')) {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/'); // Redirect ke homepage jika user biasa
            }
        }
    
        // Jika kredensial salah, redirect dengan pesan error
        return redirect()->route('login')
                         ->withErrors(['email' => 'Email atau kata sandi salah.'])
                         ->withInput();
    }

    // Proses registrasi
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Membuat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        
        // Assign role ke user
        $user->assignRole('user');
    
        // Membuat profile
        Profile::create([
            'user_id' => $user->id,
            'name' => $user->name,
        ]);
    
        // Login user
        Auth::login($user);
    
        // Ambil user yang sedang login
        $auth = Auth::user();
    
        // Pengalihan berdasarkan role
        if ($auth->hasRole('admin') || $auth->hasRole('super_admin')) {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/');
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout(); // Logout user
        $request->session()->invalidate(); // Invalidate session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect('/'); // Redirect ke homepage setelah logout
    }
}
