<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // ========== BESTAANDE FUNCTIES ==========

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

        // Zet default funnel_stage
        $data['funnel_stage'] = 'lead';

        $customer = Customer::create($data);

        // Log de creatie als activiteit
        if (Auth::check()) {
            CustomerActivity::create([
                'customer_id' => $customer->id,
                'activity_type' => 'note',
                'title' => 'Klant aangemaakt',
                'description' => 'Nieuwe klant toegevoegd aan het systeem',
                'created_by' => Auth::id()
            ]);
        }

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        // Laad alle relaties
        $customer->load([
            'assignedUser',
            'activities.creator',
            'machines',
            'orders',
//          'maintenance',
            'feedback',
            'documents'
        ]);

        $accountManagers = User::all();

        return view('customers.show', compact('customer', 'accountManagers'));
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

    // ========== NIEUWE SALES FUNNEL FUNCTIES ==========

    /**
     * Update het funnel stadium van een klant
     */
    public function updateStage(Request $request, Customer $customer)
    {
        $request->validate([
            'funnel_stage' => 'required|in:lead,prospect,quote_sent,customer,delivered'
        ]);

        $oldStage = $customer->funnel_stage;
        $customer->funnel_stage = $request->funnel_stage;
        $oldLabel = $customer->getFunnelStageLabel();

        $customer->update([
            'funnel_stage' => $request->funnel_stage,
            'last_contact_date' => now()
        ]);

        $newLabel = $customer->fresh()->getFunnelStageLabel();

        // Log stage change als activiteit
        if (Auth::check()) {
            CustomerActivity::create([
                'customer_id' => $customer->id,
                'activity_type' => 'stage_change',
                'title' => 'Stadium gewijzigd',
                'description' => "Van '{$oldLabel}' naar '{$newLabel}'",
                'created_by' => Auth::id()
            ]);
        }

        return redirect()->back()->with('success', 'Stadium bijgewerkt!');
    }

    /**
     * Voeg een nieuwe activiteit toe aan een klant
     */
    public function addActivity(Request $request, Customer $customer)
    {
        $request->validate([
            'activity_type' => 'required|in:call,email,meeting,quote,order,note',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        CustomerActivity::create([
            'customer_id' => $customer->id,
            'activity_type' => $request->activity_type,
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => Auth::id()
        ]);

        // Update laatste contact datum
        $customer->update([
            'last_contact_date' => now()
        ]);

        return redirect()->back()->with('success', 'Activiteit toegevoegd!');
    }

    /**
     * Wijs een accountmanager toe aan een klant
     */
    public function updateAssignment(Request $request, Customer $customer)
    {
        $request->validate([
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        $oldAssigned = $customer->assigned_to;
        $newAssigned = $request->assigned_to;

        $customer->update([
            'assigned_to' => $newAssigned
        ]);

        // Log assignment change
        if (Auth::check() && $oldAssigned != $newAssigned) {
            $oldUser = $oldAssigned ? User::find($oldAssigned)?->name : 'Niemand';
            $newUser = $newAssigned ? User::find($newAssigned)?->name : 'Niemand';

            CustomerActivity::create([
                'customer_id' => $customer->id,
                'activity_type' => 'note',
                'title' => 'Accountmanager gewijzigd',
                'description' => "Van '{$oldUser}' naar '{$newUser}'",
                'created_by' => Auth::id()
            ]);
        }

        return redirect()->back()->with('success', 'Accountmanager bijgewerkt!');
    }
}
