<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Coordinator\UserController;
use App\Http\Controllers\API\CommonController;

Route::middleware(['auth:coordinator', 'ability:servicemanager,servicecoordinator'])
        ->prefix('coordinator')
        ->name('coordinator.')
        ->group(function () {
            Route::post('/logout', [CommonController::class, 'logout'])->name('logout');
            Route::post('/update-device', [CommonController::class, 'updateDevice'])->name('updateDevice');
            Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        });
