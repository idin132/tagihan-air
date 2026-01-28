@extends('layouts.sidebar')

@section('header', 'Manajemen Biaya Keluar')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-4">
        <h2 class="text-xl font-bold text-slate-800">Riwayat Pengeluaran</h2>
        <select onchange="changePerPage(this.value)" class="border-slate-200 rounded-xl text-xs py-1.5 pl-3 pr-8">
            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
            <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
        </select>
    </div>

    <div class="flex items-center gap-3">
        <div class="relative w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" id="searchPengeluaran"
                class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl bg-white focus:ring-rose-500 focus:border-rose-500 sm:text-sm"
                placeholder="Cari keterangan biaya...">
        </div>
        <button onclick="openModalTambah()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-medium transition flex items-center gap-2 shadow-lg shadow-rose-100">
            <i class="fas fa-plus"></i> Tambah Pengeluaran
        </button>
    </div>
</div>

<div id="tableContainer" class="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-wider">
            <tr>
                <th class="px-8 py-4">Tanggal</th>
                <th class="px-8 py-4">Keterangan</th>
                <th class="px-8 py-4">Nominal</th>
                <th class="px-8 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
            @forelse($pengeluarans as $p)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-4 font-medium">{{ date('d M Y', strtotime($p->tanggal_pengeluaran)) }}</td>
                    <td class="px-8 py-4 font-bold">{{ $p->keterangan }}</td>
                    <td class="px-8 py-4 font-bold text-green-600">
                        Rp {{ number_format($p->biaya_pengeluaran, 0, ',', '.') }}
                    </td>
                    <td class="px-8 py-4 flex justify-center gap-2">
                        <button onclick="editPengeluaran({{ $p->id }})"
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="hapusPengeluaran({{ $p->id }})"
                            class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-8 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-receipt text-3xl text-slate-200 mb-2"></i>
                            <p class="text-slate-400 italic text-sm">Belum ada catatan pengeluaran.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-8 py-4 bg-slate-50/50 border-t border-slate-100">
        {{ $pengeluarans->links() }}
    </div>
</div>

<div id="modalPengeluaran"
    class="fixed inset-0 bg-slate-900/50 z-50 hidden flex items-center justify-center backdrop-blur-sm px-4">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-md p-8 relative">
        <h3 id="modalTitle" class="text-xl font-bold text-slate-800 mb-6">Tambah Biaya Keluar</h3>
        <form id="formPengeluaran">
            <input type="hidden" id="pengeluaran_id">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nominal Biaya (Rp)</label>
                    <input type="number" id="biaya_pengeluaran"
                        class="w-full border-slate-200 rounded-xl px-4 py-2.5 focus:ring-rose-500 focus:border-rose-500 transition"
                        required placeholder="Contoh: 500000">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal</label>
                    <input type="date" id="tanggal_pengeluaran"
                        class="w-full border-slate-200 rounded-xl px-4 py-2.5 focus:ring-rose-500 focus:border-rose-500 transition"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Keterangan</label>
                    <textarea id="keterangan"
                        class="w-full border-slate-200 rounded-xl px-4 py-2.5 focus:ring-rose-500 focus:border-rose-500 transition uppercase text-xs"
                        rows="3" required placeholder="BIYAYA LISTRIK, PERBAIKAN PIPA, DLL..."></textarea>
                </div>
            </div>
            <div class="flex gap-3 mt-8">
                <button type="button" onclick="closeModal()"
                    class="flex-1 px-4 py-2.5 border border-slate-200 rounded-xl text-slate-600 font-medium hover:bg-slate-50 transition">Batal</button>
                <button type="submit"
                    class="flex-1 px-4 py-2.5 bg-rose-600 text-white rounded-xl font-bold shadow-lg shadow-rose-100 hover:bg-rose-700 transition">Simpan
                    Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    // 1. FUNGSI GLOBAL (Agar bisa dipanggil oleh atribut onclick di HTML)

    function fetchData(url, search = '') {
        $.ajax({
            url: url,
            data: {
                search: search,
                per_page: $('select').val()
            },
            beforeSend: function () {
                $('#tableContainer').css('opacity', '0.5');
            },
            success: function (data) {
                let htmlUpdate = $(data).find('#tableContainer').html();
                $('#tableContainer').html(htmlUpdate);
                $('#tableContainer').css('opacity', '1');
            }
        });
    }

    function openModalTambah() {
        $('#formPengeluaran')[0].reset();
        $('#pengeluaran_id').val('');
        $('#modalTitle').text('Tambah Biaya Keluar');
        $('#modalPengeluaran').removeClass('hidden');
    }

    function closeModal() {
        $('#modalPengeluaran').addClass('hidden');
    }

    // FUNGSI EDIT (YANG TADI HILANG)
    function editPengeluaran(id) {
        $.get(`/pengeluaran/${id}/edit`, function (data) {
            $('#pengeluaran_id').val(data.id);
            $('#biaya_pengeluaran').val(data.biaya_pengeluaran);
            $('#tanggal_pengeluaran').val(data.tanggal_pengeluaran);
            $('#keterangan').val(data.keterangan);
            $('#modalTitle').text('Edit Biaya Keluar');
            $('#modalPengeluaran').removeClass('hidden');
        });
    }

    // FUNGSI HAPUS (YANG TADI HILANG)
    function hapusPengeluaran(id) {
        Swal.fire({
            title: 'Hapus data ini?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/pengeluaran/${id}`,
                    method: 'DELETE',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function () {
                        // Refresh tabel setelah hapus
                        fetchData("{{ route('pengeluaran.index') }}", $('#searchPengeluaran').val());
                        Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                    }
                });
            }
        });
    }

    // 2. LOGIKA SAAT HALAMAN SIAP (EVENT LISTENERS)
    $(document).ready(function () {
        let timer;

        // Search Real-time
        $("#searchPengeluaran").on("keyup", function () {
            clearTimeout(timer);
            let value = $(this).val();
            timer = setTimeout(function () {
                fetchData("{{ route('pengeluaran.index') }}", value);
            }, 500);
        });

        // Pagination AJAX
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let query = $('#searchPengeluaran').val();
            fetchData(url, query);
        });

        // Form Submit (Tambah/Update)
        $('#formPengeluaran').on('submit', function (e) {
            e.preventDefault();
            let id = $('#pengeluaran_id').val();
            let url = id ? `/pengeluaran/${id}` : '/pengeluaran';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: method,
                    biaya_pengeluaran: $('#biaya_pengeluaran').val(),
                    tanggal_pengeluaran: $('#tanggal_pengeluaran').val(),
                    keterangan: $('#keterangan').val(),
                },
                success: function (res) {
                    closeModal();
                    Swal.fire({ title: 'Berhasil!', icon: 'success', timer: 1000, showConfirmButton: false })
                        .then(() => {
                            fetchData("{{ route('pengeluaran.index') }}", $('#searchPengeluaran').val());
                        });
                },
                error: function () {
                    Swal.fire('Error', 'Periksa kembali inputan Anda', 'error');
                }
            });
        });
    });

    // Ganti Per Page
    window.changePerPage = function (value) {
        let query = $('#searchPengeluaran').val();
        fetchData("{{ route('pengeluaran.index') }}", query);
    };
</script>
@endsection