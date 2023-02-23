<?php

ini_set('display_errors', 'on');
ini_set('display_startup_errors', true);

define('ROOT_DIR', __DIR__);

/**
 * Define request methods constants
 */
define('REQUEST_METHOD_GET', 'GET');
define('REQUEST_METHOD_POST', 'POST');

require_once ROOT_DIR . '/app/app.php';
