<?php

declare(strict_types=1);

return [
    'roles' => [
        'admin' => [
            'name' => 'App-Zentrale-Admin',
            'permissions' => [
                'see-app-zentrale',
                'manage-app-zentrale',
                'see-app-assets',
                'see-app-assets-zentrale',
                'see-app-fuhrpark',
                'operate-app-fuhrpark-zentrale',
            ],
        ],
        'user' => [
            'name' => 'App-Zentrale-Benutzer',
            'permissions' => [
                'see-app-zentrale',
                'see-app-assets',
                'see-app-assets-zentrale',
                'see-app-fuhrpark',
                'operate-app-fuhrpark-zentrale',
            ],
        ],
    ],
];
