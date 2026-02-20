<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login CRM Instalasi Listrik</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center bg-cyan-400 px-4">

    <div class=" max-w-md bg-white rounded-2xl shadow-xl p-6 sm:p-8">
        
        <!-- Judul -->
        <h2 class="text-2xl font-bold text-center text-black-600 mb-6">
            CRM Instalasi Listrik
        </h2>
@if(session('lockout'))
<div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm text-center">
    Terlalu banyak percobaan login.  
    Coba lagi dalam <b><span id="countdown">{{ session('lockout') }}</span></b> detik.
</div>
@endif

    @if(session('remaining_attempts') !== null)
<div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4 text-sm text-center">
    Sisa kesempatan login: 
    <b>{{ session('remaining_attempts') }}</b>
</div>
@endif
        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Username -->
            <div>
                <label class="block text-sm font-medium text-gray-600">
                    Username
                </label>
                <input 
                    type="text" 
                    name="username" 
                    required
                    placeholder="Masukkan username"
                    class="w-full mt-1 px-4 py-2 border rounded-lg 
                           focus:ring-2 focus:ring-cyan-400 
                           focus:outline-none transition"
                >
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-600">
                    Email
                </label>
                <input 
                    type="email" 
                    name="email" 
                    required
                    placeholder="contoh@email.com"
                    class="w-full mt-1 px-4 py-2 border rounded-lg 
                           focus:ring-2 focus:ring-cyan-400 
                           focus:outline-none transition"
                >
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-600">
                    Password
                </label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    placeholder="••••••••"
                    class="w-full mt-1 px-4 py-2 border rounded-lg 
                           focus:ring-2 focus:ring-cyan-400 
                           focus:outline-none transition"
                >
            </div>

            <!-- Tombol Login -->
            <button 
                type="submit"
                class="w-full bg-cyan-500 hover:bg-cyan-600 
                       text-white py-2.5 rounded-lg 
                       font-semibold transition duration-200"
            >
                Login
            </button>
            
            @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            <p class="text-center text-sm text-gray-500 mt-4">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-cyan-600 hover:underline font-medium">
                    Daftar di sini
                </a>
            </p>

        </form>
@if(session('lockout'))
<script>
let seconds = {{ session('lockout') }};
const countdownEl = document.getElementById('countdown');
const form = document.querySelector('form');

// Nonaktifkan semua input & tombol
form.querySelectorAll('input, button').forEach(el => el.disabled = true);

const timer = setInterval(() => {
    seconds--;
    countdownEl.innerText = seconds;

    if (seconds <= 0) {
        clearInterval(timer);
        form.querySelectorAll('input, button').forEach(el => el.disabled = false);
        location.reload();
    }
}, 1000);
</script>
@endif        <!-- Footer -->
        <p class="text-center text-sm text-gray-400 mt-6">
            © {{ date('Y') }} CRM Instalasi Listrik
        </p>
    </div>
</body>
</html>
@if (session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
        {{ session('success') }}
    </div>
@endif