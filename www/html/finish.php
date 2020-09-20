<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'history.php';

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

//商品の購入〜履歴追加までトランザクション
$i = 0;

$db->beginTransaction();
try{
  if(purchase_carts($db, $carts) === false){
    set_error('商品が購入できませんでした。');
    redirect_to(CART_URL);
  }
  while($i < count($carts)){
    $at_price = $carts[$i]['price'];
    $item_id = $carts[$i]['item_id'];
    $amount = $carts[$i]['amount'];
    if(insert_history($db, $user['user_id'])===false){
      set_error('商品履歴の追加に失敗');
    }
    $history_id = $db->lastInsertId();
    if(insert_history_details($db, $history_id, $at_price, $item_id, $amount) === false){
      set_error('商品詳細履歴の追加に失敗');
    }
    $i++;
  } 
  $db->commit();
}catch (PDOException $e) {
  $db->rollback();
  throw $e;
}
$total_price = sum_carts($carts);


include_once '../view/finish_view.php';