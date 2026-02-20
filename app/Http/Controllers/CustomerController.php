<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers
     */
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')->paginate(10);
        
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created customer
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
        ]);


        Customer::create($request->only([
            'name', 'email', 'phone', 'address', 'company'
        ]));
        return redirect()->route('customer.index')
            ->with('success', 'Customer berhasil ditambahkan!');
    }

    /**
     * Display the specified customer
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        $this->authorize('view', $customer); 
        return view('customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified customer
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
        ]);

        $customer->update($request->all());

        return redirect()->route('customer.index')
            ->with('success', 'Customer berhasil diupdate!');
    }

    /**
     * Remove the specified customer
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $this->authorize('delete', $customer); 
        $customer->delete();

        return redirect()->route('customer.index')
            ->with('success', 'Customer berhasil dihapus!');
    }
}