@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Manajemen User Sistem
                </h1>
                <p class="text-sm text-gray-500">
                    Kelola akun dan hak akses pengguna User Sistem
                </p>
            </div>

            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700
                      text-white px-4 py-2 rounded-lg text-sm font-semibold">
                <span class="text-xl">+</span> Tambah User
            </a>
        </div>

        <!-- Alert -->
        @if(session('success'))
            <div class="mb-5 bg-green-100 border-l-4 border-green-500 p-4 rounded">
                <p class="text-green-700 text-sm">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white rounded-xl shadow border overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr class="text-left text-sm text-gray-600">
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-indigo-100
                                        flex items-center justify-center font-bold text-indigo-600">
                                {{ strtoupper(substr($user->name,0,2)) }}
                            </div>
                            <span class="font-medium text-gray-800">
                                {{ $user->name }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-gray-700 text-sm">
                             @php
                                $email = $user->email;
                                [$name, $domain] = explode('@', $email);
                                $maskedName = substr($name, 0, 2) . str_repeat('*', max(strlen($name) - 2, 2));
                                $maskedEmail = $maskedName . '@' . $domain;
                            @endphp
                            {{ $maskedEmail }}
                        </td>

                        <td class="px-6 py-4">
                          <span
                            @class([
                                'px-3 py-1 rounded-full text-xs font-semibold',
                                'bg-red-100 text-red-700' => $user->role === 'superadmin',
                                'bg-blue-100 text-blue-700' => $user->role === 'admin',
                                'bg-green-100 text-green-700' => $user->role === 'sales',
                                'bg-yellow-100 text-yellow-700' => $user->role === 'teknisi',
                            ])>
                                {{ ucfirst($user->role) }}
                          </span>

                        </td>

                        <td class="px-6 py-4 text-sm flex gap-3">
                            <a href="{{ route('admin.users.edit',$user) }}"
                               class="text-indigo-600 hover:underline">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.users.destroy',$user) }}"
                                  onsubmit="return confirm('Hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-10 text-gray-500">
                            Belum ada data user
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection