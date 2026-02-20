<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\Models\Customer;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
 public function index()
    {
        $opportunities = Opportunity::orderBy('created_at', 'desc')->paginate(10);
        
        return view('opportunities.index', compact('opportunities'));
    }

    public function show(Opportunity $opportunity)
{
    $this->authorize('view', $opportunity); // ✅ PERTAMA
    return view('opportunities.show', compact('opportunity'));
}

public function edit(Opportunity $opportunity)
{
    $this->authorize('update', $opportunity); // ✅ PERTAMA
    $customers = Customer::all();
    return view('opportunities.edit', compact('opportunity', 'customers'));
}

public function update(Request $request, Opportunity $opportunity)
{
    $this->authorize('update', $opportunity); // ✅ PERTAMA

    $validated = $request->validate([
        'customer_id'         => 'required|exists:customers,id',
        'title'               => 'required|string|max:255',
        'description'         => 'nullable|string',
        'value'               => 'nullable|numeric',
        'status'              => 'required|string',
        'expected_close_date' => 'nullable|date',
    ]);

    $opportunity->update($validated); // ✅ hanya field tervalidasi
    return redirect()->route('opportunities.index')
        ->with('success', 'Opportunity berhasil diperbarui');
}

public function destroy(Opportunity $opportunity)
{
    $this->authorize('delete', $opportunity); // ✅ PERTAMA
    $opportunity->delete();
    return redirect()->route('opportunities.index')
        ->with('success', 'Opportunity berhasil dihapus');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'customer_id'         => 'required|exists:customers,id',
        'title'               => 'required|string|max:255',
        'description'         => 'nullable|string',
        'value'               => 'nullable|numeric',
        'status'              => 'required|string',
        'expected_close_date' => 'nullable|date',
    ]);

    $validated['user_id'] = auth()->id(); // ✅ otomatis isi owner
    Opportunity::create($validated); // ✅ bukan request->all()

    return redirect()->route('opportunities.index')
        ->with('success', 'Opportunity berhasil ditambahkan');
}
}