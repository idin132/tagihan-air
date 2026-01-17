<?php

namespace App\Http\Controllers;

use App\Models\Pengelola;
use Illuminate\Http\Request;

class PengelolaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5);
        $pengelolas = Pengelola::paginate($perPage)->appends(['per_page' => $perPage]);

        return view('pengelola.index', compact('pengelolas'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_pengelola' => 'required']);

        $pengelola = Pengelola::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data pengelola berhasil ditambahkan!'
        ]);
    }

    public function edit($id)
    {
        $pengelola = Pengelola::findOrFail($id);
        return response()->json($pengelola);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama_pengelola' => 'required']);

        $pengelola = Pengelola::findOrFail($id);
        $pengelola->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data pengelola berhasil diperbarui!'
        ]);
    }

    public function destroy($id)
    {
        Pengelola::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Data pengelola berhasil dihapus!'
        ]);
    }
}