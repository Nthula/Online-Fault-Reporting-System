<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\FaultReport;
use App\Models\Worker;
use Illuminate\Http\Request;

class ManagerFaultReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = FaultReport::with(['user'])
            ->where('validated', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('manager.reports', compact('reports'));
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
    public function show(FaultReport $report)
    {
        
        $workers = Worker::get();
        $assignedWorker = Worker::where('report_id', $report->report_id)->get(); // Get the currently assigned worker if any

        return view('manager.view-reports', compact('report','workers', 'assignedWorker'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    public function assign(Request $request, Worker $worker)
    {
        $request->validate([
            'worker_id' => 'required|exists:workers'
        ]);
        
        $worker->worker_id = $request->worker_id;
        $worker->update();
        
        return redirect()->back()->with('success', 'Worker assigned successfully!');
    }

    public function unassign(FaultReport $report)
    {
        $report->worker_id = null;
        $report->save();
        
        return redirect()->back()->with('success', 'Worker unassigned successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FaultReport $report)
    {
        $request->validate([
            'status' => 'required|in:pending,solved'
        ]);
        
        $updateData = ['status' => $request->status];
        
        if ($request->status === 'solved') {
            $updateData['solved_at'] = now();
        } else {
            $updateData['solved_at'] = null;
        }
        
        $report->update($updateData);
        
        return back()->with('success', 'Report status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
