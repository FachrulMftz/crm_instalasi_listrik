@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

        <h1 class="text-2xl font-bold mb-4">Edit Karyawan</h1>

        <form method="POST" action="{{ route('karyawan.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm mb-1">Nama</label>
                <input type="text" name="name"
                       value="{{ $user->name }}"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email"
                       value="{{ $user->email }}"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            <div class="mb-6">
                <label class="block text-sm mb-1">Role</label>
                <select name="role" class="w-full border rounded px-3 py-2">
                    <option value="teknisi" @selected($user->role=='teknisi')>
                        Teknisi
                    </option>
                    <option value="sales" @selected($user->role=='sales')>
                        Sales
                    </option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('karyawan.index') }}"
                   class="px-4 py-2 border rounded">
                    Batal
                </a>

                <button class="px-4 py-2 bg-indigo-600 text-white rounded">
                    Update
                </button>
            </div>
        </form>

    </div>
</div>
@endsection