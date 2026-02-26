<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Machine;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Technician;

class FeedbackController extends Controller
{
    /**
     * Toon alle feedback aanvragen (intern overzicht)
     */
    public function index()
    {
        $feedbacks = Feedback::with(['machine', 'technician'])
            ->orderByDesc('feedback_requested_at')
            ->get();

        return view('feedback.index', compact('feedbacks'));
    }

    /**
     * Toon form om een nieuwe feedback request aan te maken (intern)
     * -> kiest machine + technician (monteur)
     */

    public function requestCreate()
    {
        $machines = Machine::where('status', 'installed')
            ->orderBy('type')
            ->get();

        $technicians = Technician::orderBy('name')->get();

        return view('feedback.create', [
            'feedback' => null,
            'machines' => $machines,
            'technicians' => $technicians,
        ]);
    }

    public function requestStore(Request $request)
    {
        $validated = $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'technician_id' => 'required|exists:technicians,id', // <-- belangrijk
        ]);

        $machine = Machine::findOrFail($validated['machine_id']);

        $feedback = Feedback::create([
            'customer_id' => $machine->customer_id ?? null,
            'machine_id' => $machine->id,
            'technician_id' => $validated['technician_id'],
            'feedback_requested_at' => now(),
            'score' => null,
            'comments' => null,
        ]);

        return redirect()->route('feedback.index')
            ->with('success', 'Feedback request aangemaakt en monteur toegewezen.');
    }


    /**
     * Toon feedback form voor klant (extern/guest)
     */
    public function create(Feedback $feedback)
    {
        if ($feedback->isFeedbackGiven()) {
            return view('feedback.already-given', compact('feedback'));
        }

        return view('feedback.create', compact('feedback'));
    }

    /**
     * Sla klant feedback op (extern/guest)
     */
    public function store(Request $request, Feedback $feedback)
    {
        if ($feedback->isFeedbackGiven()) {
            return redirect()->route('feedback.review', $feedback->id);
        }

        $validated = $request->validate([
            'score' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
        ]);

        $feedback->update([
            'score' => $validated['score'],
            'comments' => $validated['comments'] ?? null,
            // 'submitted_at' => now(),  // <- verwijderen
        ]);

        return redirect()->route('feedback.thankyou', $feedback->id)
            ->with('success', 'Thank you for your feedback!');
    }


    /**
     * Review pagina (extern/guest)
     */
    public function review(Feedback $feedback)
    {
        return view('feedback.review', compact('feedback'));
    }

    /**
     * Bedank pagina (extern/guest)
     */
    public function thankYou(Feedback $feedback)
    {
        return view('feedback.thank-you', compact('feedback'));
    }
}
