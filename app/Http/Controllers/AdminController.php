<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Training;
use App\Models\DeletionReason; // Import DeletionReason model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Mengambil data user dengan profile
        $users = User::with('profile')->get();

        // Filter user yang memiliki role 'user'
        $users = $users->filter(fn($user) => $user->hasRole('user'));

        // Menghitung jumlah pengguna dengan role 'user'
        $pencakerCount = User::role('user')->count();

        // Menghitung jumlah pelatihan yang tersedia
        $trainingCount = Training::count();

        // Menghitung desa dengan jumlah peserta tertinggi
        $desaTertinggi = Profile::select('desa')
            ->selectRaw('count(*) as total_peserta')
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->whereHas('user.roles', function ($query) {
                $query->where('name', 'user'); // Sesuaikan role
            })
            ->groupBy('desa')
            ->orderByDesc('total_peserta')
            ->first();

        // Data desa untuk diagram batang

        $desaData = Profile::select('desa', DB::raw('count(*) as total'))
            ->whereHas('user.roles', function ($query) {
                $query->where('name', 'admin'); // Filter hanya yang memiliki role "admin"
            })
            ->groupBy('desa')
            ->get();

        // Data kecamatan untuk diagram batang
        $kecamatanData = Profile::select('kecamatan', DB::raw('count(*) as total'))
            ->whereHas('user.roles', function ($query) {
                $query->where('name', 'admin'); // Filter hanya yang memiliki role "admin"
            })
            ->groupBy('kecamatan')
            ->get();

        // Menghitung jumlah peserta per pelatihan
        $trainingParticipants = Training::leftJoin('registrations', 'trainings.id', '=', 'registrations.training_id')
            ->select('trainings.title', DB::raw('COUNT(registrations.user_id) as total_peserta'))
            ->groupBy('trainings.title')
            ->get();

        // Kirim data ke view dashboard
        return view('admin.dashboard', compact(
            'users', 
            'pencakerCount', 
            'trainingCount', 
            'desaTertinggi', 
            'desaData', 
            'kecamatanData', 
            'trainingParticipants'
        ));
    }

    public function indexDashboard()
    {
        // Menghitung jumlah pencaker aktif dari database
        $pencakerCount = User::where('status', 'aktif')->count();

        // Kirim data $pencakerCount ke view
        return view('admin.dashboard', compact('pencakerCount'));
    }

    public function accountParticipants()
    {
        // Mengambil semua data user dari database
        $users = User::all();

        // Mengirim data user ke view account participants
        return view('admin.account-participant', compact('users'));
    }

    public function changeRole($id)
    {
        // Ambil user berdasarkan ID
        $user = User::findOrFail($id);

        // Mengubah role: jika 'user' maka ganti ke 'admin', jika 'admin' ganti ke 'user'
        if ($user->hasRole('user')) {
            $user->removeRole('user');
            $user->assignRole('admin');
        } else {
            $user->removeRole('admin');
            $user->assignRole('user');
        }

        // Simpan perubahan role
        $user->save();

        // Redirect kembali ke halaman daftar akun peserta dengan pesan sukses
        return redirect()->route('admin.account_participants')->with('success', 'Role pengguna berhasil diubah.');
    }

    // Menampilkan daftar pengunduran diri yang belum diverifikasi
    public function withdrawalRequests()
    {
        $withdrawalRequests = DeletionReason::where('status', 'pending')->with('user', 'admin')->get();
        return view('admin.withdrawals', compact('withdrawalRequests'));
    }

    // Verifikasi pengunduran diri
    public function verifyWithdrawal($id)
    {
        $withdrawal = DeletionReason::findOrFail($id);
        $withdrawal->status = 'verified'; // Ubah status menjadi terverifikasi
        $withdrawal->save();

        // Hapus pendaftaran pelatihan setelah verifikasi
        DB::table('registrations')
            ->where('user_id', $withdrawal->user_id)
            ->delete();

        return redirect()->route('admin.withdrawals')->with('success', 'Pengunduran diri telah diverifikasi dan pengguna telah dikeluarkan dari pelatihan.');
    }

    // Menolak pengunduran diri
    public function rejectWithdrawal($id)
    {
        $withdrawal = DeletionReason::findOrFail($id);
        $withdrawal->status = 'rejected'; // Ubah status menjadi ditolak
        $withdrawal->save();

        return redirect()->route('admin.withdrawals')->with('success', 'Pengunduran diri telah ditolak.');
    }

    // Menampilkan riwayat penghapusan peserta
    public function deletionHistory()
    {
        $deletionHistory = DeletionReason::with('user', 'admin')->get();
        return view('admin.deletion-history', compact('deletionHistory'));
    }

    // Menghapus peserta oleh admin dengan alasan
    public function deleteParticipant(Request $request, $user_id)
    {
        $request->validate([
            'reason' => 'required|string',
        ]);

        $user = User::findOrFail($user_id);

        // Log alasan penghapusan peserta
        DeletionReason::create([
            'user_id' => $user->id,
            'admin_id' => auth()->id(),
            'reason' => $request->reason,
            'status' => 'pending', // Default status pending
        ]);

        // Hapus peserta
        $user->delete();

        return redirect()->route('admin.deletionHistory')->with('success', 'Peserta telah dihapus dan alasan penghapusan telah dicatat.');
    }

    // Verifikasi penghapusan peserta
    public function verifyDeletion($id)
    {
        $deletion = DeletionReason::findOrFail($id);
        $deletion->status = 'verified'; // Ubah status menjadi terverifikasi
        $deletion->save();

        return redirect()->route('admin.deletionHistory')->with('success', 'Penghapusan peserta telah diverifikasi.');
    }
}
