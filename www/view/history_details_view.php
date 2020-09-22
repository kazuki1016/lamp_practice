<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴詳細</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <div class="container">
  <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <h1>購入履歴詳細一覧</h1>
    <table class="table table-bordered text-center">
        <thead class="thead-light">
          <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>合計金額</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($history_details as $history_detail){ ?>
          <tr>
            <td><?php print h($history_detail['history_id']);?></td>
            <td><?php print h($history_detail['create_datetime']); ?></td>
            <td><?php print h(number_format($total_price)); ?>円</td>
          </tr>
          <?php } ?>
    </table>

    <table class="table table-bordered text-center">
      <thead class="thead-light">
        <tr>
          <th>商品名</th>
          <th>購入価格</th>
          <th>購入数</th>
          <th>小計</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($history_details as $history_detail){ ?>
        <tr>
          <td><?php print h($history_detail['name']);?></td>
          <td><?php print h($history_detail['at_price']); ?>円</td>
          <td><?php print h($history_detail['amount']); ?>個</td>
          <td><?php print h(number_format($history_detail['subtotal'])); ?>円</td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>
</html>