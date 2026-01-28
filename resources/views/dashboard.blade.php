@extends('layouts.sidebar')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    <div class="bg-slate-900 p-6 rounded-3xl shadow-md flex items-center gap-5">
        <div class="w-14 h-14 bg-blue-500/20 text-blue-400 rounded-2xl flex items-center justify-center">
            <i class="fas fa-users text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                Total Pelanggan
            </p>
            <h3 class="text-2xl font-black text-white">
                {{ number_format($totalPelanggan) }}
            </h3>
        </div>
    </div>

    <div class="bg-slate-900 p-6 rounded-3xl shadow-md flex items-center gap-5">
        <div class="w-14 h-14 bg-indigo-500/20 text-indigo-400 rounded-2xl flex items-center justify-center">
            <i class="fas fa-file-invoice-dollar text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                Transaksi Bulan Ini
            </p>
            <h3 class="text-2xl font-black text-white">
                {{ number_format($transaksiBulanIni) }}
            </h3>
        </div>
    </div>

    <div
        class="relative bg-gradient-to-r from-emerald-600 to-emerald-500 p-6 rounded-3xl shadow-lg flex items-center gap-5 text-white">
        <span class="absolute top-4 right-4 text-[10px] font-bold bg-white/20 px-3 py-1 rounded-full">
            BULAN INI
        </span>
        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
            <i class="fas fa-money-bill-wave text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider opacity-90">
                Pendapatan Bulan Ini
            </p>
            <h3 class="text-2xl font-black">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </h3>
        </div>
    </div>

    <div class="bg-slate-900 p-6 rounded-3xl shadow-md flex items-center gap-5">
        <div class="w-14 h-14 bg-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center">
            <i class="fas fa-wallet text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                Pendapatan Keseluruhan
            </p>
            <h3 class="text-2xl font-black text-white">
                Rp {{ number_format($totalSeluruhPendapatan, 0, ',', '.') }}
            </h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-6 rounded-3xl shadow-lg text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-wallet text-xl"></i>
            </div>
            <span class="text-[10px] font-bold bg-white/20 px-2 py-1 rounded-lg uppercase tracking-wider">
                UANG
            </span>
        </div>
        <h3 class="text-white/80 text-xs font-medium uppercase tracking-widest">Saldo Utama</h3>
        <p class="text-2xl font-black mt-1">
            Rp {{ number_format($saldoUtama, 0, ',', '.') }}
        </p>
    </div>

    <div class="bg-gradient-to-br from-rose-600 to-rose-700 p-6 rounded-3xl shadow-lg text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-tools text-xl"></i>
            </div>
            <span class="text-[10px] font-bold bg-white/20 px-2 py-1 rounded-lg uppercase tracking-wider">
                BIAYA
            </span>
        </div>
        <h3 class="text-white/80 text-xs font-medium uppercase tracking-widest">Total Pengeluaran</h3>
        <p class="text-2xl font-black mt-1">
            Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
        </p>
    </div>
</div>

<div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
        <div>
            <h2 class="font-bold text-slate-800 text-lg">Pembayaran Terbaru</h2>
        </div>
        <a href="/pembayaran"
            class="bg-white text-blue-600 border border-blue-200 px-6 py-2 rounded-xl text-sm font-bold hover:bg-blue-600 hover:text-white transition shadow-sm">
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
                            <span class="font-bold text-slate-800 block">{{ $p->nama_pelanggan }}</span>
                            <span class="text-[10px] text-slate-400 uppercase tracking-tighter">
                                ID: #PLG-{{ $p->no_pelanggan }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 bg-slate-100 rounded-lg text-slate-600 font-medium text-xs">
                                {{ $p->bulan }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center font-bold text-blue-600">
                            {{ $p->stand_meter_total }} m³
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-emerald-600 font-black">
                                Rp {{ number_format($p->total_tagihan, 0, ',', '.') }}
                            </span>
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