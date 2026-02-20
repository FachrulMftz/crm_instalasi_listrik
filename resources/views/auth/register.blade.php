<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register CRM Instalasi Listrik</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center bg-cyan-400 px-4">

    <div class="w-100 max-w-md bg-white rounded-2xl shadow-xl p-6 sm:p-8">

        <h2 class="text-2xl font-bold text-center text-cyan-600 mb-6">
            Register CRM
        </h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Nama -->
            <div>
                <label class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                <input type="text" name="name" required
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-cyan-400">
                @error('name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-600">Email</label>
                <input type="email" name="email" required
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-cyan-400">
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" name="password" required
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-cyan-400">
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label class="block text-sm font-medium text-gray-600">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-cyan-400">
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-medium text-gray-600">Role</label>
                <select name="role" required
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-cyan-400">
                    <option value="">-- Pilih Role --</option>
                    <option value="sales">Sales</option>
                    <option value="teknisi">Teknisi</option>
                </select>
            </div>

            <!-- Tombol Register (HARUS di dalam form) -->
            <button type="submit"
                class="w-full bg-cyan-500 hover:bg-cyan-600
                       text-white py-2.5 rounded-lg font-semibold transition">
                Register
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-cyan-600 hover:underline font-medium">
                Login
            </a>
        </p>

    </div>

</body>
</html>