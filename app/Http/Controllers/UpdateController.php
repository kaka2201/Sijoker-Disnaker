<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function updateProfile(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => [
                'required',
                'digits:16', // harus 16 digit
                'regex:/^[0-9]+$/' // hanya boleh angka
            ],
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:pria,wanita',
            'kecamatan' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'jalan' => 'required|string|max:255',
            'pendidikan_terakhir' => 'required|string|max:255',
            'no_telpon' => [
                'required',
                'regex:/^[0-9]+$/' // hanya boleh angka
            ],
            'pas_foto' => 'required|image|mimes:jpeg,png,jpg|max:5120', // maksimal 5MB (5120 KB)
        ], [
            'nik.regex' => 'NIK harus berupa angka tanpa huruf.',
            'nik.digits' => 'NIK harus berjumlah 16 digit.',
            'no_telpon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'pas_foto.max' => 'Ukuran pas foto tidak boleh lebih dari 5MB.',
        ]);

        // Proses penyimpanan data ke dalam database
        // Lanjutkan proses penyimpanan
    }
}

