<?php
  require_once('common/db.php');
  require_once('common/common.php');

  // pager.phpでリンク先をindex.phpとalbum.pagination__item--pre__anchorを切り替えるために使う変数
  $page_name = 'index.php';

  // 表示する最大数
  define('max_view',12);

  //必要なページ数を求める
  $count = $db->prepare('SELECT COUNT(*) AS count FROM writing');
  $count->execute();
  // アイテム数を数える
  $total_count = $count->fetch(PDO::FETCH_ASSOC);
  // アイテム数を最大表示数と割ってページ数を求める
  $pages = ceil($total_count['count'] / max_view);

  // サニタイズ
  if(isset($_GET['page_id'])){
    $get=sanitize($_GET);
  }

  //現在いるページのページ番号を取得
  if(!isset($get['page_id'])){
    $now = 1;
  }else{
    $now = $get['page_id'];
  }

  $sqls = $db->prepare('select * from writing INNER JOIN familydiary ON writing.usercode = familydiary.usercode ORDER BY writedate DESC LIMIT :start,:max');

  if($now == 1){
  // 1ページ目の処理（1ページにいる場合ページ数から1引いて０になる。表示最大数は１２なので０～１１まで表示する）
      $sqls->bindValue(':start',$now-1,PDO::PARAM_INT);
      $sqls->bindValue(':max',max_view,PDO::PARAM_INT);
  }else{
  // ２ページ以降の処理（現在いるページ数から１引いて引いた後の数に表示最大数を掛け算する。２ページにいる場合は１２～２４まで表示する。）
      $sqls->bindValue(":start",($now -1 ) * max_view,PDO::PARAM_INT);
      $sqls->bindValue(":max",max_view,PDO::PARAM_INT);
  }

  $sqls->execute();
  $data = $sqls->fetchAll(PDO::FETCH_ASSOC);
  $db=null;

?>

<div class="cardList">
  <div class="inner">
    <div class="cardList__body">
      <?php foreach ( $data as $row ):?>
        <section class="card" data-wow-iteration="1">
          <div class="card__top">
            <!-- カードトップにユーザー名と投稿日を表示 -->
            <p><?php echo $row['id']; ?></p>
            <p><?php echo date('Y/m/d', strtotime($row['writedate'])); ?></p>
          </div>
          <?php if(mb_strlen($row['img']) !== 0): ?>
            <!-- ↑で画像を登録されていることを確認できた場合 -->
            <img class="card__img" src="img/<?php echo $row['img']?>" alt="">
          <?php else: ?>
            <!-- 確認できなかった場合デフォルト画像を表示する -->
            <img class="card__img" src="img/IMG_3473.PNG" alt="">
          <?php endif ;?>
          <p class="card__text">
          <?php
            // カード内の表示文字数の最大値
            $limit = 40;
            if(mb_strlen($row['writecontents']) > $limit){
              // 表示最大文字数より大きい場合
              $title = mb_substr($row['writecontents'],0,$limit);
              echo $title."...";
            }else{
              // 少ない場合
              echo $row['writecontents'];
            }
          ?>
          </p>
          <a class="card__link" href="single.php?writing_id=<?php echo $row['writingcode'] ?>"></a>
        </section>
      <?php endforeach ;?>
    </div>
  </div>
  <?php
    // 必要なページ数が１より大きい場合表示
    if($pages > 1){
      include('portion/pager.php');
    }
  ?>
</div>