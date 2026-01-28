@extends('layouts.sidebar')

@section('header', 'Data Tagihan Air')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h2 class="font-bold text-slate-800 text-lg">Riwayat Transaksi</h2>
        <div class="flex items-center gap-3">
            <label class="text-sm font-medium text-slate-500">Tampilkan:</label>
            <select onchange="changePerPage(this.value)"
                class="border-slate-200 rounded-xl text-sm focus:ring-blue-500 py-1.5 pl-3 pr-8">
                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
            </select>
        </div>
        <div class="relative w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" id="searchPembayaran"
                class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl bg-white focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                placeholder="Cari nama, bulan, atau petugas...">
        </div>
        <button onclick="openModalTambah()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-medium transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Tagihan
        </button>
    </div>
    <div class="overflow-x-auto">
        <div class="bg-blue-50 p-6 rounded-2xl mb-6 border border-blue-100">
            <h3 class="text-blue-800 font-bold mb-4 flex items-center gap-2">
                <i class="fas fa-print"></i> Cetak Laporan Periodik
            </h3>
            <form action="{{ route('pembayaran.cetak') }}" method="GET" target="_blank"
                class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block text-xs font-bold text-blue-600 mb-1 uppercase">Tanggal Awal</label>
                    <input type="date" name="tgl_awal"
                        class="border-blue-200 rounded-xl px-4 py-2 text-sm focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-blue-600 mb-1 uppercase">Tanggal Akhir</label>
                    <input type="date" name="tgl_akhir"
                        class="border-blue-200 rounded-xl px-4 py-2 text-sm focus:ring-blue-500" required>
                </div>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-bold transition shadow-lg shadow-blue-200">
                    <i class="fas fa-file-pdf mr-1"></i> Cetak PDF
                </button>
            </form>
        </div>
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-4">Bulan</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4 text-center">Total Pakai</th>
                    <th class="px-6 py-4">Tagihan</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach($pembayarans as $p)
                    <tr class="hover:bg-slate-50 transition" id="row_{{ $p->id }}">
                        <td class="px-6 py-4 font-medium">{{ $p->bulan }}</td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-800">{{ $p->pelanggan->nama_pelanggan }}</div>
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-blue-600">{{ $p->stand_meter_total }} m³</td>
                        <td class="px-6 py-4 font-bold text-emerald-600">Rp
                            {{ number_format($p->total_tagihan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 flex justify-center gap-2">
                            <button onclick="viewDetail({{ $p->id }})"
                                class="text-slate-400 hover:bg-slate-50 p-2 rounded-lg hover:text-blue-600 transition"
                                title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="editPembayaran({{ $p->id }})"
                                class="text-blue-600 hover:bg-blue-50 p-2 rounded-lg"><i class="fas fa-edit"></i></button>
                            <button onclick="hapusPembayaran({{ $p->id }})"
                                class="text-red-600 hover:bg-red-50 p-2 rounded-lg"><i class="fas fa-trash"></i></button>
                            <button onclick="showDetail({{ $p->id }})"
                                class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Lihat Detail">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-8 py-5 border-t border-slate-100">
            {{ $pembayarans->links() }}
        </div>
    </div>
</div>

<div id="modalPembayaran"
    class="fixed inset-0 bg-slate-900/50 z-50 hidden flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-8 relative overflow-y-auto max-h-[90vh]">
        <h3 id="modalTitle" class="text-xl font-bold text-slate-800 mb-6">Input Tagihan Baru</h3>

        <form id="formPembayaran">
            <input type="hidden" id="pembayaran_id">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Pelanggan</label>
                    <select id="no_pelanggan" class="w-full border-slate-200 rounded-xl px-4 py-2.5" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($pelanggans as $plg)
                            <option value="{{ $plg->no_pelanggan }}">{{ $plg->nama_pelanggan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Bulan</label>
                    <input type="month" id="bulan" class="w-full border-slate-200 rounded-xl px-4 py-2.5" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Petugas/Pengelola</label>
                    <select id="no_pengelola" class="w-full border-slate-200 rounded-xl px-4 py-2.5" required>
                        @foreach($pengelolas as $peng)
                            <option value="{{ $peng->no_pengelola }}">{{ $peng->nama_pengelola }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Meter Awal</label>
                    <input type="number" id="stand_meter_awal"
                        class="w-full border-slate-200 rounded-xl px-4 py-2.5 bg-slate-50" value="0">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Meter Akhir</label>
                    <input type="number" id="stand_meter_akhir" class="w-full border-slate-200 rounded-xl px-4 py-2.5"
                        required>
                </div>
            </div>

            <div class="mt-6 bg-blue-50 p-4 rounded-xl flex justify-between items-center">
                <div>
                    <span class="text-xs font-bold text-blue-600 uppercase">Estimasi Tagihan</span>
                    <h2 class="text-xl font-black text-blue-800" id="text_tagihan">Rp 0</h2>
                </div>
                <div class="text-right">
                    <span class="text-xs font-medium text-blue-600">Total Pakai</span>
                    <p class="font-bold text-blue-800" id="text_total">0 m³</p>
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <button type="button" onclick="closeModal()"
                    class="flex-1 px-4 py-2.5 border border-slate-200 rounded-xl font-medium">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-xl font-bold">Simpan
                    Data</button>
            </div>
        </form>
    </div>
</div>

<div id="modalDetail"
    class="fixed inset-0 bg-slate-900/50 z-50 hidden flex items-center justify-center backdrop-blur-sm px-4">
    <div class="bg-white rounded-[32px] shadow-xl w-full max-w-lg overflow-hidden relative">
        <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Rincian Transaksi</h3>
            <button onclick="closeDetail()" class="text-slate-400 hover:text-slate-600"><i
                    class="fas fa-times"></i></button>
        </div>

        <div class="p-8 space-y-5">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pelanggan</p>
                    <h4 id="det_nama" class="font-black text-slate-800">-</h4>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Bulan</p>
                    <span id="det_bulan"
                        class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg font-bold text-xs">-</span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-2 py-4 border-y border-slate-50">
                <div class="text-center">
                    <p class="text-[10px] text-slate-400 uppercase">Awal</p>
                    <p id="det_awal" class="font-bold text-slate-700">-</p>
                </div>
                <div class="text-center">
                    <p class="text-[10px] text-slate-400 uppercase">Akhir</p>
                    <p id="det_akhir" class="font-bold text-slate-700">-</p>
                </div>
                <div class="text-center">
                    <p class="text-[10px] text-slate-400 uppercase">Total</p>
                    <p id="det_total_m3" class="font-bold text-blue-600">-</p>
                </div>
            </div>

            <div class="bg-slate-900 p-6 rounded-3xl text-white">
                <p class="text-xs opacity-70 mb-1">Total Tagihan</p>
                <h2 id="det_bayar" class="text-2xl font-black">Rp 0</h2>
            </div>

            <div class="pt-2 space-y-1">
                <p class="text-[10px] text-slate-400 uppercase font-bold tracking-tighter">Informasi Sistem</p>
                <div class="text-[11px] text-slate-500 space-y-1 italic">
                    <p><i class="fas fa-user-shield mr-2"></i>Petugas: <span id="det_petugas"
                            class="font-semibold not-italic text-slate-700">-</span></p>
                    <p><i class="fas fa-calendar-alt mr-2"></i>Dibuat: <span id="det_created">-</span></p>
                    <p><i class="fas fa-history mr-2"></i>Terakhir Diubah: <span id="det_updated">-</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('modalPembayaran');
    const form = document.getElementById('formPembayaran');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Kalkulasi Otomatis
    function hitungTagihan() {
        let awal = parseInt($('#stand_meter_awal').val()) || 0;
        let akhir = parseInt($('#stand_meter_akhir').val()) || 0;
        let total = akhir - awal;
        if (total < 0) total = 0;

        $('#text_total').text(total + " m³");
        $('#text_tagihan').text("Rp " + ((total * 3500) + 20000).toLocaleString('id-ID'));
    }

    $('#stand_meter_awal, #stand_meter_akhir').on('input', hitungTagihan);

    function openModalTambah() {
        form.reset();
        $('#pembayaran_id').val('');
        $('#modalTitle').text('Input Tagihan Baru');
        hitungTagihan();
        modal.classList.remove('hidden');
    }

    function closeModal() { modal.classList.add('hidden'); }

    // Simpan & Update
    $('#formPembayaran').on('submit', function (e) {
        e.preventDefault();
        let id = $('#pembayaran_id').val();
        let url = id ? `/pembayaran/${id}` : '/pembayaran';
        let method = 'POST';

        let data = {
            _token: csrfToken,
            no_pelanggan: $('#no_pelanggan').val(),
            bulan: $('#bulan').val(),
            stand_meter_awal: $('#stand_meter_awal').val(),
            stand_meter_akhir: $('#stand_meter_akhir').val(),
            no_pengelola: $('#no_pengelola').val(),
            tanggal_pembayaran: new Date().toISOString().split('T')[0]
        };

        if (id) data._method = 'PUT';

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function (res) {
                Swal.fire('Berhasil!', res.message, 'success').then(() => location.reload());
            },
            error: function (err) {
                Swal.fire('Error!', 'Periksa kembali inputan anda (Meter Akhir harus > Meter Awal)', 'error');
            }
        });
    });

    // Edit
    function editPembayaran(id) {
        $.get(`/pembayaran/${id}/edit`, function (data) {
            $('#pembayaran_id').val(data.id);
            $('#no_pelanggan').val(data.no_pelanggan);
            $('#bulan').val(data.bulan);
            $('#stand_meter_awal').val(data.stand_meter_awal);
            $('#stand_meter_akhir').val(data.stand_meter_akhir);
            $('#no_pengelola').val(data.no_pengelola);
            $('#modalTitle').text('Edit Tagihan');
            hitungTagihan();
            modal.classList.remove('hidden');
        });
    }

    // Hapus
    function hapusPembayaran(id) {
        Swal.fire({
            title: 'Hapus data?',
            text: "Aksi ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/pembayaran/${id}`,
                    method: 'DELETE',
                    data: { _token: csrfToken },
                    success: function (res) {
                        Swal.fire('Terhapus!', res.message, 'success').then(() => location.reload());
                    }
                });
            }
        });
    }

    // Tampilkan Detail
    function showDetail(id) {
        $.get(`/pembayaran/${id}`, function (data) {
            // Data dari relasi Eloquent 'pelanggan'
            $('#det_nama').text(data.pelanggan.nama_pelanggan);
            $('#det_bulan').text(data.bulan);

            // Data teknis stand meter
            $('#det_awal').text(data.stand_meter_awal + " m³");
            $('#det_akhir').text(data.stand_meter_akhir + " m³");
            $('#det_total_m3').text(data.stand_meter_total + " m³");

            // Format Rupiah
            $('#det_bayar').text("Rp " + parseInt(data.total_tagihan).toLocaleString('id-ID'));

            // Data dari relasi Eloquent 'pengelola'
            $('#det_petugas').text(data.pengelola ? data.pengelola.nama_pengelola : 'Sistem');

            // Timestamp standar Laravel
            $('#det_created').text(new Date(data.created_at).toLocaleString('id-ID'));
            $('#det_updated').text(new Date(data.updated_at).toLocaleString('id-ID'));

            $('#modalDetail').removeClass('hidden');
        });
    }

    function closeDetail() {
        $('#modalDetail').addClass('hidden');
    }



    $(document).ready(function () {
        $("#searchPembayaran").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            // Mengasumsikan tabel pembayaran memiliki ID atau class tertentu, kita gunakan selector tabel langsung
            $("table tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection