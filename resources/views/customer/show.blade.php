@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 shadow rounded-lg">

    <!-- Header -->
    <h1 class="text-2xl font-bold text-cyan-600 mb-6">
        Detail Customer
    </h1>

    <!-- Detail -->
    <div class="space-y-3 text-gray-700">
        <p>
            <strong>Nama:</strong>
            {{ $customer->name }}
        </p>

        <p>
            <strong>Email:</strong>
            {{ $customer->email ?? '-' }}
        </p>

        <p>
            <strong>Telepon:</strong>
            {{ $customer->phone }}
        </p>

        <p>
            <strong>Perusahaan:</strong>
            {{ $customer->company ?? '-' }}
        </p>

        <p>
            <strong>Alamat:</strong><br>
            {{ $customer->address ?? '-' }}
        </p>

        <p>
            <strong>Dibuat pada:</strong>
            {{ $customer->created_at->format('d M Y') }}
        </p>
    </div>

    <!-- Action -->
    <div class="mt-6 flex gap-3">
        @if(auth()->user()->role !== 'sales')
            <a href="{{ route('customer.edit', $customer->id) }}"
               class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded transition">
                Edit
            </a>
        @endif

        <a href="{{ route('customer.index') }}"
           class="px-4 py-2 border rounded hover:bg-gray-50 transition">
            Kembali
        </a>
    </div>

</div>
@endsection