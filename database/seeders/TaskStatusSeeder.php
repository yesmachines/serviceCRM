<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['status' => 'OPEN','priority' => 1, 'active' => true],
            ['status' => 'ONHOLD',    'priority' => 2, 'active' => true],
            ['status' => 'CLOSED',  'priority' => 3, 'active' => true],
            // ['status' => 'CANCEL',    'priority' => 4, 'active' => true],
         
        ];
   

        foreach ($statuses as $status) {
            TaskStatus::updateOrCreate(
                ['status' => $status['status']],
                $status
            );
        }
    }
}
