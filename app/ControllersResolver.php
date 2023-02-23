<?php

namespace App;

use App\Controllers\Controller;

class ControllersResolver
{
    private $request;

    private $server;

    public function __construct(array $request = [], array $server = [])
    {
        $this->setRequest($request);
        $this->setServer($server);
    }

    /**
     * @param array $request
     */
    public function setRequest(array $request)
    {
        $this->request = $request;
    }

    /**
     * @param array $server
     */
    public function setServer(array $server)
    {
        $this->server = $server;
    }

    /**
     * Resolve application route
     *
     * @return callable
     */
    public function resolveRoute() : callable
    {
        $service_locator = AppContainer::instance();

        $error_callable = function () {
            header('HTTP/1.0 404 Not Found');
            echo 'Such route was not found. Try harder.';
        };

        if (empty($this->server['REQUEST_METHOD']) || empty($service_locator['routes'][$this->server['REQUEST_METHOD']])) {
            return $error_callable;
        }

        if (empty($this->server['REQUEST_URI'])
            || empty($service_locator['routes'][$this->server['REQUEST_METHOD']][$this->server['REQUEST_URI']])
        ) {
            return $error_callable;
        }

        $class_name = $service_locator['routes'][$this->server['REQUEST_METHOD']][$this->server['REQUEST_URI']]['controller'];
        $method = $service_locator['routes'][$this->server['REQUEST_METHOD']][$this->server['REQUEST_URI']]['method'];

        if (!(class_exists($class_name)
            && is_subclass_of($class_name, Controller::class)
            && method_exists($class_name, $method))
        ) {
            return $error_callable;
        }

        $controller = new $class_name();

        $controller
            ->setRequest($this->request)
            ->setServer($this->server);

        return function () use ($controller, $method) {
            return $controller->$method();
        };
    }
}
