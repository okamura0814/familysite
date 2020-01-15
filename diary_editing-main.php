<?php
  require_once('common/db.php');
  require_once('common/common.php');

  // 記事コードかコメントコードがあった場合サニタイズ
  if(isset($_GET['writing_id'])||isset($_GET['comment_id'])){
    $get=sanitize($_GET);
  }

  // 編集画面の為に対象の記事データを取得
  if(isset($get['writing_id'])){
    $sqls = $db->prepare('select * from writing where writingcode=? ');
    $data[] = $get['writing_id'];
    $sqls->execute($data);
    $data = $sqls->fetch();
    $db=null;
  }

  // 編集画面の為に対象のコメントデータを取得
  if(isset($get['comment_id'])){
    $comment_sqls = $db->prepare('select * from comment where commentcode=? ');
    $comment_data[] = $get['comment_id'];
    $comment_sqls->execute($comment_data);
    $comment_data = $comment_sqls->fetch();
    $db=null;
  }
?>

<div class="single">
  <div class="inner">
    <article class="article">

      <!-- 対象の記事を表示 -->
      <?php if(isset($data)):?>
        <div class="article__body">
          <div class="article__body__top">
            <p><?php echo date('Y/m/d', strtotime($data['writedate'])); ?></p>
          </div>
          <?php if(mb_strlen($data['img']) !== 0): ?>
            <!-- ↑で画像を登録されていることを確認できた場合 -->
            <img class="article__body__img" src="img/<?php echo $data['img']?>" alt="">
          <?php else: ?>
            <!-- 確認できなかった場合デフォルト画像を表示する -->
            <img class="article__body__img" src="img/IMG_3473.PNG" alt="">
          <?php endif ;?>
          <form action="diary_editing-done.php" method="post">
            <textarea class="diary-editing-textarea" name="writing-editing" id="" cols="30" rows="10"><?php echo $data['writecontents'] ?></textarea>
            <input type="hidden" name="writing_id" value="<?php echo $get['writing_id']; ?>">
            <div class="diaryButton">
              <input class="btn-white" type="submit" value="変更" />
            </div>
          </form>
        </div>
      <?php endif ;?>

      <!-- 対象のコメントを表示 -->
      <?php if(isset($comment_data)):?>
        <div class="article__comment">
          <div class="article__comment__top">
            <p><?php echo date('Y/m/d', strtotime($comment_data['commentdate'])); ?></p>
          </div>
          <form action="diary_editing-done.php" method="post">
            <textarea class="diary-editing-textarea" name="comment-editing" id="" cols="30" rows="10"><?php echo $comment_data['commentcontent'] ?></textarea>
            <input type="hidden" name="comment_id" value="<?php echo $get['comment_id']; ?>">
            <input type="hidden" name="comment-writing_id" value="<?php echo $comment_data['writingcode']; ?>">
            <div class="diaryButton">
              <input class="btn-white" type="submit" value="変更" />
            </div>
          </form>
        </div>
      <?php endif ;?>
    </article>
  </div>
</div>