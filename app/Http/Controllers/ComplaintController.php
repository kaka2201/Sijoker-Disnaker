<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('question', 'like', '%' . $request->search . '%');
        }

        $complaints = $query->latest()->paginate(5); // Menampilkan 5 komplain per halaman
        return view('complaints.index', compact('complaints'));
    }

    public function admin(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');

        $complaints = Complaint::query();

        // Filter berdasarkan status
        if ($status === 'not answered') {
            $complaints->where('status', 'pending');
        } elseif ($status === 'answered') {
            $complaints->where('status', 'answered');
        }

        // Filter berdasarkan pencarian (judul atau isi pengaduan)
        if ($search) {
            $complaints->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%$search%")
                      ->orWhere('question', 'LIKE', "%$search%");
            });
        }

        return view('admin.complaints.index', [
            'complaints' => $complaints->paginate(10),
            'search' => $search, // Untuk mempertahankan input pencarian
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'question' => 'required',
        ]);

        if(Auth::user()->hasRole('user')){
            Complaint::create([
                'questioner_id' => Auth::id(),
                'title' => $request->title,
                'question' => $request->question,
            ]);
    
            return redirect()->back()->with('success', 'Complaint submitted successfully!');
        }
        return redirect()->back()->with('error', 'You are not authorized to complaint.');
    }

    public function show($id, Request $request)
    {
        $layout = $request->input('layout');
        $complaint = Complaint::findOrFail($id);
        if($layout == 'admin'){
            return view('admin.complaints.show', compact('complaint'));
        }else{
            return view('complaints.show', compact('complaint'));
        }
    }

    public function answer(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required',
        ]);

        $complaint = Complaint::findOrFail($id);

        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super_admin')) {
            $complaint->update([
                'responsible_id' => Auth::id(),
                'answer' => $request->answer,
                'status' => 'answered',
            ]);

            return redirect()->back()->with('success', 'Complaint answered successfully!');
        }

        return redirect()->back()->with('error', 'You are not authorized to answer this complaint.');
    }

    public function like($id)
    {
        $complaint = Complaint::findOrFail($id);
        $user = auth()->user();
    
        if ($user->hasLiked($complaint)) {
            // Jika sudah like, maka unlike
            $user->likes()->where('complaint_id', $id)->delete();
            $complaint->decrement('likes');
        } else {
            // Jika belum, maka like
            $user->likes()->create(['complaint_id' => $id]);
            $complaint->increment('likes');
        }
    
        return response()->json([
            'success' => true,
            'likes_count' => $complaint->likes()->count()
        ]);
    }

    public function destroy($id)
    {
        // Cari keluhan berdasarkan ID
        $complaint = Complaint::findOrFail($id);

        // Hapus keluhan
        $complaint->delete();

        // Redirect atau response JSON
        return redirect()->back()->with('success', 'Complaint deleted successfully.');
    }
}
