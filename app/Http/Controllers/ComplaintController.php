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

        $complaints = $query->latest()->paginate(5);
        return view('complaints.index', compact('complaints'));
    }

    public function admin(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');

        $complaints = Complaint::query();

        if ($status === 'not answered') {
            $complaints->where('status', 'pending');
        } elseif ($status === 'answered') {
            $complaints->where('status', 'answered');
        }

        if ($search) {
            $complaints->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%$search%")
                      ->orWhere('question', 'LIKE', "%$search%");
            });
        }

        return view('admin.complaints.index', [
            'complaints' => $complaints->paginate(10),
            'search' => $search,
        ]);
    }

    public function store(Request $request, $id = null)
    {
        $request->validate([
            'title' => 'nullable',
            'question' => 'required',
        ]);

        if (!Auth::check() || !Auth::user()->hasRole('user')) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan untuk mengajukan Pengaduan.');
        }

        $pendingComplaints = Complaint::where('questioner_id', Auth::id())
            ->where('status', 'not answered')
            ->count();

        if ($pendingComplaints >= 3) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengajukan Pengaduan baru hingga setidaknya satu telah dijawab.');
        }

        $complaint = Complaint::find($id);

        if (!$complaint) {
            $complaint = Complaint::create([
                'questioner_id' => Auth::id(),
                'title' => $request->title,
            ]);
        }
        $detailCount = ComplaintDetail::where('complaint_id', $complaint->id)->count();

        if ($detailCount < 3) {
            ComplaintDetail::create([
                'complaint_id' => $complaint->id,
                'question' => $request->question,
            ]);
            $complaint->status = 'not answered';
            $complaint->save();

            return redirect()->back()->with('success', 'Pertanyaan berhasil ditambahkan.');
        }

        return redirect()->back()->with('error', 'Anda hanya dapat mengajukan maksimal 3 pertanyaan per pengaduan.');
    }

    public function show($id, Request $request)
    {
        $layout = $request->input('layout');
        $complaint = Complaint::with('details')->findOrFail($id);
        if ($layout == 'admin') {
            return view('admin.complaints.show', compact('complaint'));
        } else {
            return view('complaints.show', compact('complaint'));
        }
    }

    public function answer(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required|string|max:1000',
        ]);

        $detail = ComplaintDetail::findOrFail($id);
        $complaint = Complaint::findOrFail($detail->complaint_id);

        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super_admin')) {
            $detail->update([
                'answer' => $request->answer,
            ]);
            if ($complaint->responsible_id === null) {
                $complaint->update([
                    'responsible_id' => Auth::id(),
                    'status' => 'answered',
                ]);

                return redirect()->back()->with('success', 'Pengaduan berhasil dijawab!');
            } else {
                $complaint->update([
                    'status' => 'answered',
                ]);
                return redirect()->back()->with('error', 'Pengaduan ini sudah memiliki penanggung jawab!');
            }
        }
    
        return redirect()->back()->with('error', 'Anda tidak diizinkan untuk menjawab Pengaduan ini.');
    }

    public function like($id)
    {
        $complaint = Complaint::findOrFail($id);
        $user = auth()->user();
    
        if ($user->hasLiked($complaint)) {
            $user->likes()->where('complaint_id', $id)->delete();
            $complaint->decrement('likes');
        } else {
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
        $complaint = Complaint::findOrFail($id);
        $complaint->delete();
        return redirect()->back()->with('success', 'Pengaduan berhasil dihapus.');
    }
}