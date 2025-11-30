<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Technician;
use App\Models\ContactMessage;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->q;

        // Customers
        $customers = Customer::where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->get();

        // Orders
        $orders = Order::where('order_number', 'LIKE', "%{$search}%")
            ->orWhereHas('customer', fn($q) =>
            $q->where('name', 'LIKE', "%{$search}%")
            )
            ->get();

        // Machines (Products)
        $products = Product::where('machine_id', 'LIKE', "%{$search}%")
            ->orWhere('type', 'LIKE', "%{$search}%")
            ->get();

        // Invoices
        $invoices = Invoice::where('invoice_number', 'LIKE', "%{$search}%")
            ->orWhere('amount', 'LIKE', "%{$search}%")
            ->get();

        // Technicians
        $technicians = Technician::where('name', 'LIKE', "%{$search}%")
            ->get();

        // Contact Messages
        $messages = ContactMessage::where('subject', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->get();

        return view('search.results', compact(
            'search',
            'customers',
            'orders',
            'products',
            'invoices',
            'technicians',
            'messages'
        ));
    }

}
