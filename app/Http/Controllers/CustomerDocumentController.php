<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerDocumentController extends Controller
{
    public function index(Customer $customer)
    {
        // Haal documenten op uit storage
        $files = $customer->documents;

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
            'document' => 'required|file|max:20480',
        ]);

        $file = $request->file('document');
        $name = time().'_'.$file->getClientOriginalName();

        // Bestand opslaan
        $path = $file->storeAs("customers/{$customer->id}", $name, 'public');

        // DATABASE opslaan
        $customer->documents()->create([
            'filename' => $name,
            'path' => $path
        ]);

        return back()->with('success', 'Document geupload!');
    }


    public function destroy(Customer $customer, CustomerDocument $document)
    {
        Storage::disk('public')->delete($document->path);
        $document->delete();

        return back()->with('success', 'Document verwijderd!');
    }

}
