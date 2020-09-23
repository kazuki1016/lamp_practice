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
        history_id,
        at_price,
        item_id,
        amount
      )
    VALUES(?, ?, ?, ?);
  ";
  return execute_query($db, $sql, array($history_id, $at_price, $item_id, $amount));
}

// 購入履歴詳細テーブルから読み込む
//subtotal = 商品ごとの小計
function get_historys($db, $user_id){
  if($user_id !== 4){
    $where = ' WHERE history.user_id = ? ';
  } else  {
    $where = '';
  }
  $sql = "
  SELECT 
    history.history_id,
    history.create_datetime,
  SUM( history_details.at_price*history_details.amount) AS total

  FROM
    history
  JOIN
    history_details
  ON
	history.history_id = history_details.history_id
  {$where}
  GROUP BY
 	  history_id
  ";
  if($user_id !== 4){ //管理者ユーザーでなければ自身の履歴しかみれない
    return fetch_all_query($db, $sql, array($user_id));
  } else {
    return fetch_all_query($db, $sql, array());
  }
}

function get_history_details($db, $history_id){
  $sql = "
    SELECT
      history.history_id,
      history.user_id,
      history_details.at_price,
      history_details.amount,
      history_details.history_details_id,
      items.item_id,
      items.name,
      (history_details.at_price * history_details.amount) AS subtotal
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
    WHERE 
      history.history_id = ?
  ";
  return fetch_all_query($db, $sql, array($history_id));
}

