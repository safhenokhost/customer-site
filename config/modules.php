<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Available modules (config-based activation per installation)
    |--------------------------------------------------------------------------
    | Each module has a key, optional label, and env variable for activation.
    | Set MODULE_* to true/false in .env to enable/disable per installation.
    */

    'modules' => [
        'blog' => [
            'name' => 'وبلاگ',
            'env' => 'MODULE_BLOG_ENABLED',
            'default' => true,
        ],
        'shop' => [
            'name' => 'فروشگاه',
            'env' => 'MODULE_SHOP_ENABLED',
            'default' => false,
        ],
    ],

];
