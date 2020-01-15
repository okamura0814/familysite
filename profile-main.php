<?php
  require_once('common/db.php');
  require_once('common/common.php');

   // pager.phpでリンク先をindex.phpとalbum.pagination__item--pre__anchorを切り替えるために使う変数
   $page_name = 'profile.php';

  // 表示する最大数
  define('max_view',8);

  // サニタイズ
  if(isset($_GET)){
    $get=sanitize($_GET);
  }
// 個人ページ用
// セッションにユーザーコードが残っていたら初期化する
// 2ページ以降はセッションからユーザーコード貰う為に代入する。
  if(isset($_GET['profile'])){
    if($get['profile']){
      $_SESSION['profile'] = array();
      $_SESSION['profile'] = $get['profile'];
      $username = $get['profile'];
    }
// マイページ用
  }elseif(isset($_GET['my_profile'])){
    if($get['my_profile']=='my'){
      $_SESSION['profile'] = array();
      $_SESSION['profile'] = $_SESSION['usercode'];
      $username = $_SESSION['usercode'];
    }
// 個人ページの２ページ以降の処理
// セッションからユーザーコードを貰う
  }elseif(isset($_SESSION['profile'])){
    $username = $_SESSION['profile'];
  }

  //必要なページ数を求める
  $count = $db->prepare('SELECT COUNT(*) AS count FROM writing where usercode = :usercode');
  $count->bindValue(':usercode',$username);
  $count->execute();
  $total_count = $count->fetch(PDO::FETCH_ASSOC);
  $pages = ceil($total_count['count'] / max_view);

  //現在いるページのページ番号を取得
  if(!isset($get['page_id'])){
    $now = 1;
  }else{
    $now = $get['page_id'];
  }

  $sqls = $db->prepare('select * from writing INNER JOIN familydiary ON writing.usercode = familydiary.usercode where writing.usercode = :usercode ORDER BY writedate DESC LIMIT :start,:max');
  $sqls->bindValue(':usercode',$username);
  if($now == 1){
    // 1ページ目の処理
    $sqls->bindValue(':start',$now-1,PDO::PARAM_INT);
    $sqls->bindValue(':max',max_view,PDO::PARAM_INT);
  }else{
    // ２ページ以降の処理
    $sqls->bindValue(":start",($now -1 ) * max_view,PDO::PARAM_INT);
    $sqls->bindValue(":max",max_view,PDO::PARAM_INT);
  }
  $sqls->execute();
  $data = $sqls->fetchAll(PDO::FETCH_ASSOC);

  // 取得した記事データの0列目のレコードのみを代入
  if(empty($data)==false){
    $userid = $data[0];
  }

  $db=null;
?>

<div class="single">
  <div class="inner">
    <div class="profile">
    <!-- 記事の書き込みがあれば表示する（無ければelseでメッセージを表示する） -->
    <?php if(empty($data)==false) :?>
      <!-- プロフィールに画像が登録されていれば表示 -->
      <?php if(empty($userid['userimg']) ==false): ?>
        <img class="profile__img" src="img/<?php echo $userid['userimg'] ?>" alt="">
      <!-- 画像が登録されていない場合 -->
      <?php else: ?>
        <img class="profile__img" src="img/IMG_3475.PNG" alt="">
      <?php endif ;?>
      <p class="profile__user"><?php echo $userid['id'] ?></p>
    </div>
    <article class="article">
      <?php foreach ( $data as $article ):?>
        <div class="article__body">
          <div class="article__body__top">
            <p><?php echo date('Y/m/d', strtotime($article['writedate'])); ?></p>
          </div>
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
    </article>
    <!-- 書き込みがなかった場合メッセージ表示 -->
    <?php else :?>
      <p>まだ書き込みがないようです...</p>
      <p>日記を書いてみましょう！</p>
    </div>
    <?php endif ;?>
  </div>
  <?php
    if($pages > 1){
      include('portion/pager.php');
    }
  ?>
</div>