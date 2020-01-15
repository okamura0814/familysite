<?php
session_start();
session_regenerate_id(true);

require_once('common/common.php');

if(isset($_SESSION['login'])==false){
  header('location:login.php');
  exit();
}
$header_title = "コメント";
// 日記のIDをもらってきてそのIDに対してのコメントを登録するために使う
if(isset($_GET['writing_id'])){
  $get=sanitize($_GET);
}

?>
<!DOCTYPE html>
<html lang="jp">

<?php include('portion/head.php');?>

<body>
<header id="header">

<?php include('portion/column3-header.php');?>

<?php include('portion/sub-nav.php');?>

</header>
<main>

<?php include('writing-main.php');?>

</main>

<?php include('portion/footer.php');?>

</body>
</html>