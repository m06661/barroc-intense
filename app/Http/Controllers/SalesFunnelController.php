<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesFunnelController extends Controller
{
    public function index(Request $request)
    {
        // Filters
        $stage = $request->get('stage', 'all');
        $assignedTo = $request->get('assigned_to', 'all');

        // Query
        $query = Customer::with(['assignedUser', 'activities']);

        if ($stage !== 'all') {
            $query->where('funnel_stage', $stage);
        }

        if ($assignedTo !== 'all') {
            $query->where('assigned_to', $assignedTo);
        }

        $customers = $query->get();

        // Statistieken per stage
        $stats = Customer::select('funnel_stage', DB::raw('count(*) as count'))
            ->groupBy('funnel_stage')
            ->pluck('count', 'funnel_stage')
            ->toArray();

        $funnelStats = [
            'lead' => $stats['lead'] ?? 0,
            'prospect' => $stats['prospect'] ?? 0,
            'quote_sent' => $stats['quote_sent'] ?? 0,
            'customer' => $stats['customer'] ?? 0,
            'delivered' => $stats['delivered'] ?? 0,
        ];

        // Conversie percentage
        $totalLeads = array_sum($funnelStats);
        $totalDelivered = $funnelStats['delivered'];
        $conversionRate = $totalLeads > 0 ? round(($totalDelivered / $totalLeads) * 100, 1) : 0;

        // Accountmanagers
        $accountManagers = User::all();

        return view('sales-funnel.index', compact(
            'customers',
            'funnelStats',
            'conversionRate',
            'accountManagers',
            'stage',
            'assignedTo'
        ));
    }
}
