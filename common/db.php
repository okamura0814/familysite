<?php
  // データベースアクセス用
  // try{
  //   $db = new PDO ('mysql:host=mysql8079.xserver.jp;dbname=oohashitorio_familydiary;charset=utf8','oohashitorio_oka','okapi0814');
  // }catch(PDOException $e){
  //   print "接続エラー：{$e->getMessage()}";
  // }
?>

<?php
  try{
    $db = new PDO ('mysql:host=localhost;dbname=familydiary;charset=utf8','okamura','okapi0814');
  }catch(PDOException $e){
    print "接続エラー：{$e->getMessage()}";
  }
?>