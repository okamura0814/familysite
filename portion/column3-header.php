<nav class="nav">
  <div class="nav__item--right">
    <h1 class="nav__item--right__logo">家族日記</h1>
  </div>
  <div class="nav__item--center">
    <!-- $header_titleに代入されているタイトルを表示する -->
    <h2 class="nav__item--center__title"><?php echo $header_title ?></h2>
  </div>
  <div class="nav__item--left">
    <!-- my_profileの場合はプロフィール編集にする -->
    <?php if(isset($_GET['my_profile'])) :?>
      <p class="nav__item--left__user"><a href="profileChange.php">プロフィール編集</a></p>
    <?php else : ?>
      <p class="nav__item--left__user"><a href="profile.php?my_profile=my"><?php echo $_SESSION['id'] ?></a></p>
      <a class="nav__item--left__userImage" href="profile.php?my_profile=my">
      <?php if(empty($_SESSION['userimg']) ==false): ?>
        <img src="img/<?php echo $_SESSION['userimg']?>" alt="">
      <?php else: ?>
        <img class="profile__img" src="img/IMG_3475.PNG" alt="">
      <?php endif ;?>
      </a>
    <?php endif ; ?>
  </div>
</nav>