<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Role → Permissions Mapping
    |--------------------------------------------------------------------------
    */
    'roles' => [
        'super-admin' => [
            'all', // Super-admin has all permissions
        ],
        'admin' => [
            // Dashboard
            'home',
            'dashboard',
            'dashboard.data',

            // Categories
            'categories.index',
            'categories.create',
            'categories.store',
            'categories.show',
            'categories.edit',
            'categories.update',
            'categories.destroy',

            // Items
            'item.index',
            'item.add',
            'item.store',
            'item.bulkDelete',
            'item.deleteSelected',
            'item.import',
            'item.export',
            'item.categories',
            'item.view',
            'item.edit',
            'item.update',
            'item.destroy',

            // Profile
            'item.profile',
            'pages-profile-settings',
            'profile.settings.update',

            // Tracking
            'track.action',
        ],
        'user' => [
            // General
            'home',
            'track.action',

            // Banners
            'banners.create',
            'banners.store',

            // User
            'user.add',
            'user.store',

            // Items
            'item.userview',
            'category.items',

            // Profile
            'item.profile',
            'pages-profile-settings',
            'profile.settings.update',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Permission Categories (for UI display, checkboxes, etc.)
    |--------------------------------------------------------------------------
    */
    'permissions' => [
        'Dashboard' => [
            'home',
            'dashboard',
            'dashboard.data',
        ],
        'Categories' => [
            'categories.index',
            'categories.create',
            'categories.store',
            'categories.show',
            'categories.edit',
            'categories.update',
            'categories.destroy',
        ],
        'Items' => [
            'item.index',
            'item.add',
            'item.store',
            'item.bulkDelete',
            'item.deleteSelected',
            'item.import',
            'item.export',
            'item.categories',
            'item.view',
            'item.edit',
            'item.update',
            'item.destroy',
        ],
        'Profile' => [
            'item.profile',
            'pages-profile-settings',
            'profile.settings.update',
        ],
        'Tracking' => [
            'track.action',
        ],
        'Banners' => [
            'banners.create',
            'banners.store',
        ],
        'Users' => [
            'user.add',
            'user.store',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Menu Structure (linked with permissions)
    |--------------------------------------------------------------------------
    */
    'menu' => [
        [
            'title' => 'Home',
            'icon' => 'ri-home-4-line',
            'route' => 'home',
            'permission' => 'home',
        ],
        [
            'title' => 'Dashboard',
            'icon' => 'ph-gauge',
            'route' => 'dashboard',
            'permission' => 'dashboard',
        ],
        [
            'title' => 'Categories',
            'icon' => 'ri-folders-line',
            'permission' => 'categories.index',
            'children' => [
                [
                    'title' => 'Category List',
                    'icon' => 'ri-list-check',
                    'route' => 'categories.index',
                    'permission' => 'categories.index',
                ],
                [
                    'title' => 'Add Category',
                    'icon' => 'ri-add-circle-line',
                    'route' => 'categories.create',
                    'permission' => 'categories.create',
                ],
            ],
        ],
        [
            'title' => 'Banners',
            'icon' => 'ri-image-line',
            'permission' => 'banners.create',
            'children' => [
                [
                    'title' => 'All Banners',
                    'icon' => 'ri-file-list-line',
                    'route' => 'banners.index',
                    'permission' => 'banners.create',
                ],
                [
                    'title' => 'Add Banner',
                    'icon' => 'ri-add-line',
                    'route' => 'banners.create',
                    'permission' => 'banners.create',
                ],
            ],
        ],
        [
            'title' => 'Items',
            'icon' => 'ri-archive-line',
            'permission' => 'item.index',
            'children' => [
                [
                    'title' => 'All Items',
                    'icon' => 'ri-file-list-line',
                    'route' => 'item.index',
                    'permission' => 'item.index',
                ],
                [
                    'title' => 'Add Item',
                    'icon' => 'ri-add-line',
                    'route' => 'item.add',
                    'permission' => 'item.add',
                ],
            ],
        ],
        [
            'title' => 'Profile',
            'icon' => 'ri-user-3-line',
            'route' => 'item.profile',
            'permission' => 'item.profile',
        ],
    ],
];
