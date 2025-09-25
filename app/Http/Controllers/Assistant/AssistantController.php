<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\FaultReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistantController extends Controller
{

    /**
     * Display the RA dashboard.
     */
    public function dashboard()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Get reports based on user role and residence block
        if ($user->role === 'assistant') { 
            // Get reports from users in the same residence block
            $reports = FaultReport::with(['user'])
                ->whereHas('user', function($query) use ($user) {
                    $query->where('residence', $user->residence);
                })
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        // Calculate the report counts
        $totalReports = $reports->count();
        $pendingReports = $reports->where('status', 'pending')->count();
        $resolvedReports = $reports->where('status', 'solved')->count();

        return view('assistant.dashboard', compact(
            'reports',
            'totalReports',
            'pendingReports',
            'resolvedReports'
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
