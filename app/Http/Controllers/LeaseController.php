<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Lease;
use Illuminate\Http\Request;

class LeaseController extends Controller
{
    public function index()
    {
        $leases = Lease::with('customer')->get();
        return view('leases.index', compact('leases'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('leases.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'customer_id'  => 'required|exists:customers,id',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'bkr_check'    => 'boolean',
        ]);

        $data['bkr_check'] = $request->bkr_check ?? 0;

        Lease::create($data);

        return redirect()->route('leases.index')
            ->with('success', 'Lease aangemaakt.');
    }

    public function edit($id)
    {
        $lease = Lease::findOrFail($id);
        $customers = Customer::all();

        return view('leases.edit', compact('lease', 'customers'));
    }

    public function update(Request $request, Lease $lease)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'customer_id'  => 'required|exists:customers,id',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'bkr_check'    => 'boolean',
        ]);

        $data['bkr_check'] = $request->bkr_check ?? 0;

        $lease->update($data);

        return redirect()->route('leases.index')
            ->with('success', 'Lease bijgewerkt.');
    }

    public function destroy(Lease $lease)
    {
        $lease->delete();

        return redirect()->route('leases.index')
            ->with('success', 'Lease verwijderd.');
    }
}
