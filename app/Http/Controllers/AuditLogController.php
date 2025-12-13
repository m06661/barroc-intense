<?php

namespace App\Http\Controllers;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = AuditLog::query()
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->date, fn($q) => $q->whereDate('created_at', $request->date))
            ->latest()
            ->get();

        return view('audit.index', compact('logs'));
    }

}
