<?php
// セッション開始
if (!isset($_SESSION)) {
    session_start();
    session_regenerate_id(true); //sessionID更新
}

// リクエストURIを取り出す
$str = urldecode($_SERVER['REQUEST_URI']);

// トレイリングスラッシュを削除
$url= rtrim(parse_url($str)['path'], "/");

// リクエストURIからテンプレート読み込みを決定
switch ($url) {
    case '/form':
        include(dirname(__FILE__) . '/../core/template/form/input_template.php');
        break;
    case '/form/confirm':
        include(dirname(__FILE__) . '/../core/template/form/confirm_template.php');
        break;
    case '/form/complete':
        include(dirname(__FILE__) . '/../core/template/form/complete_template.php');
        break;
    case '/':
        header("Location: /form");
        exit;
    case '/admin':
        header("Location: /admin/login");
        exit;
    case '/admin/login':
        include(dirname(__FILE__).'/../core/template/admin/login_template.php');
        break;
    case '/admin/list':
        include(dirname(__FILE__).'/../core/template/admin/list_template.php');
        break;
    case '/admin/detail':
        include(dirname(__FILE__).'/../core/template/admin/detail_template.php');
        break;
    default:
       include(dirname(__FILE__).'/../core/template/error/error_template.php');
}