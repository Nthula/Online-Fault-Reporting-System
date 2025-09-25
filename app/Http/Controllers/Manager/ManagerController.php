<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\FaultReport;
use App\Models\Feedback;
use Illuminate\Http\Request;

class ManagerController extends Controller
{

    /**
     * Display the admin dashboard.
     */
    public function dashboard() {

        $reports = FaultReport::with(['user'])
            ->where('validated', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Report statistics
        $totalReports = FaultReport::where('validated', true)->count();
        $pendingReports = FaultReport::where('status', 'pending')->count();
        $resolvedReports = FaultReport::where('status', 'resolved')->count();
        $recentReports = FaultReport::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Feedback statistics
        $totalFeedback = Feedback::count();
        $validatedFeedback = Feedback::where('student_validation', true)->count();
        $recentFeedback = Feedback::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('manager.dashboard', compact(
            'reports',
            'totalReports',
            'pendingReports',
            'resolvedReports',
            'recentReports',
            'totalFeedback',
            'validatedFeedback',
            'recentFeedback'
        ));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
