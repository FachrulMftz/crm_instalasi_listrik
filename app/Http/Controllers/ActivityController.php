<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use App\Models\Installation;
use App\Models\Opportunity;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    /* =======================
     * INDEX
     * ======================= */
    public function index()
    {
        // ✅ Isolasi data: admin lihat semua, user lain hanya miliknya
        $activities = auth()->user()->role === 'admin'
            ? Activity::with(['customer', 'opportunity', 'installation.technician'])
                ->latest()->paginate(10)
            : Activity::with(['customer', 'opportunity', 'installation.technician'])
                ->where('user_id', auth()->id())
                ->latest()->paginate(10);

        $stats = [
            'planned'   => Activity::where('status', 'planned')->count(),
            'completed' => Activity::where('status', 'completed')->count(),
            'cancelled' => Activity::where('status', 'cancelled')->count(),
        ];

        return view('activities.index', compact('activities', 'stats'));
    }

    public function getInstallationsByTechnician($technicianId)
    {
        return Installation::where('technician_id', $technicianId)
            ->whereIn('status', ['pending', 'in_progress', 'scheduled'])
            ->get(['id']);
    }

    /* =======================
     * CREATE
     * ======================= */
    public function create()
    {
        $technicians = User::whereRaw('LOWER(role) = ?', ['teknisi'])
            ->withCount([
                'installations as active_installations_count' => function ($q) {
                    $q->whereIn('status', ['pending', 'in_progress']);
                }
            ])
            ->orderBy('name')
            ->get();

        return view('activities.create', [
            'technicians'   => $technicians,
            'opportunities' => Opportunity::with('customer')->get(),
            'customers'     => Customer::all(),
        ]);
    }

    /* =======================
     * STORE
     * ======================= */
    public function store(Request $request)
    {
        $request->validate([
            'technician_id'  => 'nullable|exists:users,id',
            'opportunity_id' => 'nullable|exists:opportunities,id',
            'customer_id'    => 'nullable|exists:customers,id',
            'type'           => 'required|in:call,meeting,email,visit,follow_up,other',
            'subject'        => 'required|string|max:255',
            'description'    => 'nullable|string',
            'activity_date'  => 'required|date',
            'status'         => 'required|in:planned,completed,cancelled',
        ]);

        $installationId = null;

        if ($request->type === 'follow_up' && $request->technician_id) {
            $installation = Installation::where('technician_id', $request->technician_id)
                ->whereIn('status', ['pending', 'in_progress'])
                ->first();

            if (!$installation) {
                $installation = Installation::create([
                    'technician_id'   => $request->technician_id,
                    'opportunity_id'  => $request->opportunity_id,
                    'scheduled_start' => now(),
                    'status'          => 'scheduled',
                    'progress'        => 0,
                ]);
            }

            $installationId = $installation->id;
        }

        Activity::create([
            'user_id'         => auth()->id(), // ✅ otomatis dari session
            'opportunity_id'  => $request->opportunity_id,
            'customer_id'     => $request->customer_id,
            'installation_id' => $installationId,
            'type'            => $request->type,
            'subject'         => $request->subject,
            'description'     => $request->description,
            'activity_date'   => $request->activity_date,
            'status'          => $request->status,
        ]);

        return redirect()->route('activity.index')
            ->with('success', 'Aktivitas berhasil disimpan');
    }

    /* =======================
     * EDIT
     * ======================= */
    public function edit($id)
    {
        $activity = Activity::with('installation')->findOrFail($id);
        $this->authorize('update', $activity); // ✅ PERTAMA

        $technicians = User::where('role', 'teknisi')
            ->withCount([
                'installations as active_installations_count' => function ($q) use ($activity) {
                    if ($activity->installation_id) {
                        $q->where('id', '!=', $activity->installation_id);
                    }
                    $q->whereIn('status', ['scheduled', 'in_progress']);
                }
            ])
            ->orderBy('name')
            ->get();

        return view('activities.edit', [
            'activity'      => $activity,
            'opportunities' => Opportunity::with('customer')->get(),
            'customers'     => Customer::all(),
            'technicians'   => $technicians,
        ]);
    }

    /* =======================
     * UPDATE
     * ======================= */
    public function update(Request $request, $id)
    {
        $activity = Activity::with('installation')->findOrFail($id);
        $this->authorize('update', $activity); // ✅ PERTAMA
        $data = $this->validateRequest($request);

        DB::transaction(function () use ($activity, $request, $data) {

            // ==============================
            // PASTIKAN ADA INSTALLATION
            // ==============================
            if ($request->filled('technician_id') && !$activity->installation) {
                $installation = Installation::create([
                    'technician_id'   => $request->technician_id,
                    'opportunity_id'  => $data['opportunity_id'] ?? null,
                    'scheduled_start' => now(),
                    'status'          => 'scheduled',
                    'progress'        => 0,
                ]);

                $activity->installation()->associate($installation);
                $activity->save();
            }

            $installation = $activity->fresh()->installation;

            // ==============================
            // UPDATE ACTIVITY
            // ==============================
            $activity->update([
                'opportunity_id' => $data['opportunity_id'] ?? null,
                'customer_id'    => $data['customer_id'] ?? null,
                'type'           => $data['type'],
                'subject'        => $data['subject'],
                'description'    => $data['description'] ?? null,
                'activity_date'  => $data['activity_date'],
                'status'         => $data['status'],
            ]);

            // ==============================
            // UPDATE INSTALLATION
            // ==============================
            if ($installation) {
                $installation->update([
                    'progress'  => $request->progress ?? $installation->progress,
                    'status'    => $request->status,
                    'checklist' => $request->checklist ?? $installation->checklist,
                ]);

                $installation->activities()->update([
                    'status' => match ($request->status) {
                        'completed' => 'completed',
                        'cancelled' => 'cancelled',
                        default     => 'planned',
                    }
                ]);
            }

            // ==============================
            // SINKRON TEKNISI
            // ==============================
            if ($installation && $request->filled('technician_id')) {
                $installation->update([
                    'technician_id' => $request->technician_id
                ]);
            }
        });

        return redirect()->route('activity.index')
            ->with('success', 'Aktivitas berhasil diperbarui');
    }

    /* =======================
     * DESTROY
     * ======================= */
    public function destroy(Activity $activity)
    {
        $this->authorize('delete', $activity); // ✅ PERTAMA

        if ($activity->installation) {
            $activity->installation->delete();
        }

        $activity->delete();

        return back()->with('success', 'Activity & Installation berhasil dihapus');
    }

    /* =======================
     * SHOW
     * ======================= */
    public function show(Activity $activity)
    {
        $this->authorize('view', $activity); // ✅ PERTAMA
        return redirect()->route('activity.edit', $activity->id);
    }

    /* =====================================================
     * PRIVATE METHODS
     * ===================================================== */
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'installation_id'       => 'nullable|exists:installations,id',
            'technician_id'         => 'nullable|exists:users,id',
            'installation_progress' => 'nullable|integer|min:0|max:100',
            'opportunity_id'        => 'nullable|exists:opportunities,id',
            'customer_id'           => 'nullable|exists:customers,id',
            'type'                  => 'required|in:call,meeting,email,visit,follow_up,other',
            'subject'               => 'required|string|max:255',
            'description'           => 'nullable|string',
            'activity_date'         => 'required|date',
            'status'                => 'required|in:planned,completed,cancelled',
        ]);
    }

    private function syncTechnicianToInstallation(Request $request)
    {
        if (!$request->filled('installation_id') || !$request->filled('technician_id')) {
            return;
        }

        Installation::where('id', $request->installation_id)
            ->update(['technician_id' => $request->technician_id]);
    }

    private function updateInstallationProgress(Request $request)
    {
        if (!$request->filled('installation_id') || !$request->filled('installation_progress')) {
            return;
        }

        $installation = Installation::findOrFail($request->installation_id);
        $user = auth()->user();

        // ✅ Cek izin sebelum update
        if (!($user->role === 'sales' || $installation->technician_id === $user->id)) {
            abort(403, 'Anda tidak berhak mengubah progress instalasi ini');
        }

        $progress = (int) $request->installation_progress;

        $installation->update(match(true) {
            $request->status === 'completed' || $progress >= 100 => ['progress' => 100, 'status' => 'completed'],
            $request->status === 'cancelled'                      => ['progress' => $progress, 'status' => 'cancelled'],
            default                                               => ['progress' => $progress, 'status' => 'in_progress'],
        });
    }
}