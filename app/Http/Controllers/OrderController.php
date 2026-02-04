<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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

    public function markDelivered(Request $request, $id)
{
    $request->validate([
        'delivery_proof' => 'required|image|max:5120'
    ]);

    $order = Order::findOrFail($id);

    // alleen afronden als je in delivery zit
    if ($order->status !== 'delivery') {
        return redirect()->back()->with('error', 'Order staat niet op delivery.');
    }

    $path = $request->file('delivery_proof')->store('delivery_proofs', 'public');

    $order->status = 'invoice';
    $order->delivered_at = now();
    $order->delivered_by = auth()->id(); // prima
    $order->delivery_proof = $path;
    $order->save();

    return redirect()->back()->with('success', 'Levering succesvol afgerond.');
}


}
