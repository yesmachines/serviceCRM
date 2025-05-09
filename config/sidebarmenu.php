<?php

return [
    'admin' => [
        [
            'text' => 'Invoice',
            'url' => '/',
            'icon' => ' ri-outlet-2-line',
            //'can' => 'permission',
            'active' => ['admin', 'admin/*']
        ],

          [
            'text' => 'vehicles',
            'route' => 'vehicles.index',
            'icon' => ' ri-outlet-2-line',
            //'can' => 'permission',
            'active' => ['vehicles', 'vehicles/*']
        ],

           [
            'text' => 'technicians',
            'route' => 'technicians.index',
            'icon' => ' ri-outlet-2-line',
            //'can' => 'permission',
            'active' => ['technicians', 'technicians/*']
        ],


         [
            'text' => 'Jobs',
            'route' => 'jobs.index',
            'icon' => ' ri-outlet-2-line',
            //'can' => 'permission',
            'active' => ['jobs', 'jobs/*']
        ],

        [
            'text' => 'Settings',
            'icon' => ' ri-settings-2-line',
            //'can' => 'settings',
            'active' => ['roles', 'roles/*'],
            'submenu' => [
                [
                    'text' => 'Roles',
                    'route' => 'roles.index',
                    //'can' => 'role_read',
                    'active' => ['roles', 'roles/*']
                ]
            ]],
    ],
];
