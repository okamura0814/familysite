<?php
  require_once('common/db.php');
  require_once('common/common.php');

  // 日記の記事コードかコメントコードがあった場合サニタイズ
  if(isset($_GET['writing_id'])||isset($_GET['comment_id'])){
    $get=sanitize($_GET);
  }

  // データベースから対象の記事コードでデータを取ってくる
  if(isset($get['writing_id'])){
    $sqls = $db->prepare('select * from writing where writingcode=? ');
    $data[] = $get['writing_id'];
    $sqls->execute($data);
    $data = $sqls->fetch();
    $db=null;
  }

  // データベースから対象のコメントコードでデータを取ってくる
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
    <!-- 記事を表示 -->
    <article class="article">
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
          <form action="diary_delete-done.php" method="post">
            <p class="article__body__text"><?php echo $data['writecontents'] ?></p>
            <input type="hidden" name="writing_id" value="<?php echo $get['writing_id']; ?>">
            <div class="diaryButton">
              <input class="btn-white" type="submit" value="削除" />
            </div>
          </form>
        </div>
      <?php endif ;?>

      <!-- コメントの表示 -->
      <?php if(isset($comment_data)):?>
        <div class="article__comment">
          <div class="article__comment__top">
            <p><?php echo date('Y/m/d', strtotime($comment_data['commentdate'])); ?></p>
          </div>
          <form action="diary_delete-done.php" method="post">
            <p class="article__comment__text"><?php echo $comment_data['commentcontent'] ?></p>
            <input type="hidden" name="comment_id" value="<?php echo $get['comment_id']; ?>">
            <input type="hidden" name="comment-writing_id" value="<?php echo $comment_data['writingcode']; ?>">
            <div class="diaryButton">
              <input class="btn-white" type="submit" value="削除" />
            </div>
          </form>
        </div>
      <?php endif ;?>
    </article>
  </div>
</div>