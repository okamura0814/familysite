<?php

require('common/db.php');

try{
  require_once('common/common.php');
  // サニタイズ
  $post=sanitize($_POST);

  $post_id = $post['id'];
  $post_password = $post['password'];

  $sql = $db->prepare('select * from familydiary where id=? ');
  $data[] = $post_id;

  $sql->execute($data);

  $sqls= $sql->fetch();

  // 受け取ったパスワードと登録してあるパスワードが一致しているか確認
  if(password_verify($post_password,$sqls['password'])){
    session_start();
    $_SESSION['login'] = 1;
    $_SESSION['usercode'] = $sqls['usercode'];
    $_SESSION['id'] = $sqls['id'];
    $_SESSION['userimg'] = $sqls['userimg'];
    header('location:index.php');
    exit();
  }else{
    header('location:login.php');
    exit();
  }

    $db = null;

}catch(Exception $e){
  header('location:index.php');
  exit();
}

?>