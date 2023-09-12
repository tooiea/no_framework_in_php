<?php

require_once(dirname(__FILE__) . '/../config/database.php');

class ConnectionDatabase {

    /**
     * 接続先インスタンス
     *
     * @var PDOオブジェクト
     */
    protected $db;

    /**
    * 指定DBにアクセスする
    * @param string $dbName DB名
    * @param string $userName ユーザ名
    * @param string $password パスワード
    * @return object PDOオブジェクト
    */
    public function __construct(string $dsn,string $userName,string $password,array $option) {
        $this->db = new PDO($dsn,$userName,$password,$option);
        return $this->db;
    }

    /**
     * トランザクション開始
     *
     * @return void
     */
    public function beginTransaction() {
        $this->db->beginTransaction();
    }

    /**
     * コミット
     *
     * @return void
     */
    public function commit() {
        $this->db->commit();
    }

    /**
     * ロールバック
     *
     * @return void
     */
    public function rollback() {
        $this->db->rollback();
    }

    /**
     * prepare
     *
     * @param  string $sql
     * @return void
     */
    public function prepare($sql) {
        $this->db->prepare($sql);
    }
}