<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerFeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with('user','report')->latest()->get();
        return view('manager.feedbacks', compact('feedbacks'));
    }

    public function create()
    {
        return view('manager.feedbacks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'comments' => 'required|string|max:1000',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'comments' => $request->comments,
        ]);

        return redirect()->route('manager.feedbacks')->with('success', 'Feedback submitted successfully.');
    }
}
