<?php

require_once ROOT_DIR . '/vendor/autoload.php';

/**
 * Client code are processing request
 */
$request = $_REQUEST;

if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
    $json = file_get_contents('php://input');

    if (strlen($json)) {
        $json_req = json_decode($json, true);

        if (is_array($json_req)) {
            $request = array_merge($request, $json_req);
        }
    }
}

/**
 * Set db to ORM
 */
ItvisionSy\SimpleORM\DataModel::useConnection(\App\AppContainer::instance()['db_conn']);

$controller_resolver = new \App\ControllersResolver($request, $_SERVER);

$callable = $controller_resolver->resolveRoute();

if (is_callable($callable)) {
    call_user_func($callable);
} else {
    throw new HttpRequestException('Wrong data passed in request');
}
