@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-xl font-bold mb-4">Edit User</h1>

    <form method="POST" action="{{ route('admin.users.update',$user) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Nama</label>
            <input type="text" name="name"
                   class="w-full border rounded p-2"
                   value="{{ $user->name }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Email</label>
            <input type="email" name="email"
                   class="w-full border rounded p-2"
                   value="{{ $user->email }}" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">
                Password <span class="text-sm text-gray-500">(opsional)</span>
            </label>
            <input type="password" name="password"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Role</label>
            <select name="role" class="w-full border rounded p-2" required>

                @if(auth()->user()->role === 'superadmin')
                    <option value="admin"
                        {{ $user->role === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                @endif
                <option value="sales" {{ $user->role === 'sales' ? 'selected' : '' }}>
                    Sales
                </option>
                <option value="teknisi" {{ $user->role === 'teknisi' ? 'selected' : '' }}>
                    Teknisi
                </option>
            </select>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('admin.users.index') }}"
               class="px-4 py-2 border rounded">
                Batal
            </a>

            <button class="bg-yellow-500 text-white px-4 py-2 rounded">
                Update
            </button>
        </div>

    </form>
</div>
@endsection
