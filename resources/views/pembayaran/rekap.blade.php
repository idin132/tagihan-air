<div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
    <h3 class="text-lg font-bold text-slate-800 mb-4">Statistik Bulan {{ $bulan }}</h3>
    
    @if($dataRekap)
    <div class="grid grid-cols-2 gap-6">
        <div class="p-4 bg-blue-50 rounded-2xl">
            <p class="text-xs text-blue-500 font-bold uppercase">Total Transaksi</p>
            <p class="text-2xl font-black text-blue-800">{{ $dataRekap->jumlah_transaksi }}</p>
        </div>
        <div class="p-4 bg-emerald-50 rounded-2xl">
            <p class="text-xs text-emerald-500 font-bold uppercase">Total Pendapatan</p>
            <p class="text-2xl font-black text-emerald-800">Rp {{ number_format($dataRekap->total_pendapatan, 0, ',', '.') }}</p>
        </div>
    </div>
    @else
        <p class="text-slate-400 italic text-sm">Data tidak ditemukan untuk bulan ini.</p>
    @endif
</div>