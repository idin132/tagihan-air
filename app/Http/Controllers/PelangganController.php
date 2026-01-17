<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        // Tangkap jumlah per halaman dari request, defaultnya 5
        $perPage = $request->get('per_page', 5);

        // Gunakan paginate() sebagai pengganti all()
        // appends() digunakan agar saat pindah halaman, jumlah per_page tetap terjaga
        $pelanggans = Pelanggan::paginate($perPage)->appends(['per_page' => $perPage]);
        return view('pelanggan.index', compact('pelanggans'));
    }

    // Simpan Pelanggan Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'alamat_pelanggan' => 'required',
        ]);

        $pelanggan = Pelanggan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data pelanggan berhasil ditambahkan!',
            'data' => $pelanggan
        ]);
    }

    // Ambil data untuk Edit (tampil di modal)
    public function edit($id)
    {
        $pelanggan = Pelanggan::find($id);
        return response()->json($pelanggan);
    }

    // Update Data
    public function update(Request $request, $id)
    {
        // SESUAIKAN: Gunakan huruf kecil agar sama dengan AJAX
        $request->validate([
            'nama_pelanggan' => 'required',
            'alamat_pelanggan' => 'required',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);

        $pelanggan->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data pelanggan berhasil diperbarui!'
        ]);
    }

    // Hapus Data
    public function destroy($id)
    {
        Pelanggan::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data pelanggan berhasil dihapus!'
        ]);
    }
}