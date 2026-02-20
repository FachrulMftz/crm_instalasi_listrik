@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 shadow rounded-lg">

    <h1 class="text-2xl font-bold text-blue-600 mb-6">
        Edit Opportunity
    </h1>

    <form action="{{ route('opportunities.update', ['opportunity' => $opportunity->id]) }}"
          method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <label class="block text-sm mb-1">Customer</label>
        <select name="customer_id"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
                required>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}"
                    {{ $customer->id == $opportunity->customer_id ? 'selected' : '' }}>
                    {{ $customer->name }}
                </option>
            @endforeach
        </select>

        <label class="block text-sm mb-1">Opportunity</label>
        <input type="text"
               name="title"
               value="{{ $opportunity->title }}"
               class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
               placeholder="Judul Opportunity"
               required>

        <label class="block text-sm mb-1">Deskripsi</label>
        <textarea name="description"
                  rows="3"
                  class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
                  placeholder="Deskripsi">{{ $opportunity->description }}</textarea>

        <label class="block text-sm mb-1">Nilai Proyek</label>
        <input type="number"
               step="0.01"
               name="value"
               value="{{ $opportunity->value }}"
               class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
               placeholder="Nilai Opportunity">

        <label class="block text-sm mb-1">Status Proyek</label>
        <select name="status"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200"
                required>
            @foreach(['lead','qualified','proposal','negotiation','won','lost'] as $status)
                <option value="{{ $status }}"
                    {{ $opportunity->status == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>

        <label class="block text-sm mb-1">Deadline</label>
        <input type="date"
               name="expected_close_date"
               value="{{ optional($opportunity->expected_close_date)->format('Y-m-d') }}"
               class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200">

        <div class="flex gap-3 pt-4">
            <button type="submit"
                    class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Update
            </button>

            <a href="{{ route('opportunities.index') }}"
               class="flex-1 text-center border py-2 rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
