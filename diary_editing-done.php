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

  // 対象の記事の書き込みを上書き
  if(isset($post['writing_id'])){
    $sqls = $db->prepare('UPDATE writing SET writecontents=? WHERE writingcode=?');
    $date[] = $post['writing-editing'];
    $date[] = $post['writing_id'];
    $sqls->execute($date);
    $db=null;
    $writing_id=$post['writing_id'];
    header("location:single.php?writing_id={$writing_id}");
    exit();
  }

  // 対象のコメントの書き込みを上書き
  if(isset($post['comment_id'])){
    $sqls = $db->prepare('UPDATE comment SET commentcontent=? WHERE commentcode=?');
    $date[] = $post['comment-editing'];
    $date[] = $post['comment_id'];
    $sqls->execute($date);
    $db=null;
    $writing_id=$post['comment-writing_id'];
    header("location:single.php?writing_id={$writing_id}");
    exit();
  }
?>