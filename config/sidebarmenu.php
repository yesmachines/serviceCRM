<?php

return [
    'admin' => [
       
             [
            'text' => 'Vehicles',
            'route' => 'vehicles.index',
            'icon' => 'ri-road-map-line',
            //'can' => 'permission',
            'active' => ['vehicles', 'vehicles/*']
                ],

           [
            'text' => 'Employees',
            'route' => 'technicians.index',
            'icon' => 'ri-folder-user-line',
            //'can' => 'permission',
            'active' => ['technicians', 'technicians/*']
        ],

    
         [
            'text' => 'Jobs',
            'route' => 'job-schedules.index',
            'icon' => 'ri-suitcase-fill',
            //'can' => 'permission',
            'active' => ['Jobs', 'jobs/*']
        ],

        [
            'text' => 'Settings',
            'icon' => ' ri-settings-2-line',
            //'can' => 'settings',
            'active' => ['roles/*','service-types/*','job-statuses/*','task-statuses/*'],
            'submenu' => [
                [
                    'text' => 'Roles',
                    'route' => 'roles.index',
                    //'can' => 'role_read',
                    'active' => ['roles', 'roles/*']
                ],
             
                
         [
            'text' => 'Job Types',
            'route' => 'service-types.index',
            'icon' => 'ri-customer-service-line',
            //'can' => 'permission',
            'active' => ['service-types', 'service-types/*']
        ],
        
          [
            'text' => 'Job Statuses',
            'route' => 'job-statuses.index',
            'icon' => 'ri-creative-commons-nd-line',
            //'can' => 'permission',
            'active' => ['job-statuses', 'job-statuses/*']
        ],

          [
            'text' => 'Task Statuses',
            'route' => 'task-statuses.index',
            'icon' => 'ri-task-fill',
            //'can' => 'permission',
            'active' => ['task-statuses', 'task-statuses/*']
        ],

            ]],
    ],
];
