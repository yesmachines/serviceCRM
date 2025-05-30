<?php

return [
    'admin' => [

        [
            'text' => 'DRF Requests',
            'route' => 'drf-requests.index',
            'icon' => 'ri-inbox-archive-fill',
            //'can' => 'permission',
            'active' => ['drf-requests/*']
                ],
       
             [
            'text' => 'Vehicles',
            'route' => 'vehicles.index',
            'icon' => 'ri-road-map-line',
            //'can' => 'permission',
            'active' => ['vehicles/*']
                ],

              

           [
            'text' => 'Employees',
            'route' => 'technicians.index',
            'icon' => 'ri-folder-user-line',
            //'can' => 'permission',
            'active' => ['technicians/*']
        ],

    
         [
            'text' => 'Job Schedules',
            'route' => 'job-schedules.index',
            'icon' => 'ri-suitcase-fill',
            //'can' => 'permission',
            'active' => ['job-schedules/*']
        ],

        [
            'text' => 'Reports',
            'icon' => 'ri-file-list-line',
            //'can' => 'settings',
            'active' => ['service-report/*'],
            'submenu' => [

                [
                    'text' => 'Demo Client Feedback',
                    'route' => 'demo-client-reports.index',
                    //'can' => 'role_read',
                    'active' => ['demo-client-reports/*']
                ],

                [
                    'text' => 'Installation Report',
                    'route' => 'installation-reports.index',
                    //'can' => 'role_read',
                    'active' => ['installation-reports/*']
                ],

                [
                    'text' => 'Service Report',
                    'route' => 'service-reports.index',
                    //'can' => 'role_read',
                    'active' => ['service-reports/*']
                ],

                
              
            ]
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
                    'active' => ['roles/*']
                ],
             
                
         [
            'text' => 'Job Types',
            'route' => 'service-types.index',
            'icon' => 'ri-customer-service-line',
            //'can' => 'permission',
            'active' => ['service-types/*']
        ],
        
          [
            'text' => 'Job Statuses',
            'route' => 'job-statuses.index',
            'icon' => 'ri-creative-commons-nd-line',
            //'can' => 'permission',
            'active' => ['job-statuses/*']
        ],

          [
            'text' => 'Task Statuses',
            'route' => 'task-statuses.index',
            'icon' => 'ri-task-fill',
            //'can' => 'permission',
            'active' => ['task-statuses/*']
        ],

            ]],
    ],
];
