<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\IssueAction;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index(Request $request)
    {
        $query = Issue::with(['machine.customer']);

        // search by text (machine type, serial, customer name, description)
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

        // filter status
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // filter priority
        if ($request->priority && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // filter customer
        if ($request->customer && $request->customer !== 'all') {
            $query->whereHas('machine.customer', function ($q) use ($request) {
                $q->where('id', $request->customer);
            });
        }

        $issues = $query->orderBy('reported_at', 'desc')->paginate(10);

        // for filter dropdowns
        $customers = \App\Models\Customer::orderBy('name')->get();

        return view('issues.index', compact('issues', 'customers'));
    }


    public function show($id)
    {
        $issue = Issue::with([
            'machine.customer',
            'actions.technician'
        ])->findOrFail($id);

        // previous issues for same machine
        $history = Issue::where('machine_id', $issue->machine_id)
            ->where('id', '!=', $id)
            ->orderBy('reported_at', 'desc')
            ->get();

        return view('issues.show', compact('issue', 'history'));
    }

    public function addAction(Request $request, $id)
    {
        $request->validate([
            'technician_id' => 'required|integer',
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
}
