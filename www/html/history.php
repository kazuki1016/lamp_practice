<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'history.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}


// トークンの生成
$token = get_csrf_token();

$historys = get_historys($db,$user['user_id']);
var_dump($historys);
$total_price = sum_payment($historys);
var_dump($total_price);

include_once VIEW_PATH . '/history_view.php';
