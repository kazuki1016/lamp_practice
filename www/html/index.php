<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);
// トークンの生成
$token = get_csrf_token();
// GETされたデータ（並び替え）
$order_value = get_get('order');
var_dump($order_value);
$items = get_open_items($db);

if($order_value === "cheap_order"){
  $items = cheap_order_items($db);
} else if($order_value === "expensive_order"){
  $items = expensive_order_items($db);
}


var_dump($items);


include_once VIEW_PATH . 'index_view.php';