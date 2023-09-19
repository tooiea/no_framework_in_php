<?php

require_once(dirname(__FILE__) . '/../config/database.php');

class Model {

    // PDOクラスのインスタンス
    protected $dbInstance;

    // 接続先テーブル名
    protected $table = '';

    // 接続先
    protected $connection = CONNECTION_DATABASE_DEFAULT;

    // オプション
    protected $option = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
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
    public function __construct()
    {
        $this->dbInstance = new PDO($this->getConnection($this->connection), $this->connection['user'], $this->connection['password'], $this->option);
        return $this->dbInstance;
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


    /**
     * PDO::トランザクション開始
     * @return void
     */
    public function beginTransaction() {
        $this->dbInstance->beginTransaction();
    }

    /**
     * PDO::コミット
     * @return void
     */
    public function commit() {
        $this->dbInstance->commit();
    }

    /**
     * PDO::ロールバック
     * @return void
     */
    public function rollback() {
        $this->dbInstance->rollback();
    }

    /**
     * PDO::prepare
     * @param  string $sql SQL文
     * @return object
     */
    public function prepare($sql) {
        return $this->dbInstance->prepare($sql);
    }
}