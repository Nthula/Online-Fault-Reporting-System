<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaultReportController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Manager\ManagerFaultReportController;
use App\Http\Controllers\Manager\ManagerFeedbackController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\StudentFaultReportController;
use App\Http\Controllers\Assistant\AssistantController;
use App\Http\Controllers\Assistant\FeedbackController as AssistantFeedbackController;
use App\Http\Controllers\Assistant\ReportsController;
use App\Http\Controllers\Student\StudentFeedbackController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\ImportController;

Route::get('/', function () {
    return view('welcome'); // Updated to point to the welcome view
});

Route::middleware(['auth', 'verified'])->group(function () {

    //=======================================================================================
    // ADMIN ROUTES
    //=======================================================================================
    Route::prefix('admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [UserController::class, 'dashboard'])
            ->name('admin.dashboard')
            ->middleware('role:admin');

        // Users
        Route::get('/users', [UserController::class, 'index'])
            ->name('admin.users')
            ->middleware('role:admin');
        Route::resource('users', UserController::class)->except(['index'])
            ->names([
                'create' => 'admin.users.create',
                'store' => 'admin.users.store',
                'show' => 'admin.users.show',
                'edit' => 'admin.users.edit',
                'update' => 'admin.users.update',
                'destroy' => 'admin.users.destroy',
            ]);

        // Departments
        Route::get('/departments', [DepartmentController::class, 'index'])
            ->name('admin.departments')
            ->middleware('role:admin');
        Route::resource('departments', DepartmentController::class)->except(['index'])
            ->names([
                'create' => 'admin.departments.create',
                'store' => 'admin.departments.store',
                'show' => 'admin.departments.show',
                'edit' => 'admin.departments.edit',
                'update' => 'admin.departments.update',
                'destroy' => 'admin.departments.destroy',
            ]);

        // Feedbacks
        Route::get('/feedbacks', [FeedbackController::class, 'index'])
            ->name('admin.feedbacks')
            ->middleware('role:admin');
        Route::resource('feedbacks', FeedbackController::class)->except(['index'])
            ->names([
                'create' => 'admin.feedbacks.create',
                'store' => 'admin.feedbacks.store',
                'show' => 'admin.feedbacks.show',
                'edit' => 'admin.feedbacks.edit',
                'update' => 'admin.feedbacks.update',
                'destroy' => 'admin.feedbacks.destroy',
            ]);
    });

    //=======================================================================================
    // MANAGER ROUTES
    //=======================================================================================
    Route::prefix('manager')->group(function () {
        // Dashboard
        Route::get('/dashboard', [ManagerController::class, 'dashboard'])
            ->name('manager.dashboard')
            ->middleware('role:manager');


        // Feedback
        Route::get('/feedbacks', [ManagerFeedbackController::class, 'index'])
            ->name('manager.feedbacks')
            ->middleware('role:manager');
        Route::resource('feedbacks', ManagerFeedbackController::class)->except(['index'])
            ->names([
                'create' => 'manager.feedbacks.create',
                'store' => 'manager.feedbacks.store',
                'show' => 'manager.feedbacks.show',
                'edit' => 'manager.feedbacks.edit',
                'update' => 'manager.feedbacks.update',
                'destroy' => 'manager.feedbacks.destroy',
            ]);


        // Reports
        Route::get('/reports', [ManagerFaultReportController::class, 'index'])
            ->name('manager.reports')
            ->middleware('role:manager');
        Route::resource('reports', ManagerFaultReportController::class)->except(['index'])
            ->names([
                'create' => 'manager.reports.create',
                'store' => 'manager.reports.store',
                'show' => 'manager.reports.show',
                'edit' => 'manager.reports.edit',
                'update' => 'manager.reports.update',
                'destroy' => 'manager.reports.destroy',
            ]);
            Route::post('/reports/{report}/assign', [ManagerFaultReportController::class, 'assign'])->name('manager.reports.assign');
            Route::post('/reports/{report}/unassign', [ManagerFaultReportController::class, 'unassign'])->name('manager.reports.unassign');
    });

    //=======================================================================================
    // STUDENT ROUTES
    //=======================================================================================
    Route::prefix('student')->group(function () {
        // Dashboard
        Route::get('/dashboard', [StudentController::class, 'dashboard'])
            ->name('student.dashboard')
            ->middleware('role:student');

        // Reports
        Route::get('/reports', [StudentFaultReportController::class, 'index'])
            ->name('student.reports')
            ->middleware('role:student');
        Route::resource('reports', StudentFaultReportController::class)->except(['index'])
            ->names([
                'create' => 'student.reports.create',
                'store' => 'student.reports.store',
                'show' => 'student.reports.show',
                'edit' => 'student.reports.edit',
                'update' => 'student.reports.update',
                'destroy' => 'student.reports.destroy',
            ]);

        // Feedbacks
        Route::get('/feedbacks', [StudentFeedbackController::class, 'index'])
            ->name('student.feedbacks')
            ->middleware('role:student');
        Route::resource('feedbacks', StudentFeedbackController::class)->except(['index'])
            ->names([
                'create' => 'student.feedbacks.create',
                'store' => 'student.feedbacks.store',
                'show' => 'student.feedbacks.show',
                'edit' => 'student.feedbacks.edit',
                'update' => 'student.feedbacks.update',
                'destroy' => 'student.feedbacks.destroy',
            ]);
    });

    //=======================================================================================
    // RA ROUTES
    //=======================================================================================
    Route::prefix('assistant')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AssistantController::class, 'dashboard'])
            ->name('assistant.dashboard')
            ->middleware('role:assistant');

        // Reports
        Route::get('/reports', [ReportsController::class, 'index'])
            ->name('assistant.reports')
            ->middleware('role:assistant');
        Route::resource('reports', ReportsController::class)->except(['index'])
            ->names([
                'create' => 'assistant.reports.create',
                'store' => 'assistant.reports.store',
                'show' => 'assistant.reports.show',
                'edit' => 'assistant.reports.edit',
                'update' => 'assistant.reports.update',
                'destroy' => 'assistant.reports.destroy',
            ]);

        // Feedbacks
        Route::get('/feedbacks', [AssistantFeedbackController::class, 'index'])
            ->name('assistant.feedbacks')
            ->middleware('role:assistant');
        Route::resource('feedbacks', AssistantFeedbackController::class)->except(['index'])
            ->names([
                'create' => 'assistant.feedbacks.create',
                'store' => 'assistant.feedbacks.store',
                'show' => 'assistant.feedbacks.show',
                'edit' => 'assistant.feedbacks.edit',
                'update' => 'assistant.feedbacks.update',
                'destroy' => 'assistant.feedbacks.destroy',
            ]);
        Route::get('/assistant/reports/{report}', [ReportsController::class, 'show'])->name('assistant.reports.show');
        Route::post('/assistant/reports/{report}/validate', [ReportsController::class, 'validate'])->name('assistant.reports.validate');
    });

    Route::post('/admin/import-students', [ImportController::class, 'importStudents'])->name('admin.import.students');

    //=======================================================================================
    // SHARED ROUTES
    //=======================================================================================
    // Profile (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
