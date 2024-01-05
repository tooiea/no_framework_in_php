<?php declare(strict_types=1);
require_once dirname(__FILE__) . '/../BaseController.php';
require_once dirname(__FILE__) . '/../../../../controller/form/InputController.php';
require_once dirname(__FILE__) . '/../../data/formData.php';

/**
 * @covers InputController
 */
class InputControllerTest extends BaseController {
    /**
     * クラス初期化
     *
     * @return void
     */
    protected function setUp(): void
    {
        if (!isset($_SESSION)) {
            session_start();
            session_regenerate_id(true); //sessionID更新
        }
        $this->instance = new InputController(new Redirector());
    }

    /**
     * インデックス入力パス
     * @covers controller
     *
     * @return void
     */
    public function testIndexPass(): void
    {
        $mockRedirector = $this->createMock(Redirector::class);
        $mockRedirector->expects($this->once())
                       ->method('postRedirectTo')
                       ->with($this->equalTo('/form/confirm/'));
        $this->instance = new InputController($mockRedirector);

        $this->setUpBefore(REQUEST_METHOD_POST, PASS_FORM_DATA, PASS_FORM_DATA);
        $this->assertEmpty($this->instance->index());
    }

    /**
     * インデックス入力エラー
     * @covers controller
     *
     * @return void
     */
    public function testIndexFail(): void
    {
        $this->setUpBefore(REQUEST_METHOD_POST, FAIL_FORM_DATA, FAIL_FORM_DATA);
        $this->assertEmpty($this->instance->index());
    }

    /**
     * Undocumented function
     * @covers controller
     *
     * @return void
     */
    public function testIndexBack():void
    {
        $this->setUpBefore(REQUEST_METHOD_POST, BACK_FORM_DATA, BACK_FORM_DATA);
        $this->assertEmpty($this->instance->index());
    }

    /**
     * 入力値取得
     * @covers controller
     *
     * @return void
     */
    public function testGetValues(): void
    {
        $this->assertEmpty($this->instance->getValues());
    }

    /**
     * エラー取得
     * @covers controller
     *
     * @return void
     */
    public function testGetErrorMsg(): void
    {
        $this->setUpBefore(REQUEST_METHOD_POST, FAIL_FORM_DATA, PASS_FORM_DATA);
        $this->assertEmpty($this->instance->getErrorMsg());
    }
}