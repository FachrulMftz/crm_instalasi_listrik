@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Laporan Instalasi Listrik</h1>

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">ID</th>
                <th>Opportunity</th>
                <th>Teknisi</th>
                <th>Status</th>
                <th>Progress</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($installations as $installation)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-3">{{ $installation->id }}</td>
                <td>#{{ $installation->opportunity_id }}</td>
                <td>{{ $installation->technician?->name ?? '-' }}</td>
                <td>
                    <span class="px-2 py-1 rounded text-xs
                        {{ $installation->status === 'completed' ? 'bg-green-100 text-green-700' :
                           ($installation->status === 'in_progress' ? 'bg-blue-100 text-blue-700' :
                           'bg-yellow-100 text-yellow-700') }}">
                        {{ ucfirst(str_replace('_',' ',$installation->status)) }}
                    </span>
                </td>
                <td>{{ $installation->progress }}%</td>
                <td class="space-x-2">
                    <a href="{{ route('installations.show',$installation) }}" class="text-blue-600">Detail</a>
                    <a href="{{ route('installations.edit',$installation) }}" class="text-yellow-600">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
