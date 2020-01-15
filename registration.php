<?php
 require_once('common/common.php');

 // サニタイズ
 if((count($_POST) <= 0)==false){
   $post=sanitize($_POST);
 }
 ?>

<!DOCTYPE html>
<html lang="jp">

<?php include('portion/head.php');?>

<body>
<header id="header">

<?php
// チェック画面か実行画面を判別してヘッダーを切り変えている
if(isset($post['select'])){
  if($post['select'] == 'check'){
    include('portion/column2-header.php');
  }elseif($post['select'] == 'insert'){
    include('portion/header.php');
  }
}else{
  include('portion/column2-header.php');
}
?>

</header>
<main>
<?php
// チェック画面か実行画面を判別して処理を切り変えている
if(isset($post['select'])){
  if($post['select'] == 'check'){

    include('registration-main-check.php');

  }elseif($post['select'] == 'insert'){
    include('registration-main-done.php');
  }
}else{
  include('registration-main.php');
}

?>

</main>

<?php include('portion/footer.php');?>

</body>
</html>