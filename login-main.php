<div class="login-page">
  <div class="login-item">
    <div class="login-item__body">
      <form method="post" action="login_check.php">
        <div class="login-item__body__id">
          <input type="text" name="id" placeholder="ユーザー名">
        </div>
        <div class="login-item__body__pass">
          <input type="password" name="password" placeholder="パスワード">
        </div>
        <div class="login-item__body__btn">
          <input class="btn-blue" type="submit" value="ログイン" />
        </div>
      </form>
      <form method="post" action="login_check.php">
        <input type="hidden" name="id" value="大橋トリオ">
        <input type="hidden" name="password" value="oohasi">
        <div class="login-item__body__btn">
          <input class="btn-blue" type="submit" value="簡単ログイン" />
        </div>
      </form>
        <div class="login-item__body__registration">
          <a href="registration.php">新規登録はコチラ</a>
        </div>
    </div>
  </div>
</div>
