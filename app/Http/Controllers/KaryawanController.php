<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['admin', 'sales','teknisi'])->get();
        return view('karyawan.index', compact('users'));
    }

    public function create()
    {
        return view('karyawan.create');
    }
    public function show(User $user)
{
    return view('karyawan.show', compact('user'));
}
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users',
            'role'  => 'required|in:teknisi,sales',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('karyawan.index')
            ->with('success','Karyawan berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('karyawan.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->only('name','email','role'));

        return redirect()->route('karyawan.index')
            ->with('success','Data karyawan diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success','Karyawan dihapus');
    }
}