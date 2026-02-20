@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-xl font-bold mb-4">Tambah User</h1>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-medium">Nama</label>
            <input type="text" name="name"
                   class="w-full border rounded p-2"
                   required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Email</label>
            <input type="email" name="email"
                   class="w-full border rounded p-2"
                   required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded p-2"
                   required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Role</label>
            <select name="role" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Role --</option>

                @if(auth()->user()->role === 'superadmin')
                <option value="admin">Admin</option>
                @endif
                <option value="sales">Sales</option>
                <option value="teknisi">Teknisi</option>
            </select>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('admin.users.index') }}"
               class="px-4 py-2 border rounded">
                Batal
            </a>

            <button class="bg-cyan-600 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </div>

    </form>
</div>
@endsection