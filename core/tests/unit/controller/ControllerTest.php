<?php declare(strict_types=1);
require_once dirname(__FILE__) . '/BaseController.php';
require_once dirname(__FILE__) . '/../data/formData.php';

/**
 * @covers ControllerTest
 */
class ControllerTest extends BaseController {
    /**
     * クラス初期化
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->instance = new Controller(new Redirector());
    }

    /**
     * 
     * @covers Controller
     *
     * @return void
     */
    public function testRemoveKey(): void
    {
        $this->assertIsArray($this->instance->removeKey(QUERY_PARAMETER_INCLUDE_OTHER));
    }
}