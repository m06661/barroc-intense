<?php

namespace App\Http\Controllers;

use App\Models\Machine;

class MachineController extends Controller
{
    public function index()
    {
        $machines = Machine::with('customer')->get();
        return view('machines.index', compact('machines'));
    }
}
