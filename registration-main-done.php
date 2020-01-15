<?php
require('common/db.php');
require_once('common/common.php');

// registration.phpで$post=sanitize($_POST);を実行している

$sqls = $db->prepare('INSERT INTO familydiary(name,birthday,id,password) values ( ?, ?, ?, ? )');

    $date[] = $post['name'];
    $date[] = $post['birthday'];
    $date[] = $post['id'];
    $date[] = password_hash($post['password'],PASSWORD_DEFAULT);
    $sqls->execute($date);
    $db=null;
?>
<div class="registration-page">
  <div class="registration-item">
    <div class="registration-item__top">
      <h2 class="registration-item__top__title">家族日記を使ってみよう</h2>
    </div>
    <div class="registration-item__body">
      <div class="registration-item__body__item">
        <p>登録完了しました！！</p>
      </div>
      <div class="registration-item__body__btn">
        <input class="btn-blue" type="submit" onclick="location.href='login.php'" value="さっそくログイン" />
      </div>
    </div>
  </div>
</div>
