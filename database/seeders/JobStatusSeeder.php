<?php

namespace Database\Seeders;

use App\Models\JobStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['status' => 'NEW','priority' => 1, 'active' => true],
            ['status' => 'OPEN','priority' => 2, 'active' => true],
            ['status' => 'PAIN',    'priority' => 3, 'active' => true],
            ['status' => 'CLOSED',  'priority' => 4, 'active' => true],
            ['status' => 'CAN CELLED',  'priority' => 5, 'active' => true],
            ['status' => 'ON HOLD',  'priority' => 6, 'active' => true],
         
        ];
   

        foreach ($statuses as $status) {
            JobStatus::updateOrCreate(
                ['status' => $status['status']],
                $status
            );
        }
    
    }
}
