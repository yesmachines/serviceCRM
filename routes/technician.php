<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Technician\UserController;
use App\Http\Controllers\API\CommonController;
use App\Http\Controllers\API\Technician\InstallationReportController;
use App\Http\Controllers\API\Technician\ServiceReportController;
use App\Http\Controllers\API\Technician\TaskController;
use App\Http\Controllers\API\Technician\DemoClientFeedbackController;
use App\Models\InstallationReport;

Route::middleware(['api'])
        ->name('technician.')
        ->group(function () {
            Route::post('/login', [UserController::class, 'login'])->name('login');
        });

Route::middleware(['auth:technician', 'ability:servicetechnician,dcm'])
        ->name('technician.')
        ->group(function () {
            Route::post('/logout', [CommonController::class, 'logout'])->name('logout');
            Route::post('/update-device', [CommonController::class, 'updateDevice'])->name('updateDevice');
            Route::get('/profile', [UserController::class, 'profile'])->name('profile');
            Route::resource('tasks', TaskController::class);
            Route::apiResource('service-reports', ServiceReportController::class);
            Route::apiResource('installation-reports', InstallationReportController::class);
            Route::apiResource('demo-client-feedbacks',DemoClientFeedbackController::class);
        });
