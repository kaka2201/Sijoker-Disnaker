<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Revision;
use App\Models\User;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Ambil data documents dengan relasi user, dan lakukan pencarian
        $documents = Document::with('user')->whereHas('user', function ($query) use ($search) {
            if ($search) {
                $query->where('name', 'LIKE', "%$search%")
                      ->orWhere('email', 'LIKE', "%$search%");
            }
        })->paginate(10);

        // Manipulasi data untuk hanya mengambil nama file dari setiap dokumen
        $documents->transform(function ($document) {
            $document->ktp_filename = $document->ktp ? basename($document->ktp) : null;
            $document->kk_filename = $document->kk ? basename($document->kk) : null;
            $document->ijazah_filename = $document->ijazah ? basename($document->ijazah) : null;
            $document->ak1_filename = $document->ak1 ? basename($document->ak1) : null;
            return $document;
        });

        return view('admin.documents.index', [
            'documents' => $documents,
            'search' => $search,
        ]);
    }

    public function showFile($filename, $category)
    {
        $allowedCategories = ['ktp', 'kk', 'ijazah', 'ak1'];

        if (!in_array($category, $allowedCategories)) {
            abort(403, 'Kategori tidak valid!');
        }

        $path = storage_path("app/private/documents/{$category}/{$filename}");

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan!');
        }

        return response()->file($path);
    }
    public function updateStatusAjax(Request $request, Document $document)
    {
        // Validasi input
        $request->validate([
            'field' => 'required|string|in:ktp_status,kk_status,ijazah_status,ak1_status',
            'status' => 'required|string|in:pending,confirmed,rejected',
        ]);

        // Update status berdasarkan field yang dikirim
        $document->update([$request->field => $request->status]);

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui']);
    }
    public function message($id, Request $request)
    {
        $request->validate([
            'messages' => 'required|string',
        ]);

        $participant = User::findOrFail($id);

        Revision::updateOrCreate(
            ['user_id' => $participant->id],
            ['revisi_message' => $request->messanger]
        );

        return redirect()->back()->with('success', 'Pesan revisi berhasil dikirim ke ' . $participant->profile->name);
    }
}
