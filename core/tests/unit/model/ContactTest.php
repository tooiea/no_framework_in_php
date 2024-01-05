<?php declare(strict_types=1);
require_once dirname(__FILE__) . '/BaseModel.php';
require_once dirname(__FILE__) . '/../../../model/Contact.php';
require_once dirname(__FILE__) . '/../../../const/sql.php';

/**
 * @covers Contact
 */
class ContactTest extends BaseModel
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
        $this->instance = new Contact();
    }

    /**
     * @covers Model
     * @covers Contact
     *
     * @return void
     */
    public function testInsert(): void
    {
        $this->assertIsBool($this->instance->insert(INSERT_DATA));
    }

    /**
     * Undocumented function
     * @covers Model
     *
     * @return void
     */
    public function testCheckNumberOfDataInitial(): void
    {
        $this->assertNotEmpty($this->instance->checkNumberOfDataInitial());
    }

    /**
     * 件数取得1
     * @covers Model
     *
     * @return void
     */
    public function testCheckNumberOfData(): void
    {
        $this->assertIsInt($this->instance->checkNumberOfData([]));
    }

    /**
     * 件数取得2
     * @covers Model
     *
     * @return void
     */
    public function testCheckNumberOfData2(): void
    {
        $this->assertIsInt($this->instance->checkNumberOfData(ADMIN_FORM_QUERY_VALUES));
    }

    /**
     * データ取得1
     * @covers Model
     *
     * @return void
     */
    public function testSelect(): void
    {
        $this->assertIsArray($this->instance->select(1, []));
    }

    /**
     * データ取得2
     * @covers Model
     *
     * @return void
     */
    public function testSelect2(): void
    {
        $this->assertIsArray($this->instance->select(2, ADMIN_FORM_QUERY_VALUES));
    }

    /**
     * 詳細データ取得
     * @covers Model
     *
     * @return void
     */
    public function testSelectDetailContents(): void
    {
        $this->assertIsArray($this->instance->selectDetailContents(6));
    }
}