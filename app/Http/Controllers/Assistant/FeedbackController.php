<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\FaultReport;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with('user')->latest()->get();
        return view('assistant.feedbacks', compact('feedbacks'));
    }

    public function create()
    {
        return view('assistant.feedbacks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:fault_reports,report_id',
            'comments' => 'required|string|max:1000',
            // 'student_validation' => 'nullable|boolean'
        ]);

        // Check if the report belongs to the student
        $report = FaultReport::where('report_id', $request->report_id)
                    ->where('user_id', Auth::id())
                    ->where('status', 'solved')
                    ->firstOrFail();

        // Check if feedback already exists
        if ($report->feedback) {
            return redirect()->back()->with('error', 'You have already submitted feedback for this report.');
        }

        Feedback::create([
            'report_id' => $request->report_id,
            'comments' => $request->comments,
            'student_validation' => true
        ]);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
