<?php

/**
 * Simple routes map to resolve controller for request execution
 */


return [
    REQUEST_METHOD_GET => [
        '/' => [
            'controller' => \App\Controllers\HomeController::class,
            'method' => 'index',
        ],
    ],

    REQUEST_METHOD_POST => [
        '/save-form' => [
            'controller' => \App\Controllers\ProcessFormController::class,
            'method' => 'storeFormData',
        ],
    ],
];
