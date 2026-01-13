@extends('layouts.sidebar')

@section('title', 'Data Pelanggan')
@section('header', 'Manajemen Pelanggan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div class="relative w-72">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
            <i class="fas fa-search"></i>
        </span>
        <input type="text"
            class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl bg-white focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            placeholder="Cari pelanggan...">
    </div>
    <button
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-medium transition flex items-center gap-2">
        <a href="{{ route('pelanggan.create') }}" class="...">
            <i class="fas fa-plus text-sm"></i> Tambah Pelanggan
        </a>
    </button>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold">
            <tr>
                <th class="px-6 py-4">ID</th>
                <th class="px-6 py-4">Nama Pelanggan</th>
                <th class="px-6 py-4">Alamat</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
            @foreach($pelanggans as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-mono text-blue-600">PLG-{{ $p->no_pelanggan }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $p->nama_pelanggan }}</td>
                    <td class="px-6 py-4">{{ $p->alamat_pelanggan }}</td>
                    <td class="px-6 py-4 flex justify-center gap-2">
                        <button class="p-2 text-slate-400 hover:text-blue-600"><i class="fas fa-edit"></i></button>
                        <button class="p-2 text-slate-400 hover:text-red-600"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection