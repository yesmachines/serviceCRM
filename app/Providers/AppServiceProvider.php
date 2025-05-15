<?php

namespace App\Providers;

use App\Services\Interfaces\JobScheduleServiceInterface;
use App\Services\JobScheduleService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register(): void {
        $this->app->bind(JobScheduleServiceInterface::class, JobScheduleService::class);
    }

  
}
