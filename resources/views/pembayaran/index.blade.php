@extends('layouts.sidebar')

@section('title', 'Riwayat Pembayaran')
@section('header', 'Data Tagihan Air')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h2 class="font-bold text-slate-800 text-lg">Semua Transaksi</h2>
        <a href="/pembayaran/create" class="text-blue-600 font-semibold flex items-center gap-1 hover:underline">
            <i class="fas fa-file-invoice"></i> Buat Tagihan Baru
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-4 text-center">Bulan</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4 text-right">Meter (Awal - Akhir)</th>
                    <th class="px-6 py-4 text-center">Total Pakai</th>
                    <th class="px-6 py-4">Total Tagihan</th>
                    <th class="px-6 py-4">Petugas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach($pembayarans as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-center font-medium">{{ $p->bulan }}</td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-slate-800">{{ $p->pelanggan->nama_pelanggan }}</div>
                        <div class="text-xs text-slate-400">ID: {{ $p->no_pelanggan }}</div>
                    </td>
                    <td class="px-6 py-4 text-right text-slate-500">{{ $p->stand_meter_awal }} - {{ $p->stand_meter_akhir }}</td>
                    <td class="px-6 py-4 text-center font-bold text-blue-600">{{ $p->stand_meter_total }} m³</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg font-bold">
                            Rp {{ number_format($p->total_tagihan, 0, ',', '.') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs italic">{{ $p->pengelola->nama_pengelola }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection