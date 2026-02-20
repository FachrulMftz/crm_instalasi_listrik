@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Instalasi</h1>
        <div class="text-sm text-gray-600">
            Total: <span class="font-semibold">{{ $installations->total() }}</span> instalasi
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-cyan-50 to-teal-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Jadwal</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Progress</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($installations as $installation)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">#{{ $installation->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $installation->opportunity->customer->name ?? 'N/A' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $installation->opportunity->customer->phone ?? '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700">
                                {{ Str::limit($installation->opportunity->customer->address ?? '-', 40) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $installation->scheduled_start ? $installation->scheduled_start->format('d M Y') : '-' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $installation->scheduled_start ? $installation->scheduled_start->format('H:i') : '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                                $statusConfig = [
                                    'pending' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => 'Pending', 'icon' => ''],
                                    'in_progress' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Pemasangan', 'icon' => 'Proses'],
                                    'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Selesai', 'icon' => ''],
                                    'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Batal', 'icon' => ''],
                                ];
                                $config = $statusConfig[$installation->status] ?? $statusConfig['pending'];
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
                                {{ $config['icon'] }} {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center">
                                <div class="w-24 bg-gray-200 rounded-full h-2.5 mr-2">
                                    <div class="h-2.5 rounded-full transition-all duration-300 
                                        @if($installation->progress >= 100) bg-green-600
                                        @elseif($installation->progress >= 50) bg-cyan-600
                                        @else bg-blue-500
                                        @endif" 
                                         style="width: {{ $installation->progress ?? 0 }}%">
                                    </div>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ $installation->progress ?? 0 }}%
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex justify-center gap-2">
                                <!-- Tombol Detail -->
                                <a href="{{ route('installation.show', $installation->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded transition duration-150"
                                   title="Lihat Detail">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>

                                <!-- Tombol Tambah Progress -->
                                @if($installation->status !== 'completed' && $installation->status !== 'cancelled')
                                <a href="{{ route('teknisi.report.create', $installation->id) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-cyan-500 hover:bg-cyan-600 text-white text-xs font-medium rounded transition duration-150"
                                       title="Tambah Progress"> 
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v6h6M20 20v-6h-6M5 19a9 9 0 0014-7M19 5a9 9 0 00-14 7"/>
                                    </svg>
                                    Update Progress
                                </a>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 bg-gray-300 text-gray-600 text-xs font-medium rounded cursor-not-allowed" 
                                          title="Instalasi sudah selesai">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Selesai
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="mt-4 text-gray-500 font-medium">Tidak ada instalasi yang ditugaskan</p>
                            <p class="text-sm text-gray-400 mt-1">Instalasi baru akan muncul di sini ketika ditugaskan oleh admin</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $installations->links() }}
    </div>
</div>
@endsection