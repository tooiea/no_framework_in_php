<?php declare(strict_types=1);
require_once dirname(__FILE__) . '/../BaseController.php';
require_once dirname(__FILE__) . '/../../../../controller/form/CompleteController.php';
require_once dirname(__FILE__) . '/../../data/formData.php';

/**
 * @covers CompleteController
 */
class CompleteControllerTest extends BaseController
{
    /**
     * クラス初期化
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->instance = new CompleteController(new Redirector());
        if (!isset($_SESSION)) {
            session_start();
            session_regenerate_id(true); //sessionID更新
        }
    }

    /**
     * インデックス入力パス
     * @covers Controller
     * @covers Model
     * @covers Contact
     *
     * @return void
     */
    public function testIndexPass(): void
    {
        $this->setUpBefore(REQUEST_METHOD_POST, SESSION_FORM_DATA, []);
        $this->assertIsArray($this->instance->index());
    }

    /**
     * インデックス入力エラー
     * @covers Controller
     *
     * @return void
     */
    public function testIndexFail(): void
    {
        $mockRedirector = $this->createMock(Redirector::class);
        $mockRedirector->expects($this->once())
                       ->method('getRedirectTo')
                       ->with($this->equalTo('/form/'));
        $this->instance = new CompleteController($mockRedirector);

        $this->setUpBefore(REQUEST_METHOD_POST, [], []);
        $this->assertNotEmpty($this->instance->index());
    }

    /**
     * インデックス入力エラー
     * @covers Controller
     * @covers Contact
     * @covers Model
     *
     * @return void
     */
    public function testIndexFailMail(): void
    {
        $this->setUpBefore(REQUEST_METHOD_POST, SESSION_FORM_DATA, []);
        $this->assertNotEmpty($this->instance->index());
    }

    /**
     * @covers Controller
     * @covers Contact
     * @covers Model
     *
     * @return void
     */
    public function testPDOException(): void
    {
        // TODO 要修正
        $this->expectException(PDOEXception::class);
        $this->setUpBefore(REQUEST_METHOD_POST, SESSION_FORM_DATA, []);
        $this->instance->index();
    }

    /**
     * Undocumented function
     * @covers Controller
     *
     * @return void
     */
    public function testConvertValue1(): void
    {
        $this->assertNotEmpty($this->instance->convertValue(PASS_FORM_DATA, DB_CONTACT_INFO_ITEM));
    }

    /**
     * Undocumented function
     * @covers Controller
     *
     * @return void
     */
    public function testConvertValue2(): void
    {
        $this->assertNotEmpty($this->instance->convertValue(PASS_FORM_DATA2, DB_CONTACT_INFO_ITEM));
    }
}