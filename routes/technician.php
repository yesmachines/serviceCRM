<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Technician\UserController;
use App\Http\Controllers\API\CommonController;

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
        });
