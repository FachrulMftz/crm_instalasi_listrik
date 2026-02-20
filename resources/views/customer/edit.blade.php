@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold text-cyan-600 mb-4">Edit Customer</h2>

    <form action="{{ route('customer.update',$customer) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <label class="block text-sm mb-1">Nama</label>
        <input name="name" value="{{ $customer->name }}"
            class="w-full border rounded p-2" required>

        <label class="block text-sm mb-1">Email</label>
        <input name="email" value="{{ $customer->email }}"
            class="w-full border rounded p-2">

        <label class="block text-sm mb-1">Nomor HP</label>
        <input name="phone" value="{{ $customer->phone }}"
            class="w-full border rounded p-2" required>

        <label class="block text-sm mb-1">Perusahaan</label>
        <input name="company" value="{{ $customer->company }}"
            class="w-full border rounded p-2">

        <label class="block text-sm mb-1">Alamat</label>
        <textarea name="address"
            class="w-full border rounded p-2">{{ $customer->address }}</textarea>

        <div class="flex gap-3 pt-4">
            <button type="submit"
                    class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Update
            </button>

            <a href="{{ route('customer.index') }}"
               class="flex-1 text-center border py-2 rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
