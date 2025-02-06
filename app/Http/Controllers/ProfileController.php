<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Profile;
use App\Models\Document;
use App\Models\Revision;
use App\Models\Registration; 
use App\Models\Training;
use App\Models\WithdrawalReason; // Pastikan model ini sudah ada
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan halaman utama profil
    public function profile()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $profile = Profile::where('user_id', $user->id)->first();

        if (!$profile) {
            return redirect()->route('profile')->with('error', 'Profil tidak ditemukan, silakan lengkapi terlebih dahulu.');
        }

        return view('profile.profile', compact('profile', 'user'));
    }

    // Menampilkan halaman dokumen
    public function showDocuments()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $profile = Profile::where('user_id', $user->id)->first();
        
        if (!$profile) {
            return redirect()->route('profile')->with('error', 'Profil tidak ditemukan, silakan lengkapi terlebih dahulu.');
        }

        $document = Document::where('user_id', $user->id)->first();
        $revision = Revision::where('user_id', $user->id)->latest()->first();

        return view('profile.documents', compact('profile', 'document', 'revision'));
    }

    // Menampilkan halaman ganti password
    public function showChangePassword()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $profile = Profile::where('user_id', $user->id)->first();

        return view('profile.change-password', compact('profile', 'user'));
    }

    // Method untuk menambahkan atau memperbarui profil
    public function storeOrUpdateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|digits:16|regex:/^[0-9]+$/',
            'ttl' => 'required|date',
            'gender' => 'required|in:pria,wanita',
            'kecamatan' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'jalan' => 'required|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'nomor' => 'required|regex:/^[0-9]+$/',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        $user = Auth::user();
        $profile = Profile::firstOrNew(['user_id' => $user->id]);

        $profile->fill($request->only([
            'name', 'nik', 'ttl', 'gender', 'kecamatan', 'desa', 'jalan', 'pendidikan', 'nomor'
        ]));

        if ($request->hasFile('foto')) {
            if (!empty($profile->foto) && Storage::disk('public')->exists($profile->foto)) {
                Storage::disk('public')->delete( $profile->foto);
            }

            $file = $request->file('foto');
            $path = $file->store('profile_pictures', 'public');
            $profile->foto = $path;
        }

        $profile->save();

        return redirect()->back()->with('success', 'Profil berhasil disimpan.');
    }

    // Menyimpan atau memperbarui dokumen
    public function storeOrUpdateDocuments(Request $request)
    {
        $request->validate([
            'ktp' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:1024',
            'kk' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:1024',
            'ijazah' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:1024',
            'ak1' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:1024',
        ]);

        $user = Auth::user();
        $document = Document::firstOrNew(['user_id' => $user->id]);

        if ($request->hasFile('ktp')) {
            $ktpFile = $request->file('ktp')->store('documents', 'public');
            $document->ktp = $ktpFile;
            $document->ktp_status = 'pending';
        }

        if ($request->hasFile('kk')) {
            $kkFile = $request->file('kk')->store('documents', 'public');
            $document->kk = $kkFile;
            $document->kk_status = 'pending';
        }

        if ($request->hasFile('ijazah')) {
            $ijazahFile = $request->file('ijazah')->store('documents', 'public');
            $document->ijazah = $ijazahFile;
            $document->ijazah_status = 'pending';
        }

        if ($request->hasFile('ak1')) {
            $ak1File = $request->file('ak1')->store('documents', 'public');
            $document->ak1 = $ak1File;
            $document->ak1_status = 'pending';
        }

        $document->save();

        return redirect()->route('profile.documents')->with('success', 'Dokumen berhasil diunggah dan menunggu konfirmasi.');
    }

    // Mengubah password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'new_password.min' => 'Kata sandi baru minimal 8 karakter.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Kata sandi saat ini salah.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diubah.');
    }

    // Cek kelengkapan profil
    public function checkProfileCompletion(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        $isProfileComplete = $profile &&
            $profile->name && $profile->nik && $profile->ttl && $profile->gender &&
            $profile->kecamatan && $profile->desa && $profile->jalan &&
            $profile->pendidikan && $profile->nomor;

        return response()->json(['status' => $isProfileComplete ? 'complete' : 'incomplete']);
    }

    // Preview profil pengguna
    public function preview()
    {
        $user = Auth::user();
        $profile = $user->profile;

        \Log::info('Preview Profile:', ['profile' => $profile]);

        $isProfileComplete = $profile && $profile->name && $profile->nik;

        if ($isProfileComplete) {
            return response()->json([
                'status' => 'complete',
                'profile' => [
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ]);
        } else {
            return response()->json(['status' => 'incomplete']);
        }
    }

    // Menampilkan halaman preview profil
    public function showPreview()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        if (!$profile) {
            return redirect()->route('profile')->with('error', 'Profil tidak ditemukan, silakan lengkapi terlebih dahulu.');
        }

        return view('profile.preview', compact('profile'));
    }

    // Menampilkan halaman pelatihan yang diikuti
    public function showTrainings()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
 
        // Ambil profil user
        $profile = Profile::where('user_id', $user->id)->first();

        // Ambil data pelatihan yang diikuti oleh user dari tabel registrations
        $registrations = Registration::with('training')
            ->where('user_id', $user->id)
            ->get();

        // Mengirim data ke view 'profile.training'
        return view('profile.training', compact('registrations', 'profile'));
    }

    // Mengundurkan diri dari pelatihan
    public function withdraw(Request $request, $trainingId)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $user = Auth::user();

        // Simpan alasan pengunduran diri
        WithdrawalReason::create([
            'user_id' => $user->id,
            'training_id' => $trainingId,
            'reason' => $request->reason,
        ]);

        // Hapus registrasi pelatihan
        Registration::where('user_id', $user->id)
            ->where('training_id', $trainingId)
            ->delete();

        return redirect()->route('trainings')->with('success', 'Anda telah mengundurkan diri dari pelatihan.');
    }

    public function show($id)
    {
        $profile = Profile::where('user_id', $id)->firstOrFail();

        return view('profile.show', compact('profile'));
    }
}
