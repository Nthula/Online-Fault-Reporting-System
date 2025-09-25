<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    /**
     * Import students from an SQL file into the users table.
     */
    public function importStudents(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'students_file' => 'required|file|mimes:sql,txt',
        ]);

        // Get the uploaded file
        $file = $request->file('students_file');

        try {
            // Begin a transaction
            DB::beginTransaction();

            // Read and execute the SQL file line by line
            $handle = fopen($file->getRealPath(), 'r');
            
            if ($handle) {
                $query = '';
                while (($line = fgets($handle)) !== false) {
                    // Skip comments and empty lines
                    if (substr(trim($line), 0, 2) == '--' || trim($line) == '') {
                        continue;
                    }
                    
                    $query .= $line;
                    
                    // If it has a semicolon at the end, it's the end of the query
                    if (substr(trim($line), -1, 1) == ';') {
                        // Perform the query
                        DB::statement($query);
                        // Reset the query variable
                        $query = '';
                    }
                }
                fclose($handle);
            }

            // Commit the transaction
            DB::commit();

            return redirect()->back()->with('success', 'Students imported successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            
            // Log the error for debugging
            Log::error('Student import failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Failed to import students: ' . $e->getMessage())
                ->withInput();
        }
    }
}