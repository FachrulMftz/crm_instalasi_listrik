@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 shadow rounded">
    <h1 class="text-2xl font-bold text-blue-600 mb-4">
        Tambah Opportunity
    </h1>

    <form action="{{ route('opportunities.store') }}" method="POST" class="space-y-4">
        @csrf

        <select name="customer_id" class="w-full border rounded p-2" required>
            <option value="">Pilih Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">
                    {{ $customer->name }}
                </option>
            @endforeach
        </select>

        <label class="block text-sm mb-1">Opportunity</label>
        <input type="text" name="title"
            placeholder="Judul Opportunity"
            class="w-full border rounded p-2" required>

        <label class="block text-sm mb-1">Deskripsi</label>
        <textarea name="description"
            placeholder="Deskripsi"
            class="w-full border rounded p-2"></textarea>

        <label class="block text-sm mb-1">Nilai Proyek</label>
        <input type="number" name="value"
            placeholder="Nilai Opportunity"
            class="w-full border rounded p-2">

        <label class="block text-sm mb-1">Status Proyek</label>
        <select name="status" class="w-full border rounded p-2" required>
            <option value="">Pilih Status</option>
            <option value="lead">Lead</option>
            <option value="qualified">Qualified</option>
            <option value="proposal">Proposal</option>
            <option value="negotiation">Negotiation</option>
            <option value="won">Won</option>
            <option value="lost">Lost</option>
        </select>

        <label class="block text-sm mb-1">Deadline</label>
        <input type="date" name="expected_close_date"
            class="w-full border rounded p-2">

        <div class="flex gap-3 pt-4">
            <button type="submit"
                    class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Simpan
            </button>

            <a href="{{ route('opportunities.index') }}"
               class="flex-1 text-center border py-2 rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
</div>
@endsection
