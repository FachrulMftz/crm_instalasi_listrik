<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRM Listrik Bro</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Main --}}
    <div class="ml-64 flex-1">

        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="font-semibold text-lg">Dashboard</h1>
            <div class="flex items-center gap-4">
                <span class="text-gray-700 font-medium">
                        {{ Auth::check() ? Auth::user()->name : '' }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white
                               px-4 py-2 rounded-lg font-semibold transition"
                    >
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>