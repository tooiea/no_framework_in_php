<?php

require_once dirname(__FILE__) . '/../model/Model.php';
require_once dirname(__FILE__) . '/../model/Contact.php';
require_once dirname(__FILE__) . '/../model/Administrator.php';

/**
 * モデルのインスタンス生成クラス
 */
class ServiceModelContainer
{
    private $services = [];
    private $instances = [];
    private $mode = [];

    /**
     * モデルのインスタンス生成
     *
     * @param string $name      インスタンス名
     * @param string $className モデルクラス名
     * 
     * @return void
     */
    public function set($name, $className)
    {
        $this->services[$name] = $className;
    }

    /**
     * 環境を切り替える
     * local        開発環境
     * test         テスト
     * production   本番環境
     *
     * @param string $name インスタンス名
     * @param string $mode モードの指定
     * 
     * @return void
     */
    public function setMode($name, $mode)
    {
        $this->mode[$name] = $mode;
    }

    /**
     * モデルのインスタンスを取得
     *
     * @param string $name インスタンス名
     * 
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
