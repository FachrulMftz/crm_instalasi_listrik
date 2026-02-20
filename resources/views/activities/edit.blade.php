@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4">

        <div class="bg-white rounded-xl shadow border p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Edit Aktivitas
            </h2>

            {{-- FORM UPDATE (WAJIB POST + PUT) --}}
            <form
                action="{{ route('activity.update', $activity->id) }}"
                method="POST"
                class="space-y-6"
            >
                @csrf
                @method('PUT')

                {{-- Opportunity --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Opportunity
                    </label>
                    <select name="opportunity_id" class="mt-1 w-full rounded-lg border-gray-300">
                        <option value="">-- Opsional --</option>
                        @foreach ($opportunities as $opportunity)
                            <option
                                value="{{ $opportunity->id }}"
                                {{ $activity->opportunity_id == $opportunity->id ? 'selected' : '' }}
                            >
                                {{ $opportunity->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Customer --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Customer
                    </label>
                    <select name="customer_id" class="mt-1 w-full rounded-lg border-gray-300">
                        <option value="">-- Opsional --</option>
                        @foreach ($customers as $customer)
                            <option
                                value="{{ $customer->id }}"
                                {{ $activity->customer_id == $customer->id ? 'selected' : '' }}
                            >
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
<div>
    <label class="block text-sm font-medium text-gray-700">
                        Alokasi Teknisi
                    </label>                
<select name="technician_id" id="technician"
    class="w-full rounded-lg border-gray-300">
    <option value="">-- Pilih Teknisi --</option>

    @foreach($technicians as $tech)
        <option value="{{ $tech->id }}"
            {{ optional($activity->installation)->technician_id == $tech->id ? 'selected' : '' }}
            {{ $tech->active_installations_count >= 1 &&
               optional($activity->installation)->technician_id != $tech->id ? 'disabled' : '' }}>
            {{ $tech->name }}
            @if($tech->active_installations_count >= 1 &&
                optional($activity->installation)->technician_id != $tech->id)
                (Sedang Bertugas)
            @endif
        </option>
    @endforeach
</select>
</div>

                {{-- Type --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Jenis Aktivitas
                    </label>
                    <select name="type" class="mt-1 w-full rounded-lg border-gray-300">
                        @foreach (['call','meeting','email','visit','follow_up','other'] as $type)
                            <option
                                value="{{ $type }}"
                                {{ $activity->type === $type ? 'selected' : '' }}
                            >
                                {{ ucfirst(str_replace('_',' ', $type)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Subject --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Judul
                    </label>
                    <input
                        type="text"
                        name="subject"
                        value="{{ old('subject', $activity->subject) }}"
                        class="mt-1 w-full rounded-lg border-gray-300"
                        required
                    >
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Deskripsi
                    </label>
                    <textarea
                        name="description"
                        rows="3"
                        class="mt-1 w-full rounded-lg border-gray-300"
                    >{{ old('description', $activity->description) }}</textarea>
                </div>

                {{-- Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Tanggal Aktivitas
                    </label>
                    <input
                        type="datetime-local"
                        name="activity_date"
                        value="{{ old('activity_date', $activity->activity_date->format('Y-m-d\TH:i')) }}"
                        class="mt-1 w-full rounded-lg border-gray-300"
                        required
                    >
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Status
                    </label>
                    <select name="status" class="mt-1 w-full rounded-lg border-gray-300">
                        @foreach (['planned','completed','cancelled'] as $status)
                            <option
                                value="{{ $status }}"
                                {{ $activity->status === $status ? 'selected' : '' }}
                            >
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end space-x-3">
                    <a
                        href="{{ route('activity.index') }}"
                        class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-100"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        Update
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection
