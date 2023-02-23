<?php

namespace App;

/**
 * Smth like service locator + array syntax
 */
class AppContainer implements \ArrayAccess
{
    /**
     * Hold the class instance.
     *
     * @var static $instance
     */
    private static $instance = null;

    /**
     * @var array Array to store application data
     */
    private $container = [];

    /**
     * This class is singleton
     */
    private function __construct() {
        /**
         * Init default data
         */
        $this->container['routes'] = require ROOT_DIR . '/app/routes.php';

        try {
            $this->container['db_conn'] = new \PDO("mysql:host=localhost;dbname=markelov", 'root', '');
        } catch(\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die;
        }
    }

    /**
     * @return static
     */
    public static function instance() : self
    {
        if (self::$instance == null)
        {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
}
