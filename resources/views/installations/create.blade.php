@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">
    <h1 class="text-xl font-bold mb-6">Buat Laporan Instalasi</h1>

    <form method="POST" action="{{ route('installations.store') }}" enctype="multipart/form-data"
          class="space-y-5">
        @csrf

        <input type="hidden" name="opportunity_id" value="{{ $opportunity->id ?? '' }}">

        <div>
            <label class="block font-medium">Status</label>
            <select name="status" class="w-full border rounded p-2">
                <option value="scheduled">Scheduled</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div>
            <label class="block font-medium">Progress (%)</label>
            <input type="number" name="progress" class="w-full border rounded p-2" min="0" max="100">
        </div>

        <div>
            <label class="block font-medium mb-2">Checklist Instalasi</label>
            <div class="space-y-2">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="checklist[kabel]"> Kabel terpasang
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="checklist[mcb]"> MCB terpasang
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="checklist[grounding]"> Grounding aman
                </label>
            </div>
        </div>

        <div>
            <label class="block font-medium">Foto Dokumentasi</label>
            <input type="file" name="photos[]" multiple class="w-full border rounded p-2">
        </div>

        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Simpan Laporan
        </button>
    </form>
</div>
@endsection