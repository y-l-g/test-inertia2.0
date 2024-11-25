<?php

return [

    'ssr' => [
        'enabled' => true,
        'url' => 'http://ssr:13714',
    ],

    'testing' => [

        'ensure_pages_exist' => true,

        'page_paths' => [

            resource_path('js/Pages'),

        ],

        'page_extensions' => [

            'js',
            'jsx',
            'svelte',
            'ts',
            'tsx',
            'vue',

        ],

    ],

    'history' => [

        'encrypt' => false,

    ],

];
