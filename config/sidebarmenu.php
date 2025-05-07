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
