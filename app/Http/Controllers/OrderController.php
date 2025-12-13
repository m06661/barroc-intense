<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // OVERZICHT + PRIORITEIT HERSCHIKKEN
    public function index()
    {
        $orders = Order::with('customer')
            ->orderByRaw("
                CASE priority
                    WHEN 'spoed' THEN 1
                    WHEN 'achterstand' THEN 2
                    ELSE 3
                END
            ")
            ->get();

        return view('orders.index', compact('orders'));
    }

    // DETAILS
    public function show($id)
    {
        $order = Order::with(['customer', 'invoices'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    // STATUS WIJZIGEN
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back();
    }

    // PRIORITEIT WIJZIGEN
    public function updatePriority(Request $request, $id)
    {
        $request->validate([
            'priority' => 'required|in:normaal,spoed,achterstand'
        ]);

        $order = Order::findOrFail($id);
        $order->priority = $request->priority;
        $order->save();

        return redirect()->back();
    }
}
