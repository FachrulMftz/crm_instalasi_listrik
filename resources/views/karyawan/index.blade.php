@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2
                                     c0-.656-.126-1.283-.356-1.857M7 20H2v-2
                                     a3 3 0 015.356-1.857M7 20v-2
                                     c0-.656.126-1.283.356-1.857
                                     m0 0a5.002 5.002 0 019.288 0
                                     M15 7a3 3 0 11-6 0
                                     3 3 0 016 0z"/>
                        </svg>
                        Data Karyawan
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Kelola data teknisi dan sales
                    </p>
                </div>

                @if(auth()->user()->role === 'admin')
                <a href="{{ route('karyawan.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700
                          text-white rounded-lg text-sm font-medium transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Karyawan
                </a>
                @endif
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
        @endif

        <!-- Table -->
        @if($users->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Karyawan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Role
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- Karyawan -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full
                                                flex items-center justify-center">
                                        <span class="text-blue-600 font-semibold">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-6 py-4 text-sm text-gray-900">
                            @php
                                $email = $user->email;
                                [$name, $domain] = explode('@', $email);
                                $maskedName = substr($name, 0, 2) . str_repeat('*', max(strlen($name) - 2, 2));
                                $maskedEmail = $maskedName . '@' . $domain;
                            @endphp
                            {{ $maskedEmail }}
                            </td>

                            <!-- Role -->
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($user->role === 'admin')
                                        bg-red-100 text-red-700
                                    @elseif($user->role === 'teknisi')
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-green-100 text-green-700
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('karyawan.show', $user) }}"
                                   class="text-blue-600 hover:text-blue-900">
                                    Lihat
                                </a>

                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('karyawan.edit', $user) }}"
                                   class="text-yellow-600 hover:text-yellow-900">
                                    Edit
                                </a>

                                <form action="{{ route('karyawan.destroy', $user) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Hapus karyawan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-900">
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12">
            <div class="text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2
                             c0-.656-.126-1.283-.356-1.857M7 20H2v-2
                             a3 3 0 015.356-1.857"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">
                    Belum Ada Karyawan
                </h3>
                <p class="mt-2 text-sm text-gray-500">
                    Tambahkan teknisi atau sales untuk mulai bekerja.
                </p>

                @if(auth()->user()->role === 'admin')
                <div class="mt-6">
                    <a href="{{ route('karyawan.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600
                              hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Karyawan
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
