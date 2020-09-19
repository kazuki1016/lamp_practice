-- 購入履歴画面用のテーブル
CREATE TABLE history(
  history_id INT(11) NOT NULL AUTO_INCREMENT,  -- 購入履歴ID→注文番号
  user_id INT(11) NOT NULL, -- 顧客番号→ログインしている人を特定するため
  create_datetime DATETIME, -- 購入時間がわかる
  PRIMARY KEY(history_id)
)

-- 購入明細画面用のテーブル
CREATE TABLE history_details(
  history_details_id INT(11) NOT NULL AUTO_INCREMENT, 
  history_id INT(11) NOT NULL, -- 購入履歴ID　
  at_price INT DEFAULT 0, -- 購入時の値段
  item_id INT(11) NOT NULL, -- アイテムID→何を購入したか特定するため
  amount INT(11) NOT NULL,  -- 購入数がわかる
  PRIMARY KEY(history_details_id)
)