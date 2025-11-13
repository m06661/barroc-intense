<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerDocumentController extends Controller
{
    public function index(Customer $customer)
    {
        // Haal documenten op uit storage
        $files = Storage::disk('public')->files("customers/{$customer->id}");

        // Ontbrekende velden waarschuwingen
        $missing = [];
        foreach (['address', 'contact_person', 'email', 'phone', 'iban'] as $field) {
            if (empty($customer->$field)) {
                $missing[] = $field;
            }
        }

        return view('customers.documents.index', compact('customer', 'files', 'missing'));
    }

    public function store(Request $request, Customer $customer)
    {
        $request->validate([
            'document' => 'required|file|max:20480', // 20MB
        ]);

        $file = $request->file('document');
        $name = time() . '_' . $file->getClientOriginalName();

        Storage::disk('public')->putFileAs("customers/{$customer->id}", $file, $name);

        return back()->with('success', 'Document geupload!');
    }

    public function destroy(Customer $customer, $filename)
    {
        Storage::disk('public')->delete("customers/{$customer->id}/{$filename}");

        return back()->with('success', 'Document verwijderd!');
    }
}
