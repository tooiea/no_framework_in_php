<?php

require_once(dirname(__FILE__) . '/../error/RouteException.php');

class RouteController {

    /**
     * 使用するルーティングを追加
     */
    private const ROUTES = [
        '/form/' => [
            'method' => ['GET', 'POST'],
            'controller' => 'FormController',
            'function' => 'index'
        ],
        '/form/confirm/' => [
            'method' => ['POST'],
            'controller' => 'FormController',
            'function' => 'confirm'
        ],
        '/form/complete/' => [
            'method' => ['POST'],
            'controller' => 'FormController',
            'function' => 'complete'
        ],
        '/admin/login/' => [
            'method' => ['GET', 'POST'],
            'controller' => '/admin/LoginController',
            'function' => 'complete'
        ],
        '/admin/list/' => [
            'method' => ['GET'],
            'controller' => '/admin/SearchUserController',
            'function' => 'userList'
        ],
        '/admin/detail/' => [
            'method' => ['GET'],
            'controller' => '/admin/SearchUserController',
            'function' => 'userDetail'
        ],
    ];

    /**
     * ルーティングを特定しコントローラと関数を呼び出し実行する
     *
     * @return void
     */
    public static function getExecController()
    {
        try {
            $requestUri = $_SERVER['REQUEST_URI'];
            $requestMethod = $_SERVER['REQUEST_METHOD'];

            foreach (self::ROUTES as $key => $route) {
                if ($requestUri === $key && in_array($requestMethod, $route['method'])) {
                    $controllerName = $route['controller'];
                    $functionName = $route['function'];

                    return self::executeController($controllerName, $functionName);
                }
            }

            throw new RouteException;
        } catch (RouteException $re) {
            header("HTTP/1.1 404 Not Found");
            include(dirname(__FILE__) . '/../view/error/404.php');
            exit;
        }
        //  catch (\Throwable $th) {
        //     header("HTTP/1.1 500 server error");
        //     include(dirname(__FILE__) . '/../view/error/500.php');
        //     exit;
        // }
    }

    /**
     * コントローラと関数を実行する
     *
     * @param string $controllerName
     * @param string $functionName
     * @return void
     */
    private static function executeController($controllerName, $functionName)
    {
        require_once(dirname(__FILE__) . '/../controller/' . $controllerName . '.php');
        $controller = new $controllerName();
        return $controller->$functionName();
    }
}