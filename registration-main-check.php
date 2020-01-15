<?php
  require('common/db.php');
  require_once('common/common.php');

  // registration.phpで$post=sanitize($_POST);を実行している

  $user_name = $post['name'];
  $user_birthday_array = array($post['year'],$post['month'],$post['day']);
  $user_id = $post['id'];
  $user_password = $post['password'];
  $user_password_check = $post['password-check'];

  // 生年月日の年と月と日を繋げて変数へ代入
  $user_birthday = $user_birthday_array[0].$user_birthday_array[1].$user_birthday_array[2];

  // すべての登録する項目をきちんと入力されているか確認するための変数を初期化
  $miss_check = true;

  // 生年月日がきちんと入力されているか確認するための変数を初期化
  $birthday_check = true;

  // 登録したいIDが使われているか確認するための変数を初期化
  $id_check = true;

  // ここで登録したいIDが使われているか確認する
  $sql = $db->prepare('select * from familydiary where id=?');
  $data[] = $user_id;

  $sql->execute($data);

  if($sqls = $sql->fetch()){
    $id_check = false;
    $id_check_message = 'このID名は使われています。';
  }
?>
<div class="registration-page">
  <div class="registration-item">
    <div class="registration-item__top">
      <h2 class="registration-item__top__title">家族日記を使ってみよう</h2>
    </div>
    <div class="registration-item__body">
      <div class="registration-item__body__item">
        <?php if($user_name == '') : ?>
          <p>名前を入力してください</p>
        <?php else : ?>
          <p>名前：<?php echo $user_name ?></p>
        <?php endif; ?>
      </div>
      <div class="registration-item__body__item">
      <!-- 生年月日の配列に年・月・日の値が入っているか一つづつ確認 -->
        <?php foreach($user_birthday_array as $birthday) : ?>
        <?php if($birthday === '') : ?>
        <!-- 入っていない場合はfalseを代入 -->
          <?php $birthday_check = false; ?>
        <?php endif; ?>
        <?php endforeach ; ?>
        <?php if($birthday_check === false) :?>
        <!-- 値が入っていなかった場合 -->
          <p>誕生日を入力してください</p>
          <?php $miss_check = false; ?>
        <?php else : ?>
        <!-- ３つとも値が入っていた場合 -->
          <p>生年月日:<?php echo $user_birthday_array[0]."年".$user_birthday_array[1]."月".$user_birthday_array[2]."日"; ?></p>
        <?php endif; ?>
      </div>
      <div class="registration-item__body__item">
        <?php if($user_id === '') : ?>
        <!-- 値が入っていなかった場合 -->
          <p>ユーザー名を入力してください</p>
          <?php $miss_check = false; ?>
        <?php elseif($id_check === false) : ?>
        <!-- IDがすでに使われていた場合 -->
          <p><?php echo $id_check_message; ?></p>
          <?php $miss_check = false; ?>
        <?php else : ?>
          <p>ユーザー名：<?php echo $user_id; ?></p>
        <?php endif; ?>
      </div>
      <div class="registration-item__body__item">
        <?php if($user_password !== $user_password_check) : ?>
          <p>パスワードが間違っています</p>
          <?php $miss_check = false; ?>
        <?php endif ; ?>
      </div>
      <form method="post" action="registration.php">
        <input type="hidden" name="name" value="<?=$user_name?>">
        <input type="hidden" name="birthday" value="<?=$user_birthday?>">
        <input type="hidden" name="id" value="<?=$user_id?>">
        <input type="hidden" name="password" value="<?=$user_password?>">
        <input type="hidden" name="select" value="insert">
        <div class="registration-item__body__btn">
          <?php if($miss_check === false) : ?>
            <input class="btn-blue" type="button" onclick="history.back()" value="戻る" />
          <?php else : ?>
            <input class="btn-blue" type="submit" value="登録" />
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>
</div>
