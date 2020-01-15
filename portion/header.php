<nav class="login-nav">
  <div class="login-nav__title">
  <?php if(isset($_POST['select'])) :?>
    <?php if($_POST['select'] == 'insert') :?>
      <h1>新規登録</h1>
    <?php endif ; ?>
  <?php else :?>
    <h1>家族日記にログイン</h1>
  <?php endif ; ?>
  </div>
</nav>
