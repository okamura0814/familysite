<div class="registration-page">
  <div class="registration-item">
    <div class="registration-item__top">
      <h2 class="registration-item__top__title">家族日記を使ってみよう</h2>
    </div>
    <div class="registration-item__body">
      <form method="post" action="registration.php">
        <div class="registration-item__body__item">
          <input type="text" name="name" placeholder="氏名">
        </div>
        <div class="registration-item__body__item">
          <!-- <input type="text" name="birthday" placeholder="生年月日"> -->
          <p class="registration-item__body__item__title">誕生日</p>
          <select name="year" id="select1" class="select1" onchange="Change('select1','select1');">
            <option value="" selected>年 --</option>
            <?php foreach(range(1940,2020) as $year): ?>
            <option value="<?=$year?>"><?=$year?></option>
            <?php endforeach; ?>
          </select>
          <select name="month" id="select2" class="select2" onchange="Change('select2','select2');">
            <option value="" selected>月 --</option>
            <?php foreach(range(1,12) as $month): ?>
            <option value="<?=str_pad($month,2,0,STR_PAD_LEFT)?>"><?=$month?></option>
            <?php endforeach; ?>
          </select>
          <select name="day" id="select3" class="select3" onchange="Change('select3','select3');">
            <option value="" selected>日 --</option>
            <?php foreach(range(1,31) as $day): ?>
            <option value="<?=str_pad($day,2,0,STR_PAD_LEFT)?>"><?=$day?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="registration-item__body__item">
          <input type="text" name="id" placeholder="ユーザー名">
        </div>
        <div class="registration-item__body__item">
          <input type="password" name="password" placeholder="パスワード">
        </div>
        <div class="registration-item__body__item">
          <input type="password" name="password-check" placeholder="パスワード（確認用）">
        </div>
        <input type="hidden" name="select" value="check">
        <div class="registration-item__body__btn">
          <input class="btn-blue" type="submit" value="登録" />
        </div>
      </form>
    </div>
  </div>
</div>
