@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 shadow rounded">
    <h1 class="text-2xl font-bold text-blue-600 mb-6">
        Detail Opportunity
    </h1>

    <div class="space-y-3 text-gray-700">
        <p><strong>Judul:</strong> {{ $opportunity->title }}</p>
        <p><strong>Customer:</strong> {{ $opportunity->customer->name }}</p>
        <p><strong>Nilai:</strong> Rp {{ number_format($opportunity->value, 0, ',', '.') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($opportunity->status) }}</p>
        <p><strong>Expected Close:</strong>
            {{ $opportunity->expected_close_date?->format('d M Y') ?? '-' }}
        </p>
        <p><strong>Deskripsi:</strong><br>{{ $opportunity->description }}</p>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('opportunities.edit', $opportunity->id) }}"
           class="px-4 py-2 bg-yellow-500 text-white rounded">
            Edit
        </a>
        <a href="{{ route('opportunities.index') }}"
           class="px-4 py-2 border rounded">
            Kembali
        </a>
    </div>
</div>
@endsection
