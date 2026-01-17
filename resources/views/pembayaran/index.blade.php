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
    class="fixed inset-0 bg-slate-900/50 z-50 hidden flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-[32px] shadow-xl w-full max-w-lg p-0 relative overflow-hidden">
        <div class="bg-blue-600 p-8 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-blue-100 text-xs font-bold uppercase tracking-widest mb-1">Rincian Tagihan</p>
                    <h3 class="text-2xl font-bold" id="det_bulan">Januari 2026</h3>
                </div>
                <button onclick="closeDetail()" class="text-white/50 hover:text-white transition text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="p-8 space-y-6">
            <div class="flex items-start gap-4 pb-6 border-b border-slate-100">
                <div
                    class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user text-xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-lg" id="det_nama">Nama Pelanggan</h4>
                    <p class="text-sm text-slate-500" id="det_alamat">Alamat Lengkap Pelanggan...</p>
                    <span
                        class="inline-block mt-2 px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-bold uppercase tracking-tight"
                        id="det_id">ID: #001</span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 py-2">
                <div class="text-center p-4 bg-slate-50 rounded-2xl">
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Awal</p>
                    <p class="font-bold text-slate-700" id="det_awal">0</p>
                </div>
                <div class="text-center p-4 bg-slate-50 rounded-2xl">
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Akhir</p>
                    <p class="font-bold text-slate-700" id="det_akhir">0</p>
                </div>
                <div class="text-center p-4 bg-blue-50 rounded-2xl border border-blue-100">
                    <p class="text-[10px] font-bold text-blue-400 uppercase mb-1">Total</p>
                    <p class="font-bold text-blue-700" id="det_total">0 m³</p>
                </div>
            </div>

            <div
                class="bg-slate-900 rounded-3xl p-6 text-white flex justify-between items-center shadow-lg shadow-slate-200">
                <div>
                    <p class="text-slate-400 text-[10px] font-bold uppercase">Total Pembayaran</p>
                    <h2 class="text-2xl font-black text-emerald-400" id="det_tagihan">Rp 0</h2>
                </div>
                <i class="fas fa-check-circle text-3xl text-emerald-500"></i>
            </div>

            <div class="flex justify-between items-center text-[11px] text-slate-400 pt-2 font-medium">
                <p>Petugas: <span class="text-slate-600" id="det_petugas">Admin</span></p>
                <p>Tgl Bayar: <span class="text-slate-600" id="det_tgl">01/01/2026</span></p>
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

    function viewDetail(id) {
        $.get(`/pembayaran/${id}/edit`, function (data) {
            // Data utama
            $('#det_bulan').text(data.bulan);
            $('#det_id').text('ID: #PLG-' + data.no_pelanggan);
            $('#det_awal').text(data.stand_meter_awal);
            $('#det_akhir').text(data.stand_meter_akhir);
            $('#det_total').text(data.stand_meter_total + ' m³');

            // Format Mata Uang
            const formattedPrice = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(data.total_tagihan);
            $('#det_tagihan').text(formattedPrice);

            // Data Relasi (Diambil dari AJAX response)
            // Catatan: Pastikan Controller me-return data pelanggan & pengelola
            $('#det_nama').text(data.pelanggan.nama_pelanggan);
            $('#det_alamat').text(data.pelanggan.alamat_pelanggan);
            $('#det_petugas').text(data.pengelola.nama_pengelola);

            // Format Tanggal
            const tgl = new Date(data.tanggal_pembayaran);
            $('#det_tgl').text(tgl.toLocaleDateString('id-ID'));

            // Tampilkan Modal
            document.getElementById('modalDetail').classList.remove('hidden');
        });
    }

    function closeDetail() {
        document.getElementById('modalDetail').classList.add('hidden');
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