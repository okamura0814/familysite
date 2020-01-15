<?php
  require('common/db.php');
  require_once('common/common.php');

  session_start();
  session_regenerate_id(true);

  if(isset($_SESSION['login'])==false){
    header('location:login.php');
    exit();
  }
  // サニタイズ
  $post=sanitize($_POST);

  // 受け取ったIDと画像をデータベースへ上書き
  if(isset($post['id'])&&isset($post['img_name'])){

    // 画像も削除するために一度データベースから取得する
    $sqls = $db->prepare('select * from familydiary where usercode=?');
    $date[] = $_SESSION['usercode'];
    $sqls->execute($date);
    $sqls= $sqls->fetch();

    // 画像が登録してあれば削除する
    if(!empty($sqls['userimg'])){
      unlink("img/".$sqls['userimg']);
    }

    // 配列のリフレッシュ
    $sqls=array();
    $date=array();

    $sqls = $db->prepare('UPDATE familydiary SET id=?,userimg=? WHERE usercode=?');
    $date[] = $post['id'];
    $date[] = $post['img_name'];
    $date[] = $_SESSION['usercode'];
    $sqls->execute($date);

    // 配列のリフレッシュ
    $sqls=array();
    $date=array();

    // 変更後のプロフィールを取得してマイプロフィール画面へ移動
    $sqls = $db->prepare('select * from familydiary where usercode=?');
    $date[] = $_SESSION['usercode'];
    $sqls->execute($date);
    $sqls= $sqls->fetch();
    $_SESSION['id'] = $sqls['id'];
    $_SESSION['userimg'] = $sqls['userimg'];
    $db=null;
    header('location:profile.php?my_profile=my');
    exit();
  }else{
    // 受け取ったIDをデータベースへ上書き（画像の変更がない場合）
    $sqls = $db->prepare('UPDATE familydiary SET id=? WHERE usercode=?');
    $date[] = $post['id'];
    $date[] = $_SESSION['usercode'];
    $sqls->execute($date);

    // 配列のリフレッシュ
    $sqls=array();
    $date=array();

    // 変更後のプロフィールを取得してマイプロフィール画面へ移動
    $sqls = $db->prepare('select * from familydiary where usercode=?');
    $date[] = $_SESSION['usercode'];
    $sqls->execute($date);
    $sqls= $sqls->fetch();
    $_SESSION['id'] = $sqls['id'];
    $db=null;
    header('location:profile.php?my_profile=my');
    exit();
  }
?>