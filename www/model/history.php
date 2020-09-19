<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

 // 購入履歴テーブルに登録
 function insert_history($db, $user_id){
  $sql = "
    INSERT INTO
      history(
        user_id
        )
    VALUES(?);
  ";
  return execute_query($db, $sql, array($user_id));
}

// 購入履歴詳細テーブルに登録
function insert_history_details($db, $history_id, $at_price, $item_id, $amount){
  $sql = "
    INSERT INTO
      history_details(
        history_id
        at_price
        item_id 
        amount
    VALUES(?, ?, ?, ?);
  ";
  return execute_query($db, $sql, array($history_id, $at_price, $item_id, $amount));
}

// 購入履歴詳細テーブルから読み込む
function get_history_details($db, $user_id){
  $sql = "
    SELECT
      history.history_id,
      history.user_id,
      history_details.at_price,
      history_details.amount,
      items.item_id,
      items.name
    FROM
      ((history_details 
    JOIN 
      history 
    ON 
      history.history_id = history_details.history_id)
    JOIN 
      items 
    ON 
      history_details.item_id = items.item_id)
    WHRER 
      history.user_id = ?
  ";
  return fetch_all_query($db, $sql, array($user_id));
}

// 購入履歴と詳細間でトランザクション
function regist_history($db, $history_id, $price, $user_id, $item_id, $amount){
  $db->beginTransaction();
  if(insert_history($db, $user_id) && insert_history_details($db, $history_id, $at_price, $item_id, $amount)){
    $db->commit();
    return true;
  } else{
    $db->rollback();
    return false;
  }
}

// 
// function is_open($item){
//   return $item['status'] === 1;
// }
?>