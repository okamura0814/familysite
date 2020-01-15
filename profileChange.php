<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION['login'])==false){
  header('location:login.php');
  exit();
}
// ページタイトル
$header_title = "プロフィール編集";

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

<?php include('profileChange-main.php');?>

</main>

<?php include('portion/footer.php');?>

</body>
</html>