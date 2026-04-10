<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SiPinjam</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .login-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: #faf9fd;
            color: #1a1b1e;
            font-family: Inter, sans-serif;
        }

        .login-main {
            width: min(100%, 480px);
            max-width: 480px;
            margin: 0 auto;
        }

        .login-card {
            width: 100%;
            background: #fff;
            border-radius: 12px;
            padding: 40px 48px;
            box-shadow: 0 32px 64px -12px rgba(0, 21, 53, 0.08);
        }

        .login-submit {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 16px;
            border: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, #001535 0%, #0f2a52 100%);
            color: #fff;
            font-family: Manrope, sans-serif;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 20px -6px rgba(0, 21, 53, 0.3);
        }

        .login-field-wrap {
            position: relative;
        }

        .login-field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #74777f;
            font-size: 20px;
            line-height: 1;
            pointer-events: none;
        }

        .login-field-input {
            width: 100%;
            height: 52px;
            padding-left: 46px;
            padding-right: 14px;
            border: 0;
            border-bottom: 2px solid transparent;
            border-radius: 8px 8px 0 0;
            background: #e3e2e6;
            color: #1a1b1e;
            outline: none;
        }

        .login-field-input:focus {
            border-bottom-color: #0098ee;
        }

        .login-password-input {
            padding-right: 46px;
        }

        .login-eye-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #74777f;
            background: transparent;
            border: 0;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="login-shell selection:bg-[#0098EE] selection:text-white">
    @include('components.loading-overlay')

    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-[#D7E2FF]/40 blur-[120px]"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-[#0098EE]/10 blur-[120px]"></div>
    </div>

    <main class="login-main">
        <div class="login-card relative overflow-hidden">
            <div class="flex flex-col items-center mb-10 text-center">
                <div class="w-16 h-16 bg-[#0F2A52] rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                    <span class="material-symbols-outlined text-[#2DA8FF] text-4xl">account_balance</span>
                </div>
                <h1 class="font-manrope font-extrabold text-4xl leading-none text-[#001535] tracking-tight mb-2">SiPinjam</h1>
                <p class="text-[#44474E] text-sm tracking-wide">Sistem Informasi Peminjaman Alat</p>
            </div>

            @if ($errors->any())
                <div class="mb-8 flex items-center gap-3 p-4 bg-[#FFDAD6] text-[#93000A] rounded-xl border-l-4 border-[#BA1A1A]">
                    <span class="material-symbols-outlined text-[#BA1A1A]">error</span>
                    <span class="text-sm font-medium">Username atau password salah</span>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-8 p-4 rounded-xl bg-[#D6E3FF] text-[#134684] text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div class="space-y-2 group">
                    <label class="block text-xs font-semibold uppercase tracking-[0.05em] text-[#44474E] px-1" for="email">
                        Username atau Email
                    </label>
                    <div class="login-field-wrap">
                        <span class="material-symbols-outlined login-field-icon">person</span>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="login-field-input"
                            placeholder="Masukkan identitas Anda"
                        >
                    </div>
                </div>

                <div class="space-y-2 group">
                    <div class="flex justify-between items-center px-1">
                        <label class="block text-xs font-semibold uppercase tracking-[0.05em] text-[#44474E]" for="password">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a class="text-xs font-semibold text-[#0098EE] hover:underline decoration-2 underline-offset-4" href="{{ route('password.request') }}">Lupa Password?</a>
                        @endif
                    </div>
                    <div class="login-field-wrap">
                        <span class="material-symbols-outlined login-field-icon">lock</span>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="login-field-input login-password-input"
                            placeholder="••••••••"
                        >
                        <button class="login-eye-btn" type="button" onclick="const p=document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';">
                            <span class="material-symbols-outlined">visibility</span>
                        </button>
                    </div>
                </div>

                <div class="py-4 px-5 bg-[#F4F3F7] rounded-xl">
                    <p class="text-[11px] font-bold text-[#74777F] uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-1 h-1 rounded-full bg-[#0098EE]"></span>
                        Petunjuk Akses Peran
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-[#E3E2E6] text-[#001535] text-[10px] font-bold rounded-full border border-[#C4C6D0]/40">ADMIN</span>
                        <span class="px-3 py-1 bg-[#E3E2E6] text-[#001535] text-[10px] font-bold rounded-full border border-[#C4C6D0]/40">PETUGAS</span>
                        <span class="px-3 py-1 bg-[#E3E2E6] text-[#001535] text-[10px] font-bold rounded-full border border-[#C4C6D0]/40">PEMINJAM</span>
                    </div>
                </div>

                <button class="login-submit group" type="submit">
                    Masuk ke Sistem
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </form>

            @if (Route::has('register'))
                <div class="mt-10 pt-8 border-t border-[#C4C6D0]/20 text-center">
                    <p class="text-sm text-[#44474E]">
                        Belum memiliki akun?
                        <a class="font-bold text-[#0098EE] hover:underline decoration-2 underline-offset-4" href="{{ route('register') }}">Daftar Sekarang</a>
                    </p>
                </div>
            @endif
        </div>

        <footer class="mt-8 flex justify-center items-center gap-6 text-[11px] text-[#74777F] font-medium tracking-tighter">
            <div class="flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                Sistem Aktif
            </div>
            <span>v2.4.0-Stable</span>
            <a class="hover:text-[#001535] transition-colors" href="#">Pusat Bantuan</a>
        </footer>
    </main>
</body>
</html>
