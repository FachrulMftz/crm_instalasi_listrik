@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('installation.my') }}" 
                       class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Daftar
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Detail Instalasi #{{ $installation->id }}
                    </h1>
                </div>

                @if(auth()->user()->role === 'teknisi' && $installation->status !== 'completed')
                <a href="{{ route('teknisi.report.create', $installation->id) }}"
                   class="inline-flex items-center px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-medium rounded-lg transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Update Progress
                </a>
                @endif
            </div>
        </div>

        <!-- Installation Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Informasi Instalasi</h2>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Customer</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">
                            {{ $installation->opportunity->customer->name ?? 'N/A' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Teknisi</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">
                            {{ $installation->technician->name ?? 'Belum ditugaskan' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jadwal Mulai</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $installation->scheduled_start?->format('d F Y, H:i') ?? '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jadwal Selesai</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $installation->scheduled_end?->format('d F Y, H:i') ?? '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            @php
                                $statusMap = [
                                    'completed'   => ['bg'=>'bg-green-100','text'=>'text-green-800','label'=>'Selesai'],
                                    'in_progress' => ['bg'=>'bg-blue-100','text'=>'text-blue-800','label'=>'Dalam Progress'],
                                    'cancelled'   => ['bg'=>'bg-red-100','text'=>'text-red-800','label'=>'Dibatalkan'],
                                    'pending'     => ['bg'=>'bg-yellow-100','text'=>'text-yellow-800','label'=>'Pending'],
                                ];
                                $status = $statusMap[$installation->status] ?? $statusMap['pending'];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }}">
                                {{ $status['label'] }}
                            </span>
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Progress</dt>
                        <dd class="mt-1">
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-blue-600 h-2 rounded-full"
                                         style="width: {{ $installation->progress ?? 0 }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ $installation->progress ?? 0 }}%
                                </span>
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Checklist -->
        @if($installation->checklist && count($installation->checklist))
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Checklist Pekerjaan</h2>
            </div>
            <div class="p-6 space-y-2">
                @foreach($installation->checklist as $item)
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                              clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm text-gray-700">
                        {{ ucfirst(str_replace('_',' ',$item)) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Photos -->
        @if($installation->photos && count($installation->photos))
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Foto Dokumentasi</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($installation->photos as $photo)
                    <a href="{{ Storage::url($photo) }}" target="_blank" class="group">
                        <img src="{{ Storage::url($photo) }}"
                             class="w-full h-32 object-cover rounded-lg border-2 border-gray-200 group-hover:border-blue-500 transition">
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection