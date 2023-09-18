<?php

require_once(dirname(__FILE__) . '/../config/database.php');

class Model extends PDO {

    // PDOクラスのインスタンス
    protected $dbInstance;

    // 接続先テーブル名
    protected $table = '';

    // 接続先
    protected $connection = CONNECTION_DATABASE_DEFAULT;

    // オプション
    protected $option = [
        PDO::ERRMODE_EXCEPTION, PDO::ERRMODE_WARNING
    ];

    protected $columns = [
        // 'name1'
    ];

    protected $bindList = [
            // 'name1' => ':name1',
    ];

    /**
     * 指定DBにアクセスする
     *
     * return PDOインスタンス
     */
    public function __construct() {
        return new PDO($this->getConnection($this->connection), $this->connection['user'], $this->connection['password'], $this->option);
    }

    /**
     * 接続先の設定
     *
     * @param  array $connection
     * @return string
     */
    private function getConnection($connection)
    {
        $dbName = 'mysql:dbname=' . $connection['db_name'] . ';';
        $host = 'host=' . $connection['host'] . ';';
        $charset = 'charset=' . $connection['charset'] . ';';
        $port = 'port=' . $connection['port'] . ';';
        return $dbName . $host . $charset . $port;
    }
}