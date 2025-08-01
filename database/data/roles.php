<?php

return [
    'super admin' => [
        // There's no need to add 'create' and `delete` here
        'roles' => ['read', 'update'],
        'permissions' => ['read'],
        'users' => '*',
        'settings' => '*',
    ],
    'admin' => [
        'roles' => ['read'],
        'permissions' => ['read'],
        'users' => ['create', 'read', 'update', 'delete'],
        'settings' => ['create', 'read', 'update'],
    ],
    'moderator' => [
        'roles' => ['read'],
        'permissions' => ['read'],
        'users' => ['read'],
        'settings' => ['read'],
    ],
    // Add as many roles as you want.
];
