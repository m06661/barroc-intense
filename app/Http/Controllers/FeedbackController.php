<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Machine;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Toon alle feedback aanvragen
     */

    public function index()
    {
        $feedbacks = Feedback::orderBy('feedback_requested_at', 'desc')->get();
        return view('feedback.index', compact('feedbacks'));
    }

    /**
     * Toon form om nieuwe feedback aan te maken
     */
    public function new()
    {
        $machines = Machine::where('status', 'installed')->get();
        return view('feedback.new', compact('machines'));
    }

    /**
     * Toon feedback form voor bestaande feedback
     */
    public function create(Feedback $feedback)
    {

        if ($feedback->isFeedbackGiven()) {
            return view('feedback.already-given', compact('feedback'));
        }

        return view('feedback.create', compact('feedback'));
    }

    /**
     * Sla feedback op
     */
    public function store(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'score' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
        ]);

        $feedback->update([
            'score' => $validated['score'],
            'comments' => $validated['comments'],
        ]);

        return redirect()->route('feedback.thankyou', $feedback->id)
            ->with('success', 'Thank you for your feedback!');
    }

    /**
     * Bedank pagina
     */
    public function thankYou(Feedback $feedback)
    {
        return view('feedback.thank-you', compact('feedback'));
    }
}
