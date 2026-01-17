@extends('layouts.sidebar')

@section('header', 'Manajemen Pengelola')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-slate-800">Daftar Pengelola</h2>
    <div class="flex items-center gap-3">
        <label class="text-sm font-medium text-slate-500">Tampilkan:</label>
        <select onchange="changePerPage(this.value)"
            class="border-slate-200 rounded-xl text-sm focus:ring-blue-500 py-1.5 pl-3 pr-8">
            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
            <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
        </select>
    </div>
    <div class="relative w-72">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
            <i class="fas fa-search"></i>
        </span>
        <input type="text" id="searchPengelola"
            class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl bg-white focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            placeholder="Cari nama pengelola...">
    </div>
    <button onclick="openModalTambah()"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-medium transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Pengelola
    </button>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-left" id="tablePengelola">
        <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold">
            <tr>
                <th class="px-6 py-4">ID</th>
                <th class="px-6 py-4">Nama Pengelola</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
            @foreach($pengelolas as $p)
                <tr id="row_{{ $p->no_pengelola }}">
                    <td class="px-6 py-4 font-mono text-blue-600">#ADM-{{ $p->no_pengelola }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $p->nama_pengelola }}</td>
                    <td class="px-6 py-4 flex justify-center gap-2">
                        <button onclick="editPengelola({{ $p->no_pengelola }})"
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg"><i class="fas fa-edit"></i></button>
                        <button onclick="hapusPengelola({{ $p->no_pengelola }})"
                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-10">
        {{ $pengelolas->links() }}
    </div>
</div>

<div id="modalPengelola"
    class="fixed inset-0 bg-slate-900/50 z-50 hidden flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8 relative">
        <h3 id="modalTitle" class="text-xl font-bold text-slate-800 mb-6">Tambah Pengelola</h3>

        <form id="formPengelola">
            <input type="hidden" id="no_pengelola">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="nama_pengelola"
                        class="w-full border-slate-200 rounded-xl px-4 py-2.5 focus:ring-blue-500"
                        placeholder="Masukkan nama pengelola" required>
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <button type="button" onclick="closeModal()"
                    class="flex-1 px-4 py-2.5 border border-slate-200 rounded-xl text-slate-600 font-medium hover:bg-slate-50">Batal</button>
                <button type="submit"
                    class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('modalPengelola');
    const form = document.getElementById('formPengelola');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    function openModalTambah() {
        form.reset();
        $('#no_pengelola').val('');
        $('#modalTitle').text('Tambah Pengelola');
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    // Handle Simpan (Tambah & Update)
    $('#formPengelola').on('submit', function (e) {
        e.preventDefault();
        let id = $('#no_pengelola').val();
        let url = id ? `/pengelola/${id}` : '/pengelola';
        let method = 'POST';

        let data = {
            _token: csrfToken,
            nama_pengelola: $('#nama_pengelola').val(),
        };

        if (id) {
            data._method = 'PUT';
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function (res) {
                closeModal();
                Swal.fire('Berhasil!', res.message, 'success').then(() => {
                    location.reload();
                });
            },
            error: function (err) {
                Swal.fire('Error!', 'Gagal menyimpan data.', 'error');
            }
        });
    });

    // Handle Edit
    function editPengelola(id) {
        $.get(`/pengelola/${id}/edit`, function (data) {
            $('#no_pengelola').val(data.no_pengelola);
            $('#nama_pengelola').val(data.nama_pengelola);
            $('#modalTitle').text('Edit Pengelola');
            modal.classList.remove('hidden');
        }).fail(function () {
            Swal.fire('Error!', 'Gagal mengambil data.', 'error');
        });
    }

    // Handle Hapus
    function hapusPengelola(id) {
        Swal.fire({
            title: 'Hapus data?',
            text: "Pengelola ini tidak akan bisa menginput data lagi.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/pengelola/${id}`,
                    method: 'DELETE',
                    data: { _token: csrfToken },
                    success: function (res) {
                        $(`#row_${id}`).remove();
                        Swal.fire('Terhapus!', res.message, 'success');
                    },
                    error: function () {
                        Swal.fire('Error!', 'Data gagal dihapus.', 'error');
                    }
                });
            }
        });
    }

    $(document).ready(function () {
        $("#searchPengelola").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#tablePengelola tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection