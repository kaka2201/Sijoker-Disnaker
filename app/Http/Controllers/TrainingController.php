<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{
    // Menampilkan daftar pelatihan dengan pagination dan pencarian berdasarkan judul
    public function index(Request $request)
    {
        // Ambil input pencarian dari request (jika ada)
        $search = $request->input('search');

        // Query dasar untuk mengambil pelatihan
        $query = Training::query();

        // Jika ada input pencarian, tambahkan kondisi 'like' untuk judul
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Ambil pelatihan dengan pagination (9 per halaman)
        $trainings = $query->paginate(9);

        // Kirim hasil pencarian dan data pelatihan ke view admin
        return view('admin.trainings', compact('trainings', 'search'));
    }

    // Menampilkan form tambah pelatihan
    public function create()
    {
        return view('admin.training-create');
    }

    // Menyimpan pelatihan baru ke database
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'nullable|date',
            'end_time' => 'nullable',
            'capacity' => 'required|integer',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Simpan data pelatihan baru
        $training = new Training();
        $training->title = $request->title;
        $training->description = $request->description;
        $training->start_date = $request->start_date;
        $training->start_time = $request->start_time;
        $training->end_date = $request->end_date;
        $training->end_time = $request->end_time;
        $training->capacity = $request->capacity;
        $training->location = $request->location;

        // Jika ada gambar yang di-upload, simpan gambar ke storage
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $training->image = $path;
        }

        $training->save();

        // Redirect setelah sukses
        return redirect()->route('trainings.index')->with('success', 'Pelatihan berhasil ditambahkan.');
    }

    // Menampilkan form edit pelatihan
    public function edit($id)
    {
        // Temukan pelatihan berdasarkan ID
        $training = Training::findOrFail($id);

        // Return view dengan data pelatihan
        return view('admin.training-edit', compact('training'));
    }

    // Menyimpan perubahan pelatihan ke database
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'nullable|date',
            'end_time' => 'nullable',
            'capacity' => 'required|integer',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Temukan pelatihan berdasarkan ID
        $training = Training::findOrFail($id);

        // Update data pelatihan
        $training->title = $request->input('title');
        $training->description = $request->input('description');
        $training->start_date = $request->input('start_date');
        $training->start_time = $request->input('start_time');
        $training->end_date = $request->input('end_date');
        $training->end_time = $request->input('end_time');
        $training->capacity = $request->input('capacity');
        $training->location = $request->input('location');

        // Jika ada gambar baru yang di-upload, hapus gambar lama lalu simpan gambar baru
        if ($request->hasFile('image')) {
            if ($training->image) {
                Storage::delete('public/' . $training->image); // Hapus gambar lama
            }
            $path = $request->file('image')->store('images', 'public'); // Simpan gambar baru
            $training->image = $path;
        }

        $training->save();

        // Setelah sukses, arahkan kembali ke halaman daftar pelatihan
        return redirect()->route('trainings.index')->with('success', 'Pelatihan berhasil diperbarui.');
    }

    // Menghapus pelatihan dari database
    public function destroy($id)
    {
        // Temukan pelatihan berdasarkan ID
        $training = Training::findOrFail($id);

        // Hapus gambar terkait jika ada
        if ($training->image) {
            Storage::delete('public/' . $training->image);
        }

        // Hapus pelatihan
        $training->delete();

        // Setelah sukses, arahkan kembali ke halaman daftar pelatihan
        return redirect()->route('trainings.index')->with('success', 'Pelatihan berhasil dihapus.');
    }

    // Menampilkan peserta pelatihan
    public function showParticipants($id, Request $request)
    {
        // Ambil pelatihan berdasarkan ID
        $training = Training::findOrFail($id);

        // Query untuk ambil peserta yang mendaftar di pelatihan ini
        $query = User::with('profile')
            ->whereHas('registrations', function ($q) use ($id) {
                $q->where('training_id', $id);
            });

        // Jika ada input pencarian, tambahkan kondisi 'like' untuk nama atau email
        if ($request->filled('universal_search')) {
            $search = $request->input('universal_search');
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', '%' . $search . '%')
                    ->orWhereHas('profile', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $participants = $query->get();

        return view('admin.training-participants', compact('training', 'participants'));
    }

    // Export data peserta pelatihan ke CSV
    public function exportParticipants($id)
    {
        $training = Training::findOrFail($id);
        $participants = User::with('profile')
            ->whereHas('registrations', function ($q) use ($id) {
                $q->where('training_id', $id);
            })
            ->get();

        $fileName = 'participants_training_' . $training->id . '.csv';
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($participants) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Email', 'NIK', 'TTL', 'Gender', 'Desa', 'Kecamatan', 'No. Telepon']);
            foreach ($participants as $participant) {
                fputcsv($file, [
                    $participant->profile->name ?? 'N/A',
                    $participant->email,
                    $participant->profile->nik ?? 'N/A',
                    $participant->profile->ttl ?? 'N/A',
                    $participant->profile->gender ?? 'N/A',
                    $participant->profile->desa ?? 'N/A',
                    $participant->profile->kecamatan ?? 'N/A',
                    $participant->profile->nomor ?? 'N/A',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Method untuk preview pendaftaran ke pelatihan
    public function preview($trainingId)
    {
        // Ambil profil user yang sedang login
        $profile = auth()->user()->profile;
        
        // Ambil data pelatihan berdasarkan ID
        $training = Training::findOrFail($trainingId);

        // Return view preview profil dengan data profil user dan data pelatihan
        return view('trainings.preview', compact('profile', 'training'));
    }

    // Method untuk mendaftarkan peserta ke pelatihan
    public function register(Request $request, $trainingId)
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
}
