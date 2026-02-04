<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\IssueAction;
use Illuminate\Http\Request;
use App\Models\Technician;
use App\Models\Machine;

class IssueController extends Controller
{
    public function index(Request $request)
    {
        $query = Issue::with(['machine.customer']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', "%{$request->search}%")
                    ->orWhereHas('machine', function ($q2) use ($request) {
                        $q2->where('type', 'like', "%{$request->search}%")
                            ->orWhere('serial_number', 'like', "%{$request->search}%");
                    })
                    ->orWhereHas('machine.customer', function ($q3) use ($request) {
                        $q3->where('name', 'like', "%{$request->search}%");
                    });
            });
        }

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->priority && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        if ($request->customer && $request->customer !== 'all') {
            $query->whereHas('machine.customer', function ($q) use ($request) {
                $q->where('id', $request->customer);
            });
        }

        // STORING DASHBOARD DATA
        $stats = [
            'last_7_days' => Issue::where('created_at', '>=', now()->subDays(7))->count(),
            'last_30_days' => Issue::where('created_at', '>=', now()->subDays(30))->count(),
            'open' => Issue::where('status', 'open')->count(),
        ];

        // FIX SORTERING
        $issues = $query
            ->orderByRaw('COALESCE(reported_at, created_at) DESC')
            ->paginate(10);

        $customers = \App\Models\Customer::orderBy('name')->get();

        return view('issues.index', compact('issues', 'customers', 'stats'));
    }



    public function show(Issue $issue)
    {
        $issue->load([
            'machine.customer',
            'actions.technician'
        ]);

        $history = Issue::where('machine_id', $issue->machine_id)
            ->where('id', '!=', $issue->id)
            ->orderByRaw('COALESCE(reported_at, created_at) DESC')
            ->get();

        $frequency = Issue::where('machine_id', $issue->machine_id)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $chartData = Issue::where('machine_id', $issue->machine_id)
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $technicians = Technician::orderBy('name')->get();

        return view('issues.show', compact(
            'issue',
            'history',
            'frequency',
            'chartData',
            'technicians'
        ));
    }



    public function addAction(Request $request, $id)
    {
        $request->validate([
            'technician_id' => 'required|exists:technicians,id',
            'action_description' => 'required|string',
            'result' => 'nullable|string',
            'is_solution' => 'nullable|boolean'
        ]);

        IssueAction::create([
            'issue_id' => $id,
            'technician_id' => $request->technician_id,
            'action_date' => now(),
            'action_description' => $request->action_description,
            'result' => $request->result,
            'is_solution' => $request->is_solution ? 1 : 0
        ]);

        return redirect()->back()->with('success', 'Action added successfully.');
    }

    public function create()
    {
        $machines = Machine::with('customer')->orderBy('type')->get();

        return view('issues.create', compact('machines'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'priority' => 'required|in:low,medium,high,normal',
            'description' => 'required|string',
        ]);

        $data['status'] = 'open';
        $data['reported_at'] = now();

        Issue::create($data);

        return redirect()->route('issues.index')
            ->with('success', 'Issue created successfully.');
    }

    public function edit(Issue $issue)
    {
        $machines = Machine::with('customer')->orderBy('type')->get();

        return view('issues.edit', compact('issue', 'machines'));
    }

    public function update(Request $request, Issue $issue)
    {
        $data = $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'priority' => 'required|in:low,medium,high,normal',
            'status' => 'required|in:open,in progress,resolved',
            'description' => 'required|string',
        ]);

        $issue->update($data);

        return redirect()->route('issues.show', $issue)
            ->with('success', 'Issue updated.');
    }

    public function destroy(Issue $issue)
    {
        $issue->delete();

        return redirect()->route('issues.index')
            ->with('success', 'Issue deleted.');
    }

}
