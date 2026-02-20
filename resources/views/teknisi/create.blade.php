@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <!-- WRAPPER UTAMA: KUNCI KERAPIAN -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Header -->
        <div>
            <div class="flex items-center gap-4">
                <a href="{{ route('teknisi.report') }}"
                   class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Tambah Progress Instalasi
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Instalasi #{{ $installation->id }} - {{ $installation->opportunity->customer->name ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Info Instalasi -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-sm font-medium text-blue-900 mb-4">Informasi Instalasi</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-blue-700 font-medium">Customer:</p>
                    <p class="text-blue-900">{{ $installation->opportunity->customer->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-blue-700 font-medium">Alamat:</p>
                    <p class="text-blue-900">{{ $installation->opportunity->customer->address ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-blue-700 font-medium">Jadwal Mulai:</p>
                    <p class="text-blue-900">
                        {{ $installation->scheduled_start?->format('d M Y H:i') ?? '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-blue-700 font-medium">Jadwal Selesai:</p>
                    <p class="text-blue-900">
                        {{ $installation->scheduled_end?->format('d M Y H:i') ?? '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-blue-700 font-medium">Progress Saat Ini:</p>
                    <p class="text-blue-900 font-bold">{{ $installation->progress ?? 0 }}%</p>
                </div>
                <div>
                    <p class="text-blue-700 font-medium">Status Saat Ini:</p>
                    <p class="text-blue-900 font-bold">{{ ucfirst($installation->status) }}</p>
                </div>
            </div>
        </div>

        <!-- FORM UTAMA -->
        <form id="report-store-form"
              action="{{ route('teknisi.report.store', $installation->id) }}"
              method="POST"
              class="bg-white shadow rounded-lg p-8 space-y-6">
            @csrf

            <!-- Progress -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Progress Pekerjaan (%) <span class="text-red-500">*</span>
                </label>

                <div class="flex items-center gap-4">
                    <input type="range"
                           name="progress"
                           id="progress-slider"
                           min="0" max="100"
                           value="{{ $installation->progress ?? 0 }}"
                           class="flex-1 h-2 bg-gray-200 rounded-lg cursor-pointer accent-cyan-600"
                           oninput="updateProgressValue(this.value)">
                    <input type="number"
                           id="progress-input"
                           min="0" max="100"
                           value="{{ $installation->progress ?? 0 }}"
                           class="w-20 border-gray-300 rounded-lg text-center font-semibold"
                           oninput="updateProgressSlider(this.value)">
                    <span class="font-bold text-cyan-600">%</span>
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status Pekerjaan <span class="text-red-500">*</span>
                </label>

                <select name="status" required
                        class="w-full border-gray-300 rounded-lg">
                    <option value="pending" @selected($installation->status === 'pending')>Pending</option>
                    <option value="in_progress" @selected($installation->status === 'in_progress')>Sedang Dikerjakan</option>
                    <option value="completed" @selected($installation->status === 'completed')>Selesai</option>
                    <option value="cancelled" @selected($installation->status === 'cancelled')>Dibatalkan</option>
                </select>
            </div>
        </form>

        <!-- Checklist -->
        <div class="bg-white shadow rounded-lg p-8 space-y-4">
            <label class="block text-sm font-medium text-gray-700">
                Checklist Pekerjaan
            </label>

            @php
                $checklistItems = [
                    'panel' => 'Panel listrik terpasang',
                    'grounding' => 'Sistem grounding',
                    'kabel' => 'Instalasi kabel',
                    'mcb' => 'MCB & proteksi',
                    'testing' => 'Pengujian sistem',
                ];
                $currentChecklist = old('checklist', $installation->checklist ?? []);
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($checklistItems as $key => $label)
                    <label class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition">
                        <input type="checkbox"
                               name="checklist[]"
                               value="{{ $key }}"
                               {{ in_array($key, $currentChecklist) ? 'checked' : '' }}
                               class="h-5 w-5 text-cyan-600 border-gray-300 rounded focus:ring-cyan-500">
                        <span class="text-sm text-gray-700 font-medium">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- FOTO -->
        @if($installation->photos && count($installation->photos))
        <div class="bg-white shadow rounded-lg p-8 space-y-4">
            <p class="text-xs font-medium">Foto yang sudah diupload:</p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($installation->photos as $i => $photo)
                <div class="relative">
                    <img src="{{ Storage::url($photo) }}"
                         class="w-full h-24 object-cover rounded-lg border">

                    @if($installation->status !== 'completed')
                    <button type="button"
                            onclick="if(confirm('Hapus foto ini?')) document.getElementById('delete-photo-{{ $i }}').submit()"
                            class="absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs shadow">
                        ✕
                    </button>
                    @endif
                </div>

                <form id="delete-photo-{{ $i }}"
                      action="{{ route('teknisi.report.photo.delete', $installation->id) }}"
                      method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="photo" value="{{ $photo }}">
                </form>
                @endforeach
            </div>
        </div>
        @endif

        <!-- UPLOAD FOTO -->
        <form action="{{ route('teknisi.report.store', $installation->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="bg-white shadow rounded-lg p-8 space-y-3">
            @csrf

            <label class="block text-sm font-medium">
                Upload Foto Dokumentasi (Max 5MB / foto)
            </label>

            <input type="file"
                   name="photos[]"
                   multiple
                   accept="image/*"
                   onchange="this.form.submit()"
                   class="block w-full text-sm text-gray-600
                          file:mr-4 file:py-2.5 file:px-4
                          file:rounded-lg file:border-0
                          file:text-sm file:font-semibold
                          file:bg-cyan-50 file:text-cyan-700
                          hover:file:bg-cyan-100 cursor-pointer
                          border border-gray-300 rounded-lg">
        </form>

        <!-- ACTIONS -->
        <div class="flex justify-end gap-3">
            <button type="submit"
                    form="report-store-form"
                    class="px-6 py-2 bg-cyan-600 hover:bg-cyan-700 text-white rounded-lg text-sm font-medium shadow-md">
                Simpan Progress
            </button>

            <button type="submit">
            <a href="{{ route('customer.index') }}"
               class="px-6 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700">
                Batal
            </a>
            </button>
        </div>

    </div>
</div>

<script>
function updateProgressValue(val) {
    document.getElementById('progress-input').value = val;
}
function updateProgressSlider(val) {
    document.getElementById('progress-slider').value = val;
}
</script>
@endsection