<?php
require_once dirname(__FILE__) . '/../model/Model.php';
require_once dirname(__FILE__) . '/../model/Contact.php';
require_once dirname(__FILE__) . '/../model/Administrator.php';

class ServiceModelContainer {
    private $services = [];
    private $instances = [];
    private $mode = [];

    /**
     * モデルのインスタンス生成
     *
     * @param  string $name
     * @param  string $className
     * @param  string $mode
     * @return void
     */
    public function set($name, $className)
    {
        $this->services[$name] = $className;
    }

    public function setMode($name, $mode)
    {
        $this->mode[$name] = $mode;
    }

    /**
     * モデルのインスタンスを取得
     *
     * @param  string $name
     * @return ObjectInstance
     */
    public function get($name)
    {
        if (!isset($this->services[$name])) {
            throw new Exception("Service not found: " . $name);
        }

        if (!isset($this->instances[$name])) {
            if (isset($this->mode[$name]) && 'test' === $this->mode[$name]) {
                $className = new $this->services[$name]();
                $this->instances[$name] = new $className($this->mode[$name]);
            } else {
                $this->instances[$name] = new $this->services[$name]();
            }
        }
        return $this->instances[$name];
    }
}