<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini untuk mengimpor Auth
use App\Models\Registration; // Jangan lupa untuk mengimpor model Registration jika digunakan

class CourseController extends Controller
{
    public function index()
    {
        // Anda bisa mengirim data tambahan jika diperlukan
        return view('courses.index');
    }

    public function register(Request $request)
{
    $userId = Auth::id();  // Ambil ID user yang sedang login
    $trainingId = $request->input('training_id');

    // Cek apakah user sudah terdaftar dalam pelatihan ini
    $isRegistered = Registration::where('user_id', $userId)
        ->where('training_id', $trainingId)
        ->exists();

    if ($isRegistered) {
        return redirect()->back()->with('error', 'Anda sudah terdaftar dalam pelatihan ini.');
    }

    // Simpan data pendaftaran ke tabel registrations
    Registration::create([
        'user_id' => $userId,
        'training_id' => $trainingId,
        'status' => 'pending',
    ]);

    return redirect()->route('home')->with('success', 'Anda berhasil mendaftar ke pelatihan.');
}

}
