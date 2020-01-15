<div class="pager">
  <ul class="pagination">
    <!-- 現在いるページが１より大きければボタンを表示 -->
    <?php if($now > 1) :?>
      <li class="pagination__item--pre">
        <a class="pagination__item--pre__anchor" href="./<?php echo $page_name ?>?page_id=<?php echo $now-1 ?>">«</a>
      </li>
    <?php endif ;?>

    <!-- 必要なページ数に合わせてボタンを表示 -->
    <?php for ( $n = 1; $n <= $pages; $n ++) :?>
      <!-- 現在いるボタンのみアクティブにする -->
      <?php if ( $n == $now ) : ?>
        <li class="pagination__item">
          <a class="pagination__item__anchor pagination__active" href="#" ><?php echo $now ?></a>
        </li>
      <!-- 現在いるボタン以外を表示 -->
      <?php else : ?>
        <li class="pagination__item">
          <a class="pagination__item__anchor" href="./<?php echo $page_name ?>?page_id=<?php echo $n ?>"><?php echo $n ?></a>
        </li>
      <?php endif ;?>
    <?php endfor ; ?>

    <!-- 現在いるページ数が最大ページ数より小さい場合表示する -->
    <?php if($pages > $now) :?>
      <li class="pagination__item--next">
        <a class="pagination__item--next__anchor" href="./<?php echo $page_name ?>?page_id=<?php echo $now+1 ?>">»</a>
      </li>
    <?php endif ;?>
  </ul>
</div>