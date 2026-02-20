<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Installation;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Tampilkan form create laporan
     */
    public function create(Installation $installation)
    {
        // Pastikan teknisi hanya bisa akses instalasi mereka sendiri
        if ($installation->technician_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('teknisi.create', compact('installation'));
    }

    /**
     * Simpan laporan
     */
    public function store(Request $request, Installation $installation)
{
    if ($installation->technician_id !== auth()->id()) {
        abort(403);
    }

    /**
     * =========================
     * MODE 1: UPLOAD FOTO SAJA
     * =========================
     */
    if ($request->hasFile('photos')) {
        $request->validate([
            'photos.*' => 'image|max:5120',
        ]);

        $existingPhotos = $installation->photos ?? [];

        foreach ($request->file('photos') as $photo) {
            $path = $photo->store('installation-photos', 'public');
            $existingPhotos[] = $path;
        }

        $installation->update([
            'photos' => $existingPhotos,
        ]);

        return back();
    }

    /**
     * =========================
     * MODE 2: SIMPAN PROGRESS
     * =========================
     */
    $validated = $request->validate([
        'progress' => 'required|integer|min:0|max:100',
        'status' => 'required|in:pending,in_progress,completed,cancelled',
        'notes' => 'nullable|string',
        'materials_used' => 'nullable|string',
        'checklist' => 'nullable|array',
    ]);

    $installation->update($validated);

    return redirect()
        ->route('teknisi.report')
        ->with('success', 'Progres pekerjaan berhasil diperbarui');
}


public function deletePhoto(Request $request, Installation $installation)
{
    $request->validate([
        'photo' => 'required|string',
    ]);

    if ($installation->technician_id !== auth()->id()) {
        abort(403);
    }

    $photo = $request->photo;
    $photos = $installation->photos ?? [];

    $photos = array_values(array_filter($photos, fn ($p) => $p !== $photo));

    Storage::disk('public')->delete($photo);

    $installation->update([
        'photos' => $photos,
    ]);

    return back()->with('success', 'Foto berhasil dihapus');
}

}