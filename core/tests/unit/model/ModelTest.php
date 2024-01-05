<?php declare(strict_types=1);
require_once dirname(__FILE__) . '/BaseModel.php';
require_once dirname(__FILE__) . '/../../../model/Model.php';
require_once dirname(__FILE__) . '/../../../const/sql.php';

/**
 * @covers model
 */
class ModelTest extends BaseModel
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
        $this->instance = new Model(DB_ACCESS_INFO, USER_NAME, PASSWORD);
    }

    /**
     * トランザクション
     * @covers Model
     * @group model
     *
     * @return void
     */
    public function testTransaction(): void
    {
        $this->assertNull($this->instance->beginTransaction());
    }

    /**
     * プリペア
     * @covers Model
     * @group model
     *
     * @return void
     */
    public function testPrepare():void
    {
        $this->instance->beginTransaction();
        $this->assertNull($this->instance->prepare(SELECT_CONTACT_LIST_INITIAL));
    }

    /**
     * ロールバック
     * @covers Model
     * @group model
     *
     * @return void
     */
    public function testRollback(): void
    {
        $this->instance->beginTransaction();
        $this->instance->prepare(SELECT_CONTACT_LIST_INITIAL);
        $this->assertNull($this->instance->rollback());
    }

    /**
     * コミット
     * @covers Model
     * @group model
     *
     * @return void
     */
    public function testCommit(): void
    {
        $this->instance->beginTransaction();
        $this->assertNull($this->instance->commit());
    }
}