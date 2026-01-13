@extends('layouts.sidebar')

@section('title', 'Dashboard')
@section('header', 'Dashboard Ringkasan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-xl"></i>
            </div>
            <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg">+12%</span>
        </div>
        <h3 class="text-slate-500 text-sm font-medium">Total Pelanggan</h3>
        <p class="text-2xl font-bold text-slate-800">1,240</p>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-faucet text-xl"></i>
            </div>
        </div>
        <h3 class="text-slate-500 text-sm font-medium">Tagihan Belum Lunas</h3>
        <p class="text-2xl font-bold text-slate-800">42</p>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-xl"></i>
            </div>
        </div>
        <h3 class="text-slate-500 text-sm font-medium">Total Pendapatan (Bulan Ini)</h3>
        <p class="text-2xl font-bold text-slate-800">Rp 12.450.000</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h2 class="font-bold text-slate-800">Pembayaran Terbaru</h2>
        <button class="text-blue-600 text-sm font-semibold hover:underline">Lihat Semua</button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Bulan</th>
                    <th class="px-6 py-4">Total Pakai</th>
                    <th class="px-6 py-4">Total Bayar</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                <tr>
                    <td class="px-6 py-4 font-medium text-slate-800">Budi Santoso</td>
                    <td class="px-6 py-4">Oktober 2025</td>
                    <td class="px-6 py-4">24 m³</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">Rp 120.000</td>
                    <td class="px-6 py-4">
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">Lunas</span>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 font-medium text-slate-800">Ani Wijaya</td>
                    <td class="px-6 py-4">Oktober 2025</td>
                    <td class="px-6 py-4">15 m³</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">Rp 75.000</td>
                    <td class="px-6 py-4">
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection