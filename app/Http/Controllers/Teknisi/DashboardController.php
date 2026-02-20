<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Installation;
use App\Models\Customer;
use App\Models\Opportunity;
use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $teknisiId = auth()->id();
        
        // Statistik
        $stats = [
            'today' => Installation::where('technician_id', $teknisiId)
                ->whereDate('scheduled_start', Carbon::today())
                ->count(),
                
            'in_progress' => Installation::where('technician_id', $teknisiId)
                ->where('status', 'in_progress')
                ->count(),
                
            'completed' => Installation::where('technician_id', $teknisiId)
                ->where('status', 'completed')
                ->count(),
                
            'pending' => Installation::where('technician_id', $teknisiId)
                ->where('status', 'pending')
                ->count(),
        ];
        
        // Daftar instalasi terbaru (limit 10)
        $installations = Installation::where('technician_id', $teknisiId)
            ->with(['opportunity.customer'])
            ->orderBy('scheduled_start', 'desc')
            ->limit(10)
            ->get();
        
        // Instalasi hari ini
        $todayInstallations = Installation::where('technician_id', $teknisiId)
            ->whereDate('scheduled_start', Carbon::today())
            ->with(['opportunity.customer'])
            ->get();
        
        // Instalasi mendesak (deadline < 3 hari dan belum selesai)
        $urgentInstallations = Installation::where('technician_id', $teknisiId)
            ->whereIn('status', ['pending', 'in_progress'])
            ->where('scheduled_start', '<=', Carbon::now()->addDays(3))
            ->count();
        
        return view('dashboard.teknisi', compact(
            'stats',
            'installations',
            'todayInstallations',
            'urgentInstallations'
        ));
    }
}