<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all(); // Ambil semua data user dari database
        $pencakerCount = User::where('role', 'pencaker')->count(); // Tambahkan query untuk menghitung jumlah pencaker

        // Misalkan Anda juga membutuhkan jumlah training, misal dari model Training
        // $trainingCount = Training::count(); // Anggap saja ini query yang diperlukan
        
        // Kirim semua data yang diperlukan ke view
        return view('admin.dashboard', compact('users', 'pencakerCount', 'trainingCount'));
    }
}
