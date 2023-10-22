<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    | Here you can change the default title of your admin panel.
    |
    */

    'title' => 'Himakom',
    'title_prefix' => '',
    'title_postfix' => '',
    'bottom_title' => 'Himakom Polban',
    'current_version' => 'v0.9.1',


    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    */

    'logo' => '<b>Tab</b>LAR',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can set up an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'assets/logo/himakom.svg',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look at the layout section here:
    |
    */

    'layout_topnav' => false,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_light_sidebar' => 'light',
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,
    'layout_class' => 'default', //layout-fluid, layout-boxed, default is also available

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions, you can look at the auth classes section here:
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions, you can look at the admin panel classes here:
    |
    */

    'classes_body' => '',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions, you can look at the urls section here:
    |
    */

    'use_route_url' => true,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password.request',
    'password_email_url' => 'password.email',
    'profile_url' => 'profile.show',
    'setting_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Display Alert
    |--------------------------------------------------------------------------
    |
    | Display Alert Visibility.
    |
    */
    'display_alert' => false,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    |
    */
    'menu' => [
        [
            'text' => 'Dashboard',
            'icon' => 'ti ti-home',
            'route' => 'dashboard',
        ],
        [
            'text' => 'User Management',
            'icon' => 'ti ti-user',
            'hasAnyPermission' => ['access-users'],
            'submenu' => [
                [
                    'text' => 'Users',
                    'icon' => 'ti ti-users-group',
                    'route' => 'users-management.users.index',
                    'hasAnyPermission' => ['access-users'],
                ],                                
            ],
        ],
        [
            'text' => 'Auth Web',
            'icon' => 'ti ti-lock',
            'hasAnyPermission' => ['access-auth-web-permissions', 'access-auth-web-roles'],
            'submenu' => [
                [
                    'text' => 'Permission',
                    'icon' => 'ti ti-square-key',
                    'route' => 'auth-web.permissions.index',
                    'hasAnyPermission' => ['access-auth-web-permissions'],
                ],
                [
                    'text' => 'Role',
                    'icon' => 'ti ti-key',
                    'route' => 'auth-web.roles.index',
                    'hasAnyPermission' => ['access-auth-web-roles'],
                ],
            ],
        ],
        [
            'text' => 'Periodes',
            'icon' => 'ti ti-category-filled',
            'hasAnyPermission' => ['access-cabinets', 'access-filosofies', 'access-departments', 'access-programs', 'access-events'],
            'submenu' => [
                [
                    'text' => 'Cabinet',
                    'icon' => 'ti ti-category-2',
                    'route' => 'periodes.cabinets.index',
                    'hasAnyPermission' => ['access-cabinets'],
                ],
                [
                    'text' => 'Filosophy',
                    'icon' => 'ti ti-360',
                    'route' => 'periodes.filosofies.index',
                    'hasAnyPermission' => ['access-filosofies'],
                ],
                [
                    'text' => 'Department',
                    'icon' => 'ti ti-building-bank',
                    'route' => 'periodes.departments.index',
                    'hasAnyPermission' => ['access-departments'],
                ],
                [
                    'text' => 'Program',
                    'icon' => 'ti ti-file-check',
                    'url' => '#',
                    'hasAnyPermission' => ['access-programs'],
                ],
                [
                    'text' => 'Event',
                    'icon' => 'ti ti-calendar-event',
                    'url' => '#',
                    'hasAnyPermission' => ['access-events'],
                ]
            ],
        ],
        [
            'text' => 'Logs',
            'icon' => 'ti ti-file',
            'hasAnyPermission' => ['access-activity-logs', 'access-telescope'],
            'submenu' => [
                [
                    'text' => 'Activity Log',
                    'icon' => 'ti ti-file-text',
                    'route' => 'logs.activity-logs.index',
                    'hasAnyPermission' => ['access-activity-logs'],
                ],
                [
                    'text' => 'Telescope',
                    'icon' => 'ti ti-telescope',
                    'route' => 'logs.telescope.index',
                    'hasAnyPermission' => ['access-telescope'],
                ],
            ],
        ],
        [
            'text' => 'Content (Soon)',
            'icon' => 'ti ti-aspect-ratio',
            'hasAnyPermission' => ['access-news', 'access-articles', 'access-galleries', 'access-videos', 'access-documents'],
            'submenu' => [
                [
                    'text' => 'News',
                    'icon' => 'ti ti-article',
                    'url' => '#',
                    'hasAnyPermission' => ['access-news'],
                ],
                [
                    'text' => 'Article',
                    'icon' => 'ti ti-file-text',
                    'url' => '#',
                    'hasAnyPermission' => ['access-articles'],
                ],
                [
                    'text' => 'Gallery',
                    'icon' => 'ti ti-photo',
                    'url' => '#',
                    'hasAnyPermission' => ['access-galleries'],
                ],
                [
                    'text' => 'Video',
                    'icon' => 'ti ti-player-play',
                    'url' => '#',
                    'hasAnyPermission' => ['access-videos'],
                ],
                [
                    'text' => 'Document',
                    'icon' => 'ti ti-file',
                    'url' => '#',
                    'hasAnyPermission' => ['access-documents'],
                ],
            ],
        ],
        [
            'text' => 'Auth API\'s (Soon)',
            'icon' => 'ti ti-lock',
            'hasAnyPermission' => ['access-auth-api-permissions', 'access-auth-api-roles'],
            'submenu' => [
                [
                    'text' => 'Permission',
                    'icon' => 'ti ti-square-key',
                    'url' => '#',
                    'hasAnyPermission' => ['access-auth-api-permissions'],
                ],
                [
                    'text' => 'Role',
                    'icon' => 'ti ti-key',
                    'url' => '#',
                    'hasAnyPermission' => ['access-auth-api-roles'],
                ],
            ],
        ],
        [
            'text' => 'CV Himakom (Soon)',
            'icon' => 'ti ti-id-badge',
            'url' => '#',            
            'hasAnyPermission' => ['access-cv-himakom'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    |
    */

    'filters' => [
        TakiElias\Tablar\Menu\Filters\GateFilter::class,
        TakiElias\Tablar\Menu\Filters\HrefFilter::class,
        TakiElias\Tablar\Menu\Filters\SearchFilter::class,
        TakiElias\Tablar\Menu\Filters\ActiveFilter::class,
        TakiElias\Tablar\Menu\Filters\ClassesFilter::class,
        TakiElias\Tablar\Menu\Filters\LangFilter::class,
        TakiElias\Tablar\Menu\Filters\DataFilter::class,
        App\Filter\RolePermissionMenuFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Vite
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Vite support.
    |
    | For detailed instructions you can look the Vite here:
    | https://laravel-vite.dev
    |
    */

    'vite' => true,

    /*
    |--------------------------------------------------------------------------
    | Customization
    |--------------------------------------------------------------------------
    |
    | Here we can customize the admin panel.
    |
    */
    'default' => [
        'logo' => [
            'path' => 'assets/logo/himakom.png',
            'name' => 'Himakom',
            'alt' => 'Himakom Logo',
        ],
        'preview' => [
            'path' => 'assets/images/undraw_Upload_re_pasx.png',
            'name' => 'Preview Image',
            'alt' => 'Preview Image',
        ],
        'male_avatar' => [
            'path' => 'assets/avatars/undraw_Pic_profile_re_7g2h.png',
            'name' => 'Avatar',
            'alt' => 'Avatar',
        ],
        'female_avatar' => [
            'path' => 'assets/avatars/undraw_Female_avatar_efig.png',
            'name' => 'Avatar',
            'alt' => 'Avatar',
        ],
        'error' => [
            'path' => 'assets/errors/undraw_void_3ggu.png',
            'name' => 'Error Image',
            'alt' => 'Error Image',
        ],
    ],    
];
