<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <div class="container">
  <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <h1>購入履歴一覧</h1>
      <table class="table table-bordered text-center">
        <thead class="thead-light">
          <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>合計金額</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($historys as $history){ ?>
          <tr>
            <td><?php print h($history['history_id']);?></td>
            <td><?php print h($history['create_datetime']); ?></td>
            <td><?php print h(number_format($history['total'])); ?>円</td>
            <td>
              <form method="post" action="history_details.php">
                <div class="form-group">
                  <input type="submit" name="details" value="詳細" class="btn btn-secondary">
                </div>
                <input type="hidden" name="history_id" value="<?php print h($history['history_id']); ?>">
                <input type="hidden" name="create_datetime" value="<?php print h($history['create_datetime']); ?>">
                <input type="hidden" name="total" value="<?php print h($history['total']); ?>">
                <input type="hidden" name ="token"  value="<?php print h($token);?>" >
              </form>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
  </div>
</body>
</html>