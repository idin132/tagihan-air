<?php
namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5);
        $search = $request->get('search');

        $cleanSearch = str_replace('.', '', $search);

        $pengeluarans = Pengeluaran::query()
            ->when($search, function ($query) use ($search, $cleanSearch) {
                return $query->where(function ($q) use ($search, $cleanSearch) {
                    $q->where('keterangan', 'like', "%{$search}%")
                        ->orWhere('biaya_pengeluaran', 'like', "%{$cleanSearch}%")
                        ->orWhere('tanggal_pengeluaran', 'like', "%{$search}%");
                });
            })
            ->latest('tanggal_pengeluaran')
            ->paginate($perPage)
            ->withQueryString();

        return view('pengeluaran.index', compact('pengeluarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'biaya_pengeluaran' => 'required|numeric',
            'keterangan' => 'required',
            'tanggal_pengeluaran' => 'required|date',
        ]);

        Pengeluaran::create($request->all());
        return response()->json(['success' => true, 'message' => 'Pengeluaran berhasil dicatat!']);
    }

    public function edit($id)
    {
        $data = Pengeluaran::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = Pengeluaran::findOrFail($id);
        $data->update($request->all());
        return response()->json(['success' => true, 'message' => 'Data pengeluaran diperbarui!']);
    }

    public function destroy($id)
    {
        Pengeluaran::destroy($id);
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
    }
}