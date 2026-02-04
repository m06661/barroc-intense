<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Issue;
class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'address'         => 'required|string',
            'contact_person'  => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => 'nullable|string|max:50',
            'iban'            => 'nullable|string|max:50',
            'contract_type'   => 'required|string',
            'status'          => 'required|string',
        ]);

        Customer::create($data);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'address'         => 'required|string',
            'contact_person'  => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => 'nullable|string|max:50',
            'iban'            => 'nullable|string|max:50',
            'contract_type'   => 'required|string',
            'status'          => 'required|string',
        ]);

        $customer->update($data);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    public function issues(Customer $customer)
    {
        $issues = Issue::with('machine')
            ->whereHas('machine', function ($q) use ($customer) {
                $q->where('customer_id', $customer->id);
            })
            ->orderByRaw('COALESCE(reported_at, created_at) DESC')
            ->get();

        $stats = [
            'total' => $issues->count(),
            'last_30_days' => $issues->where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return view('customers.issues', compact('customer', 'issues', 'stats'));
    }
}
