<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\FaultReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{

    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {

        // Get the currently authenticated user
        $user = Auth::user();

        $reports = FaultReport::with(['user'])
            ->where('user_id', $user->id)
            ->get();

        // Calculate the report counts
        $totalReports = $reports->count();
        $pendingReports = $reports->where('status', 'pending')->count();
        $resolvedFaults = $reports->where('status', 'solved')->count();

        return view('student.dashboard', compact(
            'reports',
            'totalReports',
            'pendingReports',
            'resolvedFaults'
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
