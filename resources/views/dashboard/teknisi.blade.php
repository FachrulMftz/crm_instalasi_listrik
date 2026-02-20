@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    <!-- Judul -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-cyan-600">
            Dashboard Teknisi
        </h1>
        <span class="text-sm text-gray-500">
            {{ now()->translatedFormat('l, d F Y') }}
        </span>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Tugas Hari Ini</p>
            <h2 class="text-3xl font-bold text-cyan-600">{{ $stats['today'] }}</h2>
        </div>
        <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Dalam Proses</p>
            <h2 class="text-3xl font-bold text-yellow-500">{{ $stats['in_progress'] }}</h2>
        </div>
        <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Selesai</p>
            <h2 class="text-3xl font-bold text-green-500">{{ $stats['completed'] }}</h2>
        </div>
        <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Pending</p>
            <h2 class="text-3xl font-bold text-red-500">{{ $stats['pending'] }}</h2>
        </div>
    </div>

    <!-- Alert Tugas Mendesak -->
    @if($urgentInstallations > 0)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    Anda memiliki <strong>{{ $urgentInstallations }}</strong> instalasi yang deadline-nya kurang dari 3 hari!
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Daftar Tugas Instalasi -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">
                Daftar Instalasi Terbaru
            </h2>
            <a href="{{ route('teknisi.report') }}" 
               class="text-sm text-cyan-600 hover:text-cyan-700 font-medium">
                Lihat Semua →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border text-sm">
                <thead class="bg-cyan-50 text-cyan-700">
                    <tr>
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">Customer</th>
                        <th class="p-3 text-left">Alamat</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-center">Progress</th>
                        <th class="p-3 text-center">Status</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($installations as $installation)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">#{{ $installation->id }}</td>
                        <td class="p-3 font-medium">
                            {{ $installation->opportunity->customer->name ?? 'N/A' }}
                        </td>
                        <td class="p-3 text-gray-600">
                            {{ Str::limit($installation->opportunity->customer->address ?? '-', 30) }}
                        </td>
                        <td class="p-3 text-gray-600">
                            {{ $installation->scheduled_start ? \Carbon\Carbon::parse($installation->scheduled_start)->format('d M Y') : '-' }}
                        </td>
                        <td class="p-3 text-center">
                            <div class="flex items-center justify-center">
                                <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                    <div class="bg-cyan-600 h-2 rounded-full" 
                                         style="width: {{ $installation->progress ?? 0 }}%"></div>
                                </div>
                                <span class="text-xs font-medium">{{ $installation->progress ?? 0 }}%</span>
                            </div>
                        </td>
                        <td class="p-3 text-center">
                            @php
                                $statusConfig = [
                                    'pending' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => 'Pending'],
                                    'in_progress' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Proses'],
                                    'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Selesai'],
                                    'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Batal'],
                                ];
                                $config = $statusConfig[$installation->status] ?? $statusConfig['pending'];
                            @endphp
                            <span class="px-3 py-1 rounded-full {{ $config['bg'] }} {{ $config['text'] }} text-xs font-medium">
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="p-3 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('installation.show', $installation->id) }}" 
                                   class="text-cyan-600 hover:text-cyan-700 font-medium text-xs">
                                    Detail
                                </a>
                                @if($installation->status !== 'completed')
                                <a href="{{ route('teknisi.report.create', $installation->id) }}" 
                                   class="text-green-600 hover:text-green-700 font-medium text-xs">
                                    Update
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-6 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="mt-2">Belum ada instalasi yang ditugaskan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Grid 2 Kolom -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Instalasi Hari Ini -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold mb-3 text-gray-700">
                Tugas Hari Ini
            </h2>

            @if($todayInstallations->count() > 0)
                <ul class="space-y-3 text-sm">
                    @foreach($todayInstallations as $task)
                    <li class="p-3 bg-cyan-50 rounded border-l-4 border-cyan-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-800">
                                    {{ $task->opportunity->customer->name ?? 'N/A' }}
                                </p>
                                <p class="text-xs text-gray-600 mt-1">
                                    {{ Str::limit($task->opportunity->customer->address ?? '-', 40) }}
                                </p>
                            </div>
                            <span class="text-xs px-2 py-1 bg-cyan-200 text-cyan-800 rounded">
                                {{ $task->progress ?? 0 }}%
                            </span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 text-sm text-center py-4">
                    Tidak ada tugas untuk hari ini
                </p>
            @endif
        </div>

        <!-- Notifikasi / Info Penting -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold mb-3 text-gray-700">
                Informasi Penting
            </h2>

            <ul class="space-y-3 text-sm">
                @if($stats['today'] > 0)
                <li class="p-3 bg-cyan-50 rounded flex items-start">
                    <svg class="h-5 w-5 text-cyan-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    <span>Anda memiliki {{ $stats['today'] }} tugas instalasi hari ini</span>
                </li>
                @endif

                @if($urgentInstallations > 0)
                <li class="p-3 bg-yellow-50 rounded flex items-start">
                    <svg class="h-5 w-5 text-yellow-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $urgentInstallations }} instalasi mendekati deadline</span>
                </li>
                @endif

                @if($stats['in_progress'] > 0)
                <li class="p-3 bg-blue-50 rounded flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $stats['in_progress'] }} instalasi sedang dalam proses</span>
                </li>
                @endif

                @if($stats['completed'] > 0)
                <li class="p-3 bg-green-50 rounded flex items-start">
                    <svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $stats['completed'] }} instalasi telah selesai</span>
                </li>
                @endif
            </ul>
        </div>

    </div>
</div>
@endsection