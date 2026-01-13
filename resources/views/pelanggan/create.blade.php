@extends('layouts.sidebar')

@section('title', 'Tambah Pelanggan')
@section('header', 'Tambah Pelanggan Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('pelanggan.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-blue-600 mb-6 transition">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pelanggan
    </a>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-slate-800">Informasi Pelanggan</h2>
                <p class="text-sm text-slate-500">Pastikan data nama dan alamat sudah sesuai dengan KTP/Identitas resmi.</p>
            </div>

            <form action="{{ route('pelanggan.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="Nama_Pelanggan" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="nama_pelanggan" id="nama_pelanggan" 
                            class="block w-full pl-10 pr-3 py-3 border @error('nama_pelanggan') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-blue-500 focus:border-blue-500 transition" 
                            placeholder="Contoh: Budi Sudarsono" value="{{ old('nama_pelanggan') }}">
                    </div>
                    @error('nama_pelanggan')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="alamat_pelanggan" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                    <div class="relative">
                        <span class="absolute top-3 left-3 text-slate-400">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        <textarea name="alamat_pelanggan" id="alamat_pelanggan" rows="4" 
                            class="block w-full pl-10 pr-3 py-3 border @error('alamat_pelanggan') border-red-500 @else border-slate-200 @enderror rounded-xl focus:ring-blue-500 focus:border-blue-500 transition" 
                            placeholder="Jl. Raya No. 123, Kelurahan..., Kecamatan...">{{ old('alamat_pelanggan') }}</textarea>
                    </div>
                    @error('alamat_pelanggan')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-50">
                    <button type="submit" class="flex-1 bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-100 transition flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Pelanggan
                    </button>
                    <button type="reset" class="px-6 py-3 border border-slate-200 rounded-xl text-slate-500 font-semibold hover:bg-slate-50 transition">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-6 bg-amber-50 border border-amber-100 rounded-xl p-4 flex gap-3">
        <i class="fas fa-info-circle text-amber-500 mt-1"></i>
        <p class="text-xs text-amber-700 leading-relaxed">
            <strong>Catatan:</strong> Setelah pelanggan berhasil ditambahkan, sistem akan memberikan nomor ID pelanggan secara otomatis. Gunakan ID tersebut untuk mencatat pembayaran air di menu Pembayaran.
        </p>
    </div>
</div>
@endsection