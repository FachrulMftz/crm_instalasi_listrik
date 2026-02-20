<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Installation;


class TeknisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $installations = Installation::where('technician_id', auth()->id())
            ->with(['activity', 'opportunity.customer'])
            ->orderBy('scheduled_start', 'desc')
            ->paginate(10);

        return view('teknisi.report', compact('installations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teknisi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi dan simpan data
        // Contoh:
        // $validated = $request->validate([...]);
        // Teknisi::create($validated);
        
        return redirect()->route('teknisi.index')
                         ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}