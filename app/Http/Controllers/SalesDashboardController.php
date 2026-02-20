<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Opportunity;
use App\Models\Activity;

class SalesDashboardController extends Controller
{
    public function index()
    {
        $totalCustomer    = Customer::count();
        $totalOpportunity = Opportunity::count();
        $todayActivity    = Activity::whereDate('activity_date', today())->count();

        return view('dashboard.sales', compact(
            'totalCustomer',
            'totalOpportunity',
            'todayActivity'
        ));
    }
}