<?php
  require_once('common/db.php');
  require_once('common/common.php');

  // pager.phpでリンク先をindex.phpとalbum.pagination__item--pre__anchorを切り替えるために使う変数
  $page_name = 'album.php';

  define('max_view',24);

  //必要なページ数を求める
  $count = $db->prepare('SELECT COUNT(*) AS count FROM writing WHERE img != ""');
  $count->execute();
  $total_count = $count->fetch(PDO::FETCH_ASSOC);
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

  $sqls = $db->prepare('select * from writing INNER JOIN familydiary ON writing.usercode = familydiary.usercode WHERE img != "" ORDER BY writedate DESC LIMIT :start,:max');

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
  $db=null;

?>
<div class="album-page">
  <div class="album">
    <!-- 画像を表示する -->
    <?php foreach ( $data as $row ):?>
      <a href="single.php?writing_id=<?php echo $row['writingcode'] ?>" class="album__body">
        <img class="album__body__img" src="img/<?php echo $row['img']?>" alt="">
      </a>
    <?php endforeach ;?>
  </div>
  <?php include('portion/pager.php');?>
</div>