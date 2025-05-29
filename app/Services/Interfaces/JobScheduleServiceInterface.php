<?php

namespace App\Services\Interfaces;

namespace App\Services\Interfaces;

use App\Http\Requests\Auth\StoreJobScheduleRequest;
use Illuminate\Support\Facades\Request;

interface JobScheduleServiceInterface
{
    public function createJobSchedule(StoreJobScheduleRequest $request);
    public function getJobSchedulesForDataTable(Request $request);
    public function getCreateData(Request $request): array;
    public function getEditData(int $id): array;
    public function updateJobSchedule(array $data, int $id): void;
    public function findOrder(Request $request): array;
    public function findDemo(Request $request): array;
    public function getIndexData(Request $request): array;
    
}