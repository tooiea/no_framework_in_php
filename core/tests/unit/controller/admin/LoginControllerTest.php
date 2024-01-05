<?php declare(strict_types=1);
require_once dirname(__FILE__) . '/../BaseController.php';
require_once dirname(__FILE__) . '/../../../../controller/admin/LoginController.php';
require_once dirname(__FILE__) . '/../../../../service/ServiceModelContainer.php';
require_once dirname(__FILE__) . '/../../data/formData.php';

/**
 * @covers LoginController
 */
class LoginControllerTest extends BaseController {
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
        $this->instance = new LoginController(new Redirector(), new ServiceModelContainer());
    }

    /**
     * インデックスパス
     * @covers Administrator
     * @covers Controller
     * @covers Model
     *
     * @return void
     */
    public function testIndexPass(): void
    {
        $mockRedirector = $this->createMock(Redirector::class);
        $mockRedirector->expects($this->once())
                       ->method('getRedirectTo')
                       ->with($this->equalTo('/admin/list'));
        $this->instance = new LoginController($mockRedirector, new ServiceModelContainer(), new ServiceModelContainer());

        $this->setUpBefore(REQUEST_METHOD_POST, [], ADMIN_LOG_IN_INFO_PASS);
        $this->assertEmpty($this->instance->index());
    }

    /**
     * インデックス:パスワード違い
     * @covers Administrator
     * @covers Controller
     * @covers Model
     *
     * @return void
     */
    public function testIndexFail(): void
    {
        $this->setUpBefore(REQUEST_METHOD_POST, [], ADMIN_LOG_IN_INFO_FAIL);
        $this->assertEmpty($this->instance->index());
    }

    /**
     * インデックス:ユーザなし
     * @covers Administrator
     * @covers Controller
     * @covers Model
     *
     * @return void
     */
    public function testIndexFail2(): void
    {
        $this->setUpBefore(REQUEST_METHOD_POST, [], ADMIN_LOG_IN_INFO_FAIL2);
        $this->assertEmpty($this->instance->index());
    }

    /**
     * インデックス入力パス
     * @covers controller
     *
     * @return void
     */
    public function testIndexIsLoggedin(): void
    {
        $mockRedirector = $this->createMock(Redirector::class);
        $mockRedirector->expects($this->once())
                       ->method('getRedirectTo')
                       ->with($this->equalTo('/admin/list'));
        $this->instance = new LoginController($mockRedirector, new ServiceModelContainer(), new ServiceModelContainer());

        $this->setUpBefore(REQUEST_METHOD_GET, ADMIN_SESSION_LOGIN_ID, []);
        $this->assertEmpty($this->instance->index());
    }

    /**
     * インデックス入力パス
     * @covers controller
     *
     * @return void
     */
    public function testPDOException(): void
    {
        $mockRedirector = $this->createMock(Redirector::class);
        $mockRedirector->expects($this->once())
                       ->method('getRedirectTo')
                       ->with($this->equalTo('/admin/list'));

        // サービスコンテナモック
        $mockAdministrator = $this->createMock(ConfirmController::class);
        $container = new ServiceModelContainer();
        $container->setMode('administrator', 'test');
        $container->set('administrator', function() use ($mockAdministrator) {
            return $mockAdministrator;
        });

        $this->instance = new LoginController($mockRedirector, $container, new ServiceModelContainer());
        $this->setUpBefore(REQUEST_METHOD_POST, ADMIN_SESSION_LOGIN_ID, ADMIN_LOG_IN_INFO_PASS);
        $this->assertEmpty($this->instance->index());
    }

    /**
     * インデックス入力パス
     * @covers controller
     *
     * @return void
     */
    public function testException(): void
    {
        $this->setUpBefore(REQUEST_METHOD_GET, SESSION_FORM_DATA_FAIL, ADMIN_LOG_IN_INFO_PDOEXCEPTION);
        $this->assertEmpty($this->instance->index());
    }

    /**
     * メッセージ取得
     * @covers Controller
     *
     * @return void
     */
    public function testGetMessage(): void
    {
        $this->assertEmpty($this->instance->getMessage());
    }

    /**
     * エラーメッセージ取得
     * @covers Controller
     *
     * @return void
     */
    public function testGetErrorMsg(): void
    {
        $this->assertEmpty($this->instance->getErrorMsg());
    }
}