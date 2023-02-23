<?php

namespace App\Controllers;

class Controller
{
    protected $need_auth = false;

    protected $request;

    protected $server;

    /**
     * Set request for further processing
     *
     * @param array $request
     * @return $this
     */
    public function setRequest(array $request) : Controller
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Set server data for further processing
     *
     * @param array $server
     * @return $this
     */
    public function setServer(array $server) : Controller
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Request validation
     *
     * @return array|bool Validated request or false if request was wrong
     */
    public function validateRequest()
    {
        if ($this->need_auth) {
            /**
             * Auth checking
             */
            if (empty($this->server['PHP_AUTH_USER'])
                || empty($this->server['PHP_AUTH_PW'])

                || $this->server['PHP_AUTH_USER'] != 'username'
                || $this->server['PHP_AUTH_PW'] != 'pass'
            ) {
                return false;
            }
        }

        return $this->request;
    }
}
