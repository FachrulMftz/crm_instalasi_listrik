@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">
    <h1 class="text-xl font-bold mb-6">Edit Laporan Instalasi</h1>

    <form method="POST" action="{{ route('installations.update',$installation) }}"
          enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Status</label>
            <select name="status" class="w-full border rounded p-2">
                @foreach(['scheduled','in_progress','completed'] as $status)
                    <option value="{{ $status }}"
                        {{ $installation->status === $status ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_',' ',$status)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Progress</label>
            <input type="number" name="progress"
                   value="{{ $installation->progress }}"
                   class="w-full border rounded p-2">
        </div>

        <button class="w-full bg-yellow-500 text-white py-2 rounded hover:bg-yellow-600">
            Update
        </button>
    </form>
</div>
@endsection
