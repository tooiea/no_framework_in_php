<?php //データベースアクセス

class DataBase {

    protected $dbController; //PDOクラスのインスタンス

    /**
    * 指定DBにアクセスする
    * @param string $dbName DB名
    * @param string $userName ユーザ名
    * @param string $password パスワード
    * @return object　PDOクラス
    */
    public function __construct(string $dsn, string $userName, string $password, array $option)
    {
        $this->dbController = new PDO($dsn, $userName, $password, $option);
        return $this->dbController;
    }

    /**
     * PDO::トランザクション開始
     * @return void
     */
    public function beginTransaction()
    {
        $this->dbController->beginTransaction();
    }

    /**
     * PDO::コミット
     * @return void
     */
    public function commit()
    {
        $this->dbController->commit();
    }

    /**
     * PDO::ロールバック
     * @return void
     */
    public function rollback()
    {
        $this->dbController->rollback();
    }

    /**
     * PDO::prepare
     * @param string $sql SQL文
     * @return void
     */
    public function prepare($sql)
    {
        $this->dbController->prepare($sql);
    }
}