<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

$carts = get_user_carts($db, $user['user_id']);

// POSTされてきたトークン
$token = get_post('token');

//セッションに保管されているトークンがPOSTされたトークンと一致しているか
if (is_valid_csrf_token($token) === false){
  set_message('不正アクセスです');
  redirect_to(LOGIN_URL);
}

if(purchase_carts($db, $carts) === false){
  set_error('商品が購入できませんでした。');
  redirect_to(CART_URL);
} 

$total_price = sum_carts($carts);

//購入した商品を商品購入履歴に追加
$user_id = $user['user_id'];
if(insert_history($db, $user['user_id'])){
  $history_id = $db->lastInsertId(); 
}

$at_price = $carts('price');
$item_id = $carts('item_id');
$amount = $carts('amount');

if(regist_history($db, $history_id, $at_price, $user_id, $item_id, $amount) === false){
  set_error('商品履歴の追加に失敗');
}

include_once '../view/finish_view.php';