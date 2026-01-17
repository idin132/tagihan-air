@extends('layouts.sidebar')

@section('title', 'Dashboard')
@section('header', 'Dashboard Ringkasan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center shadow-inner">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Pelanggan</p>
                <h3 class="text-3xl font-black text-slate-800">{{ number_format($totalPelanggan) }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner">
                <i class="fas fa-file-invoice-dollar text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Transaksi Bulan Ini</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $transaksiBulanIni }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition border-l-4 border-l-emerald-500">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner">
                <i class="fas fa-money-bill-wave text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Pendapatan Bulan Ini</p>
                <h3 class="text-3xl font-black text-slate-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
        <div>
            <h2 class="font-bold text-slate-800 text-lg">Pembayaran Terbaru</h2>
        </div>
        <a href="/pembayaran" class="bg-white text-blue-600 border border-blue-200 px-6 py-2 rounded-xl text-sm font-bold hover:bg-blue-600 hover:text-white transition shadow-sm">
            Lihat Semua
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="text-slate-400 text-[11px] uppercase font-bold tracking-widest border-b border-slate-50">
                <tr>
                    <th class="px-8 py-5">Pelanggan</th>
                    <th class="px-8 py-5">Bulan Tagihan</th>
                    <th class="px-8 py-5 text-center">Pemakaian</th>
                    <th class="px-8 py-5">Total Bayar</th>
                    <th class="px-8 py-5 text-center">Tanggal Input</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-sm text-slate-600">
                @forelse($pembayaranTerbaru as $p)
                <tr class="hover:bg-blue-50/30 transition">
                    <td class="px-8 py-5">
                        <span class="font-bold text-slate-800 block">{{ $p->pelanggan->nama_pelanggan }}</span>
                        <span class="text-[10px] text-slate-400 uppercase tracking-tighter">ID: #PLG-{{ $p->no_pelanggan }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-slate-100 rounded-lg text-slate-600 font-medium text-xs">{{ $p->bulan }}</span>
                    </td>
                    <td class="px-8 py-5 text-center font-bold text-blue-600">
                        {{ $p->stand_meter_total }} m³
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-emerald-600 font-black">Rp {{ number_format($p->total_tagihan, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-8 py-5 text-center text-xs text-slate-400 italic">
                        {{ date('d M Y', strtotime($p->tanggal_pembayaran)) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-folder-open text-4xl text-slate-200 mb-4"></i>
                            <p class="text-slate-400 italic">Belum ada data transaksi bulan ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection