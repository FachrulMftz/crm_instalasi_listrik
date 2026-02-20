<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /* ===============================
     * INDEX
     * =============================== */
    public function index()
    {
        $auth = auth()->user();

        if ($auth->role === 'admin') {
            // Admin hanya lihat sales & teknisi
            $users = User::whereIn('role', ['sales', 'teknisi'])->get();
        } else {
            // Superadmin lihat semua
            $users = User::all();
        }

        return view('admin.users.index', compact('users'));
    }

    /* ===============================
     * CREATE
     * =============================== */
    public function create()
    {
        return view('admin.users.create');
    }

    /* ===============================
     * STORE
     * =============================== */
    public function store(Request $request)
    {
        $auth = auth()->user();

        $allowedRoles = $auth->role === 'superadmin'
            ? ['superadmin','admin','sales','teknisi']
            : ['sales','teknisi'];

        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required|in:' . implode(',', $allowedRoles),
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    /* ===============================
     * EDIT
     * =============================== */
    public function edit(User $user)
    {
        $auth = auth()->user();

        // Tidak boleh edit diri sendiri
        if ($auth->id === $user->id) {
            abort(403);
        }

        // Admin hanya boleh edit sales & teknisi
        if (
            $auth->role === 'admin' &&
            !in_array($user->role, ['sales','teknisi'])
        ) {
            abort(403);
        }

        return view('admin.users.edit', compact('user'));
    }

    /* ===============================
     * UPDATE
     * =============================== */
    public function update(Request $request, User $user)
    {
        $auth = auth()->user();

        if ($auth->id === $user->id) {
            abort(403);
        }

        if (
            $auth->role === 'admin' &&
            !in_array($user->role, ['sales','teknisi'])
        ) {
            abort(403);
        }

        $allowedRoles = $auth->role === 'superadmin'
            ? ['superadmin','admin','sales','teknisi']
            : ['sales','teknisi'];

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:' . implode(',', $allowedRoles),
        ]);

        $data = $request->only('name','email','role');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    /* ===============================
     * DESTROY
     * =============================== */
    public function destroy(User $user)
    {
        $auth = auth()->user();

        // Tidak boleh hapus diri sendiri
        if ($auth->id === $user->id) {
            abort(403);
        }

        // Admin hanya boleh hapus sales & teknisi
        if (
            $auth->role === 'admin' &&
            !in_array($user->role, ['sales','teknisi'])
        ) {
            abort(403);
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}
