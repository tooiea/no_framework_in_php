<?php declare(strict_types=1);
require_once dirname(__FILE__) . '/BaseModel.php';
require_once dirname(__FILE__) . '/../../../model/Administrator.php';
require_once dirname(__FILE__) . '/../../../const/sql.php';

/**
 * @covers Contact
 */
class AdministratorTest extends BaseModel
{
    /**
     * クラス初期化
     *
     * @return void
     */
    public function setUp(): void
    {
        // エラーオプションの上書き
        $this->setUpBefore();

        // 対象モデルをインスタンス化
        $this->instance = new Administrator(DB_ACCESS_INFO, USER_NAME, PASSWORD);
    }

    /**
     * ユーザ取得
     * @covers Model
     * @covers Administrator
     *
     * @return void
     */
    public function testSelect(): void
    {
        $this->assertIsArray($this->instance->select(ADMIN_USER_PASSWORD));
    }

    /**
     * ログイン後更新
     * @covers Model
     * @covers Administrator
     *
     * @return void
     */
    public function testUpdate(): void
    {
        $this->assertEmpty($this->instance->update(ADMIN_USER_PASSWORD));
    }

    /**
     * ログイン後更新
     * @covers Model
     * @covers Administrator
     *
     * @return void
     */
    public function testCheckUser(): void
    {
        $this->assertIsArray($this->instance->checkUser(ADMIN_LOGIN_ID));
    }
}