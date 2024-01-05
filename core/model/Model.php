<?php //データベースアクセス
require_once dirname(__FILE__) . '/../config/database.php';
require_once dirname(__FILE__) . '/../util/AppEnvController.php';

class Model {

    protected $dbController; //PDOクラスのインスタンス

    /**
    * 指定DBにアクセスする
    * @return object　PDOクラス
    */
    public function __construct($mode = null)
    {
        $pdoAccessInfo = $this->getAccessInformation(new AppEnvController($mode));
        $this->dbController = new PDO($pdoAccessInfo['dsn'], $pdoAccessInfo['user_name'], $pdoAccessInfo['password']);
        $this->dbController->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->dbController->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->dbController;
    }

    /**
     * アクセス情報をAppEnvから取得する
     *
     * @return void
     */
    private function getAccessInformation($appEnv)
    {
        $pdoAccessInfo = [];
        $env = $appEnv->getAppEnv();
        $accessInfo = ACCESS_INFO[$env];

        // PDOへのアクセス情報
        $pdoAccessInfo['dsn'] = 'mysql:dbname=' . $accessInfo['db_name'] . ';host=' . $accessInfo['host_name'] . ';charset=utf8';
        $pdoAccessInfo['user_name'] = $accessInfo['user_name'];
        $pdoAccessInfo['password'] = $accessInfo['password'];
        return $pdoAccessInfo;
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