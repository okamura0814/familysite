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

  // 記事コードを受け取ってコメントの書き込みの実行
  if(isset($post['writing_id'])){

    if($post['writing'] !== ''){

      $sqls = $db->prepare('INSERT INTO comment(usercode,writingcode,commentcontent) values ( ?, ?, ?)');

      $date[] = $_SESSION['usercode'];
      $date[] = $post['writing_id'];
      $date[] = $post['writing'];
      $sqls->execute($date);
      $db=null;

      header('location:single.php?writing_id='.$post['writing_id']);
      exit();
    }else{
      header('location:comment.php');
      exit();
    }
  }

  // 記事の書き込みの実行
  if($post['writing'] !== ''){

  $files_img=$_FILES['img'];

  // 保存したいファイル場所
  $filename = './img/'.$files_img['name'];

  // 画像がアップロードされているか判断する
  if($files_img['size'] > 0){

  // 画像情報を取得して変数へ入れる
  $exif_data=exif_read_data($files_img['tmp_name']);

  // 画像情報から画像の傾きや逆転を示す情報だけを取得して変数へ代入
  $orientation = $exif_data['Orientation'];

  // アップロードされてた画像の場所、保存したいファイル場所、傾きや逆転の情報を引数で渡す
  // 画像を正しい向きに直して保存までしてくれる
  $img_data = imageOrientation($files_img['tmp_name'],$filename, $orientation);
  }

  $sqls = $db->prepare('INSERT INTO writing(usercode,writecontents,img) values ( ?, ?, ?)');

  $date[] = $_SESSION['usercode'];
  $date[] = $post['writing'];
  $date[] = $files_img['name'];
  $sqls->execute($date);
  $db=null;

  header('location:index.php');
  exit();

  }else{
    header('location:writing.php');
    exit();
  }
?>