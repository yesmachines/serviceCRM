<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\DemoClientFeedbackController;
use App\Http\Controllers\Auth\JobController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\HomeController;
use App\Http\Controllers\Auth\InstallationReportController;
use App\Http\Controllers\Auth\JobScheduleController;
use App\Http\Controllers\Auth\JobStatusController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\ServiceReportController;
use App\Http\Controllers\Auth\ServiceTypeController;
use App\Http\Controllers\Auth\TaskStatusController;
use App\Http\Controllers\Auth\TechnicianController;
use App\Http\Controllers\Auth\VehicleController;

        Route::middleware('guest')->group(function () {
                Route::get('login', [AuthenticatedSessionController::class, 'create'])
                        ->name('login');
                Route::post('login', [AuthenticatedSessionController::class, 'store']);
        });

        Route::middleware('auth')->group(function () {
                Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
                Route::get('dashboard', [HomeController::class, 'index'])
                ->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::resource('roles', RoleController::class);
        Route::resource('job-schedules', JobScheduleController::class)->except('show');
        Route::get('job-schedules/data', [JobScheduleController::class, 'getData'])->name('job-schedules.data');
        Route::resource('vehicles', VehicleController::class)->except('show');
        Route::get('vehicles/data', [VehicleController::class, 'getData'])->name('vehicles.data');        
        Route::get('/ajax/supplier/{supplier}', [JobScheduleController::class, 'getSuppliersByProduct']);
        Route::get('/ajax/company-customers/{company}', [JobScheduleController::class, 'getCustomersByCompany']);
        Route::get('/ajax/find-order', [JobScheduleController::class, 'findOrder'])->name('find-order.ajax');
        Route::get('technicians/data', [TechnicianController::class, 'getData'])->name('technicians.data');
        Route::resource('technicians', TechnicianController::class);
        Route::get('service-types/data', [ServiceTypeController::class, 'getData'])->name('service-types.data');
        Route::resource('service-types', ServiceTypeController::class);
        Route::get('job-statuses/data', [JobStatusController::class, 'getData'])->name('job-statuses.data');
        Route::resource('job-statuses', JobStatusController::class);
        Route::get('task-statuses/data', [TaskStatusController::class, 'getData'])->name('task-statuses.data');
        Route::resource('task-statuses', TaskStatusController::class);
        Route::resource('service-reports', ServiceReportController::class);
        Route::get('service-reports-data/data', [ServiceReportController::class, 'getData'])->name('service-reports.data');
       
        Route::resource('installation-reports', InstallationReportController::class);
        Route::get('installation-data/data', [InstallationReportController::class, 'getData'])->name('installation-reports.data');

        Route::resource('demo-client-reports', DemoClientFeedbackController::class)->except('show');
        Route::get('demo-client-reports/data', [DemoClientFeedbackController::class, 'getData'])->name('demo-client-reports.data');
        
        Route::get('/ajax/find-demo', [JobScheduleController::class, 'findDemo'])->name('find-demo.ajax');
        
});


