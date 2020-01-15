<?php
  require_once('common/common.php');
  if(isset($_POST['id'])){
    $post=sanitize($_POST);
  }

  if(isset($_FILES['img'])){
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
  }
?>
<div class="registration-page">
  <div class="registration-item">
    <div class="registration-item__top">
      <h2 class="registration-item__top__title">ユーザー名・画像編集</h2>
    </div>
    <div class="registration-item__body">
      <!-- profileChangeCheckページの場合表示 -->
      <?php if(isset($post)||isset($files_img['name'])) :?>
        <form method="post" action="profileChange-done.php">
        <?php if($files_img['name']!=='') :?>
          <div class="registration-item__body__img">
            <img src="<?php echo $filename?>" alt="" class="profile__img">
          </div>
          <input type="hidden" name="img_name" value="<?php echo $files_img['name'] ?>">
        <?php endif ;?>
        <?php if($post['id']=='') :?>
          <div class="registration-item__body__item">
            <p>ユーザー名を入力してください！</p>
          </div>
        <?php else :?>
          <div class="registration-item__body__item">
            <p><?php echo $post['id']?></p>
          </div>
          <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
          <div class="registration-item__body__btn">
          <input class="btn-blue" type="submit" value="実行" />
        </div>
        <?php endif ;?>
        </form>
        <div class="registration-item__body__btn">
          <input class="btn-blue" type="button" onclick="history.back()" value="戻る" />
        </div>
      <?php endif ; ?>
      <!-- ここまで -->
      <!-- 変更確認画面時では非表示にする -->
      <!-- 確認画面の時は$post変数にユーザー名が代入される -->
      <?php if(isset($post)==false) :?>
      <form method="post" enctype="multipart/form-data" action="profileChange.php">
        <div class="registration-item__body__item">
          <input type="text" name="id" value="<?php echo $_SESSION['id']?>" placeholder="ユーザー名" />
        </div>
        <?php if(isset($post)==false||isset($files_img)==false) :?>
          <label for="file-upload" class="registration-item__body__file-upload">
            画像を選択して下さい
            <input type="file" id="file" class="registration-item__body__file-upload__item" name="img"/>
            <input type="text" id="file-upload" class="registration-item__body__file-upload__item" placeholder="選択されていません" readonly />
          </label>
          <div class="registration-item__fileName">
            <input type="text" id="fake_text_box" value="" size="50" readonly>
          </div>
        <?php endif ;?>
        <!-- file関係ここまで -->
        <div class="registration-item__body__btn">
          <input class="btn-blue" type="submit" value="変更" />
        </div>
      </form>
      <?php endif ;?>
    </div>
  </div>
</div>