<?php declare(strict_types=1);
require_once dirname(__FILE__) . '/../BaseController.php';
require_once dirname(__FILE__) . '/../../../../controller/form/ConfirmController.php';
require_once dirname(__FILE__) . '/../../data/formData.php';

/**
 * @covers ConfirmController
 */
class ConfirmControllerTest extends BaseController
{
    /**
     * クラス初期化
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->instance = new ConfirmController(new Redirector());
        if (!isset($_SESSION)) {
            session_start();
            session_regenerate_id(true); //sessionID更新
        }
    }

    /**
     * インデックス入力パス
     * @covers Controller
     *
     * @return void
     */
    public function testIndexPass(): void
    {
        $this->setUpBefore(REQUEST_METHOD_POST, SESSION_FORM_DATA, SESSION_FORM_DATA);
        $this->assertNotEmpty($this->instance->index());
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
        $this->instance = new ConfirmController($mockRedirector);

        $this->setUpBefore(REQUEST_METHOD_GET, SESSION_FORM_DATA, []);
        $this->assertEmpty($this->instance->index());
    }
}