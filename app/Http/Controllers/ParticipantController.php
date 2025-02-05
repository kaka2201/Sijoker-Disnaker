<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Document;
use App\Models\Revision;
use App\Models\Registration;
use App\Models\DeletionMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; 

class ParticipantController extends Controller
{
    // Menampilkan daftar peserta
    public function index(Request $request)
    {
        $query = User::with('profile')->where('role', 'user');

        // Filter berdasarkan universal search di semua kolom
        if ($request->filled('universal_search')) {
            $search = $request->universal_search;
            $query->where(function($q) use ($search) {
                $q->where('email', 'like', '%' . $search . '%')
                  ->orWhereHas('profile', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('nik', 'like', '%' . $search . '%')
                        ->orWhere('ttl', 'like', '%' . $search . '%')
                        ->orWhere('gender', 'like', '%' . $search . '%')
                        ->orWhere('jalan', 'like', '%' . $search . '%')
                        ->orWhere('desa', 'like', '%' . $search . '%')
                        ->orWhere('kecamatan', 'like', '%' . $search . '%')
                        ->orWhere('pendidikan', 'like', '%' . $search . '%')
                        ->orWhere('nomor', 'like', '%' . $search . '%');
                  });
            });
        }

        // Eksekusi query untuk mendapatkan data peserta
        $participants = $query->get();

        return view('admin.participants', [
            'participants' => $participants,
        ]);
    }

    // Menampilkan halaman detail peserta
    public function show($user_id)
    {
        // Ambil peserta berdasarkan user_id dengan eager loading dokumen terkait
        $participant = Profile::with('documents')->where('user_id', $user_id)->firstOrFail();

        // Ambil dokumen yang terkait dengan user tersebut
        $documents = Document::where('user_id', $user_id)->first();

        // Ambil email dari user dan tambahkan ke participant
        $participant->email = User::where('id', $user_id)->value('email');

        // Ambil pelatihan terdaftar berdasarkan user_id
        $registrations = Registration::with('training')
            ->where('user_id', $user_id)
            ->get();

        return view('admin.participant-detail', compact('participant', 'documents', 'registrations'));
    }

    // Menghapus peserta menggunakan user_id
    public function destroy($user_id)
    {
        // Cari pengguna berdasarkan user_id
        $participant = User::findOrFail($user_id);

        // Hapus profile terkait
        $profile = Profile::where('user_id', $user_id)->first();
        if ($profile) {
            // Hapus dokumen terkait
            $documents = Document::where('user_id', $user_id)->get();
            foreach ($documents as $document) {
                // Hapus file dokumen dari storage
                $fileFields = ['ktp', 'kk', 'ijazah', 'ak1'];
                foreach ($fileFields as $field) {
                    if ($document->$field && Storage::exists('public/' . $document->$field)) {
                        Storage::delete('public/' . $document->$field);
                    }
                }
                $document->delete(); // Hapus record dokumen dari database
            }
            $profile->delete(); // Hapus profile
        }

        // Hapus semua pendaftaran pelatihan
        Registration::where('user_id', $user_id)->delete();

        // Hapus user
        $participant->delete();

        return redirect()->route('admin.participant_management')->with('success', 'Peserta berhasil dihapus.');
    }

    // Method untuk menghapus peserta dan menyimpan pesan
    public function deleteParticipant(Request $request, $user_id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Simpan pesan ke database
        DeletionMessage::create([
            'user_id' => $user_id,
            'message' => $request->message,
        ]);

        // Panggil metode destroy untuk menghapus peserta
        $this->destroy($user_id);

        return redirect()->route('admin.participant_management')->with('success', 'Peserta berhasil dihapus dan pesan telah dicatat.');
    }

    // Konfirmasi dokumen
    public function confirmDocument($id, $type)
    {
        $document = Document::findOrFail($id);

        switch ($type) {
            case 'ktp':
                $document->ktp_status = 'confirmed';
                break;
            case 'kk':
                $document->kk_status = 'confirmed';
                break;
            case 'ijazah':
                $document->ijazah_status = 'confirmed';
                break;
            case 'ak1':
                $document->ak1_status = 'confirmed';
                break;
            default:
                return redirect()->back()->with('error', 'Tipe dokumen tidak valid.');
        }

        $document->save();

        return redirect()->back()->with('success', 'Dokumen berhasil dikonfirmasi.');
    }

    // Menolak dokumen
    public function rejectDocument($id, $type)
    {
        $document = Document::findOrFail($id);

        switch ($type) {
            case 'ktp':
                $document->ktp_status = 'rejected';
                break;
            case 'kk':
                $document->kk_status = 'rejected';
                break;
            case 'ijazah':
                $document->ijazah_status = 'rejected';
                break;
            case 'ak1':
                $document->ak1_status = 'rejected';
                break;
            default:
                return redirect()->back()->with('error', 'Tipe dokumen tidak valid.');
        }

        $document->save();

        return redirect()->back()->with('error', 'Dokumen berhasil ditolak.');
    }

    // Tandai dokumen untuk revisi
    public function markAsRevision($id, $type)
    {
        $document = Document::findOrFail($id);

        switch ($type) {
            case 'ktp':
                $document->ktp_status = 'revision';
                break;
            case 'kk':
                $document->kk_status = 'revision';
                break;
            case 'ijazah':
                $document->ijazah_status = 'revision';
                break;
            case 'ak1':
                $document->ak1_status = 'revision';
                break;
            default:
                return redirect()->back()->with('error', 'Tipe dokumen tidak valid.');
        }

        $document->save();

        return redirect()->back()->with('success', 'Dokumen ditandai untuk revisi.');
    }

    // Melihat dokumen user tanpa mendownload
    public function viewDocument($type, $user_id)
    {
        $document = Document::where('user_id', $user_id)->firstOrFail();

        switch ($type) {
            case 'ktp':
                $filePath = $document->ktp;
                break;
            case 'kk':
                $filePath = $document->kk;
                break;
            case 'ijazah':
                $filePath = $document->ijazah;
                break;
            case 'ak1':
                $filePath = $document->ak1;
                break;
            default:
                abort(404, 'Dokumen tidak ditemukan');
        }

        $path = storage_path('app/public/' . $filePath);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->stream(function () use ($path) {
            $stream = fopen($path, 'rb');
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }

    // Upload dan update dokumen peserta
    public function storeOrUpdateDocuments(Request $request)
    {
        $document = Document::firstOrCreate(['user_id' => auth()->id()]);

        if ($request->hasFile('ktp')) {
            $ktpFile = $request->file('ktp')->store('documents', 'public');
            $document->ktp = $ktpFile;
            $document->ktp_status = 'pending'; // Reset status
        }

        if ($request->hasFile('kk')) {
            $kkFile = $request->file('kk')->store('documents', 'public');
            $document->kk = $kkFile;
            $document->kk_status = 'pending'; // Reset status
        }

        if ($request->hasFile('ijazah')) {
            $ijazahFile = $request->file('ijazah')->store('documents', 'public');
            $document->ijazah = $ijazahFile;
            $document->ijazah_status = 'pending'; // Reset status
        }

        if ($request->hasFile('ak1')) {
            $ak1File = $request->file('ak1')->store('documents', 'public');
            $document->ak1 = $ak1File;
            $document->ak1_status = 'pending'; // Reset status
        }

        $document->save();

        return redirect()->back()->with('success', 'Dokumen berhasil diperbarui dan menunggu konfirmasi.');
    }

    // Ekspor data peserta ke CSV
    public function export(Request $request)
    {
        $query = User::with('profile')->where('role', 'user');

        if ($request->filled('universal_search')) {
            $search = $request->universal_search;
            $query->where(function($q) use ($search) {
                $q->where('email', 'like', '%' . $search . '%')
                ->orWhereHas('profile', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $participants = $query->get();

        $fileName = 'participants_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function() use ($participants) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Name', 'Email', 'NIK', 'TTL', 'Gender', 'Desa', 'Pendidikan', 'No. Telepon']);

            foreach ($participants as $participant) {
                fputcsv($file, [
                    $participant->profile->name ?? 'N/A',
                    $participant->email,
                    $participant->profile->nik ?? 'N/A',
                    $participant->profile->ttl ?? 'N/A',
                    $participant->profile->gender ?? 'N/A',
                    $participant->profile->desa ?? 'N/A',
                    $participant->profile->pendidikan ?? 'N/A',
                    $participant->profile->nomor ?? 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Mengirim pesan revisi
    public function sendRevision(Request $request, $id)
    {
        $request->validate([
            'revisi_message' => 'required|string',
        ]);

        $participant = User::findOrFail($id);

        Revision::create([
            'user_id' => $participant->id,
            'revisi_message' => $request->revisi_message,
        ]);

        return redirect()->back()->with('success', 'Pesan revisi berhasil dikirim ke ' . $participant->profile->name);
    }

    // Menampilkan dokumen user dan pesan revisi terakhir
    public function showDocuments()
    {
        $user = auth()->user(); // Ambil data user yang sedang login
        $profile = $user->profile; // Ambil data profile user
        $document = Document::where('user_id', $user->id)->first(); // Ambil data dokumen terkait user
        $revision = Revision::where('user_id', $user->id)->latest()->first(); // Ambil revisi terbaru untuk user

        return view('profile.documents', compact('profile', 'document', 'revision')); // Kirim data ke view
    }

    // Method untuk mendaftarkan peserta ke pelatihan
    public function registerForTraining(Request $request, $trainingId)
    {
        $userId = auth()->id();  // Ambil ID user yang sedang login

        // Cek apakah user sudah mendaftar maksimal 2 pelatihan
        $countRegistrations = Registration::where('user_id', $userId)->count();

        if ($countRegistrations >= 2) {
            // Jika sudah 2 pendaftaran, tolak dengan pesan error
            return redirect()->back()->with('error', 'Anda hanya bisa mendaftar maksimal 2 pelatihan.');
        }

        // Cek apakah user sudah terdaftar dalam pelatihan ini
        $isRegistered = Registration::where('user_id', $userId)
            ->where('training_id', $trainingId)
            ->exists();

        if ($isRegistered) {
            // Jika user sudah terdaftar dalam pelatihan ini, tampilkan pesan error
            return redirect()->back()->with('error', 'Anda sudah terdaftar dalam pelatihan ini.');
        }

        // Simpan data pendaftaran ke tabel registrations
        Registration::create([
            'user_id' => $userId,
            'training_id' => $trainingId,
            'status' => 'pending', // Tambahkan status jika diperlukan
        ]);

        return redirect()->back()->with('success', 'Anda berhasil mendaftar ke pelatihan.');
    }

    public function showDeleteMessageForm($user_id)
    {
        $participant = User::findOrFail($user_id);
        return view('admin.participant_delete', compact('participant'));
    }

    public function confirmDelete($user_id)
    {
        $participant = User::findOrFail($user_id);
        return view('admin.participant-confirm-delete', compact('participant'));
    }


}
