@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

        <h1 class="text-2xl font-bold mb-4">Detail Karyawan</h1>

        <div class="space-y-3 text-sm">
            <div>
                <span class="text-gray-500">Nama:</span>
                <div class="font-medium">{{ $user->name }}</div>
            </div>

            <div>
                <span class="text-gray-500">Email:</span>
                <div class="font-medium">{{ $user->email }}</div>
            </div>

            <div>
                <span class="text-gray-500">Role:</span>
                <div class="font-medium capitalize">{{ $user->role }}</div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('karyawan.index') }}"
               class="px-4 py-2 border rounded">
                Kembali
            </a>
        </div>

    </div>
</div>
@endsection