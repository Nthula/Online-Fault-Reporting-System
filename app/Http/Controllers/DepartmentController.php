<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    //     $departments = Department::with(['users'])->get();
    //     return view('admin.departments', compact('departments'));
    // }

    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $departments = Department::with('manager')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('manager', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->orderBy('name')
            ->paginate(10);

        return view('admin.departments', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.create-department', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'manager' => 'nullable|exists:users,id', // Change to nullable
            'category_type' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Create the department with all required fields
        $department = Department::create([
            'name' => $validated['name'],
            'staff_id' => $validated['manager'] ?? null, // Make it optional
            'category_type' => $validated['category_type'],
            'description' => $validated['description'] ?? null,
        ]);

        // Only update the manager's department_id if a manager was selected
        if (isset($validated['manager'])) {
            User::where('id', $validated['manager'])->update(['department_id' => $department->department_id]);
        }

        return redirect()->route('admin.departments')->with('success', 'Department created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $departments = Department::with(['users'])->findOrFail($department->department_id);
        return view('admin.view-department', compact('departments'));
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
    public function destroy(Department $department)
    {
        $department->delete();
        return back()->with('success', 'Department deleted successfully.');
    }
}
