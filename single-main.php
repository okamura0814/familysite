<?php
  require_once('common/db.php');
  require_once('common/common.php');

  // サニタイズ
  if(isset($_GET['writing_id'])){
    $get=sanitize($_GET);
  }

  // 対象の記事データの取得
  $sqls = $db->prepare('select * from writing INNER JOIN familydiary ON writing.usercode = familydiary.usercode where writingcode=? ');
  $data[] = $get['writing_id'];
  $sqls->execute($data);
  $data = $sqls->fetchAll(PDO::FETCH_ASSOC);


  // 対象の記事のコメントデータを取得
  $comment_sqls = $db->prepare('select * from comment INNER JOIN familydiary ON comment.usercode = familydiary.usercode where writingcode=? ');
  $comment_data[] = $get['writing_id'];
  $comment_sqls->execute($comment_data);
  $comment_data = $comment_sqls->fetchAll(PDO::FETCH_ASSOC);
  $db=null;
?>

<div class="single">
  <div class="inner">
    <article class="article">
      <?php foreach ( $data as $article ):?>
        <div class="article__body">
          <div class="article__body__top">
            <p class="article__body__top__user"><a href="profile.php?profile=<?php echo $article['usercode'] ?>"><?php echo $article['id'] ?></a></p>
            <p><?php echo date('Y/m/d', strtotime($article['writedate'])); ?></p>
          </div>
          <!-- 画像がデータベースに登録してあるか確認。してあるならそのまま表示。なければデフォルトの代わりの画像を表示する -->
          <?php if(mb_strlen($article['img']) !== 0): ?>
            <img class="article__body__img" src="img/<?php echo $article['img']?>" alt="">
          <?php else: ?>
            <img class="article__body__img" src="img/IMG_3473.PNG" alt="">
          <?php endif ;?>
          <p class="article__body__text"><?php echo $article['writecontents'] ?></p>
          <!-- comment.phpに書き込みたい日記のIDを送る -->
          <a class="article__body__commentLink" href="comment.php?writing_id=<?php echo $article['writingcode'] ?>">コメントを書く</a>

          <!-- 書き込んだ本人にのみ表示する -->
          <?php if($article['usercode']==$_SESSION['usercode']) :?>
            <a class="article__body__commentLink" href="diary_editing.php?writing_id=<?php echo $article['writingcode'] ?>">内容編集</a>
            <a class="article__body__commentLink" href="diary_delete.php?writing_id=<?php echo $article['writingcode'] ?>">削除</a>
          <?php endif ;?>

        </div>
      <?php endforeach ;?>

      <?php foreach ( $comment_data as $comment ):?>
        <div class="article__comment">
          <div class="article__comment__top">
            <p class="article__body__top__user"><a href="profile.php?profile=<?php echo $comment['usercode'] ?>"><?php echo $comment['id'] ?></a></p>
            <p><?php echo date('Y/m/d', strtotime($comment['commentdate'])); ?></p>
          </div>
          <p class="article__comment__text"><?php echo $comment['commentcontent'] ?></p>
          <!-- 書き込んだ本人にのみ表示する -->
          <?php if($comment['usercode']==$_SESSION['usercode']) :?>
            <a class="article__comment__commentLink" href="diary_editing.php?comment_id=<?php echo $comment['commentcode'] ?>">内容編集</a>
            <a class="article__comment__commentLink" href="diary_delete.php?comment_id=<?php echo $comment['commentcode'] ?>">削除</a>
          <?php endif ;?>
        </div>
      <?php endforeach ;?>
    </article>
  </div>
</div>