@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-cyan-600">
            Dashboard Sales
        </h1>
        <p class="text-gray-500 mt-1">
            Ringkasan aktivitas dan pipeline penjualan Anda
        </p>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        {{-- CUSTOMER --}}
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-cyan-500">
            <h2 class="text-sm text-gray-500">Total Customer</h2>
            <p class="text-3xl font-bold text-gray-800">
                {{ $totalCustomer ?? ' ' }}
            </p>
            <a href="{{ route('customer.index') }}"
               class="text-cyan-600 text-sm mt-2 inline-block hover:underline">
                Lihat Customer →
            </a>
        </div>

        {{-- opportunities --}}
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-500">
            <h2 class="text-sm text-gray-500">Total opportunities</h2>
            <p class="text-3xl font-bold text-gray-800">
                {{ $totalOpportunity ?? ' ' }}
            </p>
            <a href="{{ route('opportunities.index') }}"
               class="text-blue-600 text-sm mt-2 inline-block hover:underline">
                Lihat opportunities →
            </a>
        </div>

        {{-- ACTIVITY --}}
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-indigo-500">
            <h2 class="text-sm text-gray-500">Aktivitas Hari Ini</h2>
            <p class="text-3xl font-bold text-gray-800">
                {{ $todayActivity ?? ' '}}
            </p>
            <a href="{{ route('activity.index') }}"
               class="text-indigo-600 text-sm mt-2 inline-block hover:underline">
                Lihat Aktivitas →
            </a>
        </div>

    </div>

    {{-- QUICK ACTION --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <a href="{{ route('customer.create') }}"
           class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
            <h3 class="font-semibold text-gray-800">Tambah Customer</h3>
            <p class="text-sm text-gray-500 mt-1">
                Masukkan data pelanggan baru
            </p>
        </a>

        <a href="{{ route('opportunities.create') }}"
           class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
            <h3 class="font-semibold text-gray-800">Tambah opportunities</h3>
            <p class="text-sm text-gray-500 mt-1">
                Buat peluang penjualan baru
            </p>
        </a>

        <a href="{{ route('activity.create') }}"
           class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
            <h3 class="font-semibold text-gray-800">Tambah Aktivitas</h3>
            <p class="text-sm text-gray-500 mt-1">
                Catat call, meeting, dan follow-up
            </p>
        </a>

    </div>

</div>
@endsection
