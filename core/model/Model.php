<?php //データベースアクセス

class Model {

    protected $dbController; //PDOクラスのインスタンス

    /**
    * 指定DBにアクセスする
    * @param string $dbName DB名
    * @param string $userName ユーザ名
    * @param string $password パスワード
    * @return object　PDOクラス
    */
    public function __construct(string $dsn, string $userName, string $password)
    {
        $this->dbController = new PDO($dsn, $userName, $password);
        $this->dbController->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->dbController->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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