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

  // 日記の記事コードを貰って削除する
  if(isset($post['writing_id'])){

    // 画像も削除するために一度データベースから取得する
    $sqls = $db->prepare('select * from writing where writingcode=? ');
    $data[] = $post['writing_id'];
    $sqls->execute($data);
    $data = $sqls->fetch();

    // 画像が登録してあれば削除する
    if(!empty($data['img'])){
      unlink("img/".$data['img']);
    }

    // 配列のリフレッシュ
    $sqls=array();
    $date=array();

    // 日記記事の削除
    $sqls = $db->prepare('DELETE FROM writing WHERE writingcode=?');
    $date[] = $post['writing_id'];
    $sqls->execute($date);

    // 配列のリフレッシュ
    $sqls=array();
    $date=array();

    // 削除した日記のコメント削除
    $sqls = $db->prepare('DELETE FROM comment WHERE writingcode=?');
    $date[] = $post['writing_id'];
    $sqls->execute($date);

    $db = null;
    header("location:index.php");
    exit();
  }

  // 記事への書きこみのコードを貰ってコメントの削除（コメント削除のみの場合）
  if(isset($post['comment_id'])){
    $sqls = $db->prepare('DELETE FROM comment WHERE commentcode=?');
    $date[] = $post['comment_id'];
    $sqls->execute($date);
    $db = null;

    // 日記の記事コードを貰って代入して対象のページへ戻る
    $writing_id = $post['comment-writing_id'];
    header("location:single.php?writing_id={$writing_id}");
    exit();
  }
?>