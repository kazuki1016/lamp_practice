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

//POSTされてきた購入番号
$history_id = get_post('history_id');
// POSTされてきたトークン
$token = get_post('token');

//セッションに保管されているトークンがPOSTされたトークンと一致しているか
if (is_valid_csrf_token($token) === false ){
  set_error('不正アクセスです');
  redirect_to(LOGIN_URL);
}

$history_details = get_history_details($db,$history_id);
var_dump($history_details);
$total_price = sum_payment($history_details);

include_once VIEW_PATH . '/history_details_view.php';