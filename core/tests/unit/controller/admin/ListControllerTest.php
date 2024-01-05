<?php declare(strict_types=1);
require_once dirname(__FILE__) . '/../BaseController.php';
require_once dirname(__FILE__) . '/../../../../controller/admin/ListController.php';
require_once dirname(__FILE__) . '/../../data/formData.php';

/**
 * @covers ListController
 */
class ListControllerTest extends BaseController {
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
        $this->instance = new ListController(new Redirector(), new ServiceModelContainer(), new ServiceModelContainer());
    }

    /**
     * コントローラ内の関数を実行する前にセット
     *
     * @param  GETパラメータ $getParam
     * @param  セッション $session
     * @param  decode用クエリパラメータ $queryParam
     * @return void
     */
    public function setUpBefore($getParam, $session, $queryParam): void
    {
        // warningもエラーとして出力する
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            $msg  = 'Error #' . $errno . ': ';
            $msg .= $errstr . " on line " . $errline . " in file " . $errfile;
            throw new RuntimeException($msg);
        });

        // テスト用入力値のセット
        $_GET = $getParam;
        $_SERVER['QUERY_STRING'] = $queryParam;
        $_SESSION = $session;
    }

    /**
     * インデックスパス
     * @covers Administrator
     * @covers Controller
     * @covers Model
     * @covers Contact
     *
     * @return void
     */
    public function testIndexPass(): void
    {
        $this->setUpBefore(GET_QUERY_PARMATER, ADMIN_SESSION_LOGIN_ID, QUERY_STRING);
        $this->assertIsArray($this->instance->index());
    }

    /**
     * インデックスデータなし
     * @covers Administrator
     * @covers Controller
     * @covers Model
     * @covers Contact
     *
     * @return void
     */
    public function testIndexNoData(): void
    {
        $this->setUpBefore(GET_QUERY_PARMATER, ADMIN_SESSION_LOGIN_ID, QUERY_STRING_NOT_EXISTS);
        $this->assertIsArray($this->instance->index());
    }

    /**
     * 存在しないセッションIDセット
     * @covers Administrator
     * @covers Controller
     * @covers Model
     *
     * @return void
     */
    public function testIndexNoSessionID(): void
    {
        $mockRedirector = $this->createMock(Redirector::class);
        $mockRedirector->expects($this->once())
                       ->method('getRedirectTo')
                       ->with($this->equalTo('/admin/login'));
        $this->instance = new ListController($mockRedirector, new ServiceModelContainer(), new ServiceModelContainer());

        $this->setUpBefore([], [], QUERY_STRING);
        $this->assertIsArray($this->instance->index());
    }

    /**
     * 存在しないユーザ
     * @covers Administrator
     * @covers Controller
     * @covers Model
     * @covers Contact
     *
     * @return void
     */
    public function testIndexNotExistUser(): void
    {
        $mockRedirector = $this->createMock(Redirector::class);
        $mockRedirector->expects($this->once())
                       ->method('getRedirectTo')
                       ->with($this->equalTo('/admin/login'));
        $this->instance = new ListController($mockRedirector, new ServiceModelContainer(), new ServiceModelContainer());

        $this->setUpBefore([], ADMIN_SESSION_LOGIN_ID_FAIL, QUERY_STRING);
        $this->assertIsArray($this->instance->index());
    }

    /**
     * 
     * @covers Controller
     * @covers Contact
     * @covers Model
     *
     * @return void
     */
    public function testPDOException(): void
    {
        // サービスコンテナモック
        $mockAdministrator = $this->createMock(Administrator::class);
        $container = new ServiceModelContainer();
        $container->setMode('administrator', 'test');
        $container->set('administrator', function() use ($mockAdministrator) {
            return $mockAdministrator;
        });

        $this->instance = new ListController(new Redirector(), $container, new ServiceModelContainer());
        $this->setUpBefore(GET_QUERY_PARMATER, ADMIN_SESSION_LOGIN_ID_PDOEXCEPTION, QUERY_STRING);
        $this->assertIsArray($this->instance->index());
    }

    /**
     * 
     * @covers Controller
     * @covers Contact
     * @covers Model
     * @covers Administrator
     *
     * @return void
     */
    public function testException(): void
    {
        $this->setUpBefore(GET_QUERY_PARMATER, ADMIN_SESSION_LOGIN_ID, QUERY_STRING_EXCEPTION);
        $this->assertIsArray($this->instance->index());
    }
}