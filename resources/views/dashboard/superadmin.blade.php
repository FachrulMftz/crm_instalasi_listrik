@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <h1 class="text-3xl font-bold text-cyan-600 mb-6">
        Dashboard Superadmin
    </h1>

    {{-- GRID MENU --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

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
