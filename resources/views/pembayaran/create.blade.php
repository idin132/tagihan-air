@extends('layouts.sidebar')

@section('title', 'Tambah Tagihan')
@section('header', 'Input Tagihan Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
        <form action="{{ route('pembayaran.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Pelanggan</label>
                    <select name="No_Pelanggan" class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500 py-3">
                        <option value="">-- Cari Nama Pelanggan --</option>
                        @foreach($pelanggans as $p)
                            <option value="{{ $p->no_pelanggan }}">{{ $p->nama_pelanggan }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Bulan Tagihan</label>
                    <input type="month" name="Bulan" class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500 py-2.5">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Bayar</label>
                    <input type="date" name="Tanggal_Pembayaran" value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500 py-2.5">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stand Meter Awal</label>
                    <input type="number" id="meter_awal" name="Stand_Meter_Awal" class="w-full rounded-xl border-slate-200 bg-slate-50 py-2.5" placeholder="0">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stand Meter Akhir</label>
                    <input type="number" id="meter_akhir" name="Stand_Meter_Akhir" class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500 py-2.5" placeholder="0">
                </div>
            </div>

            <div class="bg-blue-50 p-4 rounded-xl flex items-center justify-between">
                <div>
                    <p class="text-xs text-blue-600 font-bold uppercase tracking-wider">Estimasi Tagihan</p>
                    <h2 class="text-2xl font-black text-blue-800" id="display_tagihan">Rp 0</h2>
                </div>
                <div class="text-right">
                    <p class="text-xs text-blue-600 font-medium">Total Pakai</p>
                    <p class="text-lg font-bold text-blue-800" id="display_total">0 m³</p>
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-slate-100">
                <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition">Simpan Data</button>
                <button type="reset" class="px-6 py-3 border border-slate-200 rounded-xl text-slate-500 font-semibold hover:bg-slate-50">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Logic sederhana untuk auto-calculate tagihan
    const meterAwal = document.getElementById('meter_awal');
    const meterAkhir = document.getElementById('meter_akhir');
    const displayTotal = document.getElementById('display_total');
    const displayTagihan = document.getElementById('display_tagihan');
    const hargaPerMeter = 5000;

    function hitung() {
        let total = parseInt(meterAkhir.value) - parseInt(meterAwal.value);
        if (total > 0) {
            displayTotal.innerText = total + " m³";
            displayTagihan.innerText = "Rp " + (total * hargaPerMeter).toLocaleString('id-ID');
        } else {
            displayTotal.innerText = "0 m³";
            displayTagihan.innerText = "Rp 0";
        }
    }

    meterAwal.addEventListener('input', hitung);
    meterAkhir.addEventListener('input', hitung);
</script>
@endsection