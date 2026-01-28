<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Tagihan Air - @yield('title')</title>

    <!-- Style -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-white border-r border-slate-200 fixed h-full transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center gap-3 text-blue-600 font-bold text-xl">
                    <i class="fas fa-faucet-drip"></i>
                    <span>WaterPay</span>
                </div>
            </div>

            <nav class="mt-4 px-4 space-y-2">
                <a href="{{ route('dashboard.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-xl 
       {{ request()->routeIs('dashboard.*') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>

                <a href="{{ route('pelanggan.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-xl 
       {{ request()->routeIs('pelanggan.*') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
                    <i class="fas fa-users"></i> Data Pelanggan
                </a>

                <a href="{{ route('pembayaran.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-xl 
       {{ request()->routeIs('pembayaran.*') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
                    <i class="fas fa-file-invoice-dollar"></i> Pembayaran Air
                </a>

                <a href="{{ route('pengelola.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-xl 
       {{ request()->routeIs('pengelola.*') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
                    <i class="fas fa-user-shield"></i> Data Pengelola
                </a>

                <a href="{{ route('pengeluaran.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-xl 
       {{ request()->routeIs('pengeluaran.*') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
                    <i class="fas fa-chart-line"></i> Pengeluaran
                </a>
            </nav>

            <div class="absolute bottom-0 w-full p-4 border-t border-slate-100">
                <div class="flex items-center gap-3 px-2 py-2">
                    <div
                        class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-600">
                        A
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 italic uppercase">Pengelola</p>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-500">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="flex-1 ml-64">
            <header
                class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 flex items-center justify-between px-8 z-10">
                <h1 class="text-lg font-semibold text-slate-800">@yield('header')</h1>
                <div class="flex items-center gap-4 text-slate-500">
                    <span id="date-now" class="text-sm"></span>
                    <i class="far fa-bell hover:text-blue-600 cursor-pointer"></i>
                </div>
            </header>

            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Script sederhana untuk menampilkan tanggal hari ini
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('date-now').innerText = new Date().toLocaleDateString('id-ID', options);

        // Script untuk mengubah jumlah data per halaman
        function changePerPage(value) { 
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', value);
            url.searchParams.set('page', 1); // Reset ke halaman 1 jika jumlah data diubah
            window.location.href = url.href;
        }
    </script>
</body>

</html>