<?php

return [
    'user'    => [
        'activation' => [
            'enabled'      => true,
            'valid_hours'  => 2,
            'max_attempts' => 5,
        ]
    ],
    'dataset' => [
        'max_allowed_files' => env('MAX_ALLOWED_FILES', 20)
    ],
];