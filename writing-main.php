<div class="writing">
  <form method="post" enctype="multipart/form-data" action="writing-done.php">
    <div class="diary">
      <div class="diary__body">
        <textarea class="diary__body__text" name="writing" id="" cols="30" rows="10"></textarea>
      </div>
      <!-- コメントの書き込みの時は画像はいらないからコメントの書き込みかどうかここで判断している -->
      <!-- 日記の書き込みだと画像を選択するボタンを表示する -->
      <?php if(isset($get)==false) :?>
        <label for="file-upload" class="diary__file-upload-label">
            画像を選択して下さい
          <input type="file" id="file" class="diary__file-upload-label__item" name="img" accept="image/*" />
          <input type="text" id="file-upload" class="diary__file-upload-label__item" placeholder="選択されていません" readonly />
        </label>
        <div class="diary__fileName">
          <input type="text" id="fake_text_box" value="" size="50" readonly>
        </div>
      <?php endif ; ?>
    </div>
    <?php if(isset($get['writing_id'])) :?>
      <input type="hidden" name="writing_id" value="<?php echo $get['writing_id'] ?>">
    <?php endif ;?>
    <div class="diaryButton">
      <input class="btn-white" type="submit" value="送信" />
    </div>
  </form>
</div>