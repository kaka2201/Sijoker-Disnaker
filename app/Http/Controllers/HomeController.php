<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // Method untuk menampilkan halaman home dengan data pelatihan
    public function index()
    {
        // Ambil semua data pelatihan dari database
        $trainings = Training::all();

        // Kirim data pelatihan ke view home
        return view('home', compact('trainings'));
    }

    // Method untuk menampilkan halaman review profil user
    public function showProfilePreview()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        if (!$profile) {
            return redirect()->route('profile')->with('error', 'Profil belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        return view('trainings.preview', compact('profile'));
    }

    // Method untuk mendaftarkan user ke pelatihan
    public function registerCourse(Request $request)
    {
        // Logic untuk mendaftarkan user ke pelatihan di sini
        // Misal tambahkan data user ke tabel pendaftaran pelatihan, dsb.
        
        return redirect()->route('home')->with('success', 'Anda berhasil mendaftar ke pelatihan.');
    }
}