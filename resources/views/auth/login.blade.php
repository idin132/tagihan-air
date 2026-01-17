<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .water-bg {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animasi gelombang sederhana */
        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: url('https://raw.githubusercontent.com/KellyInDev/Water-Wave-Animation/master/wave.png');
            background-size: 1000px 100px;
        }

        .wave1 { animation: animate 30s linear infinite; z-index: 1000; opacity: 0.5; animation-delay: 0s; bottom: 0; }
        .wave2 { animation: animate2 15s linear infinite; z-index: 999; opacity: 0.2; animation-delay: -5s; bottom: 10px; }

        @keyframes animate {
            0% { background-position-x: 0; }
            100% { background-position-x: 1000px; }
        }
        @keyframes animate2 {
            0% { background-position-x: 0; }
            100% { background-position-x: -1000px; }
        }
    </style>
</head>
<body class="bg-slate-100">

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-4xl w-full bg-white rounded-[32px] shadow-2xl overflow-hidden flex flex-col md:flex-row shadow-blue-200/50">
            
            <div class="md:w-1/2 water-bg p-12 text-white flex flex-col justify-center relative">
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center mb-6 border border-white/30">
                        <i class="fas fa-faucet-drip text-3xl"></i>
                    </div>
                    <h1 class="text-4xl font-bold mb-4">Tagihan Air</h1>
                    <p class="text-blue-100 leading-relaxed opacity-90">
                        Sistem Informasi Pengelolaan Tagihan Air yang efisien, transparan, dan terpercaya untuk masyarakat.
                    </p>
                </div>
                
                <div class="wave wave1"></div>
                <div class="wave wave2"></div>
            </div>

            <div class="md:w-1/2 p-12 bg-white">
                <div class="mb-10">
                    <h2 class="text-2xl font-bold text-slate-800">Selamat Datang Kembali!</h2>
                    <p class="text-slate-500 text-sm mt-1">Silakan masuk ke akun pengelola Anda.</p>
                </div>

                @if(session()->has('loginError'))
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-3">
                    <i class="fas fa-circle-exclamation"></i>
                    {{ session('loginError') }}
                </div>
                @endif

                <form action="/login" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i class="far fa-user"></i>
                            </span>
                            <input type="text" name="username" required
                                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none"
                                placeholder="Masukkan username">
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <label class="block text-sm font-semibold text-slate-700">Password</label>
                            <a href="#" class="text-xs font-semibold text-blue-600 hover:underline">Lupa Password?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" id="password" required
                                class="w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none"
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-blue-600">
                                <i class="far fa-eye" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 py-2">
                        <input type="checkbox" id="remember" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <label for="remember" class="text-sm text-slate-600 cursor-pointer">Ingat saya di perangkat ini</label>
                    </div>

                    <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2 mt-4">
                        Masuk Sekarang <i class="fas fa-arrow-right text-sm"></i>
                    </button>
                </form>

                <p class="text-center text-slate-500 text-xs mt-10">
                    &copy; 2026 IF4 Team. Seluruh Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passInput = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>