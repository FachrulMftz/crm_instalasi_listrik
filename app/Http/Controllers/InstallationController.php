<?php

namespace App\Http\Controllers;

use App\Models\Installation;
use Illuminate\Http\Request;

class InstallationController extends Controller
{
    public function myInstallations(Request $request)
    {
        $user = auth()->user();

        $query = Installation::with(['opportunity.customer'])
            ->orderBy('scheduled_start', 'desc');

        if ($user->role === 'teknisi') {
            $query->where('technician_id', $user->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $installations = $query->paginate(10);

        return view('installations.my', compact('installations'));
    }

    public function show($id)
    {
        $installation = Installation::with(['opportunity.customer', 'technician'])
            ->findOrFail($id);

        $this->authorize('view', $installation); // ✅ PERTAMA, ganti cek manual

        return view('installations.show', compact('installation'));
    }

    public function reportIndex()
    {
        $installations = Installation::where('technician_id', auth()->id())
            ->with(['opportunity.customer'])
            ->orderBy('scheduled_start', 'desc')
            ->paginate(10);

        return view('teknisi.report', compact('installations'));
    }

    public function index(Request $request)
    {
        $query = Installation::with(['opportunity.customer']);

        // ✅ Filter status lebih konsisten dengan whitelist
        $allowedStatus = ['pending', 'scheduled', 'in_progress', 'completed', 'cancelled'];

        if ($request->filled('status') && in_array($request->status, $allowedStatus)) {
            $query->where('status', $request->status);
        }

        $installations = $query->paginate(10);

        return view('installations.index', compact('installations'));
    }
}