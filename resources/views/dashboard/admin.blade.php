@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <h1 class="text-3xl font-bold text-cyan-600 mb-6">
        Dashboard Admin
    </h1>

    {{-- GRID MENU --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- CUSTOMER --}}
        <a href="{{ route('customer.index') }}"
           class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition border-l-4 border-cyan-500">
            <h2 class="text-xl font-semibold text-gray-800">Customer</h2>
            <p class="text-sm text-gray-500 mt-2">
                Kelola data pelanggan
            </p>
        </a>

        {{-- OPPORTUNITY --}}
        <a href="{{ route('opportunities.index') }}"
           class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition border-l-4 border-blue-500">
            <h2 class="text-xl font-semibold text-gray-800">Opportunity</h2>
            <p class="text-sm text-gray-500 mt-2">
                Pipeline penjualan & peluang proyek
            </p>
        </a>

        {{-- ACTIVITY --}}
        <a href="{{ route('activity.index') }}"
           class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition border-l-4 border-indigo-500">
            <h2 class="text-xl font-semibold text-gray-800">Activity</h2>
            <p class="text-sm text-gray-500 mt-2">
                Aktivitas sales & follow up
            </p>
        </a>

        {{-- INSTALLATION (TEKNISI) --}}
        <a href="{{ route('installation.my') }}"
           class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition border-l-4 border-green-500">
            <h2 class="text-xl font-semibold text-gray-800">Installation</h2>
            <p class="text-sm text-gray-500 mt-2">
                Monitoring progres instalasi teknisi
            </p>
        </a>

        {{-- REPORT TEKNISI --}}
        <a href="{{ route('teknisi.report') }}"
           class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition border-l-4 border-emerald-500">
            <h2 class="text-xl font-semibold text-gray-800">Laporan Teknisi</h2>
            <p class="text-sm text-gray-500 mt-2">
                Laporan pekerjaan lapangan
            </p>
        </a>

        {{-- USER MANAGEMENT --}}
        <a href="{{ route('admin.users.index') }}"
           class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition border-l-4 border-red-500">
            <h2 class="text-xl font-semibold text-gray-800">User Management</h2>
            <p class="text-sm text-gray-500 mt-2">
                Kelola akun admin, sales & teknisi
            </p>
        </a>

    </div>
</div>
@endsection
