<?php
// サニタイズ
function sanitize($before){
  foreach($before as $key=>$value){
    $after[$key] = htmlspecialchars($value,ENT_QUOTES,"UTF-8");
  }
  return $after;
}

// データベースロック
function sql_lock($sqls,$tablename){
  $sqls=$db->prepare("LOCK TABLES `{$tablename}` WRITE");
  $sqls->execute();
}

// データベースアンロック
function sql_unlock($sqls){
  $sqls=$db->prepare("UNLOCK TABLES");
  $sqls->execute();
}

// アップロードされた画像を正しい方向に回転させて保存する
function imageOrientation($img_data,$filename, $orientation)
{
	//画像ロード
	$image = imagecreatefromjpeg($img_data);

	//回転角度
	$degrees = 0;
	switch($orientation) {
		case 1:		//回転なし（↑）
      break;
		case 8:		//右に90度（→）
			$degrees = 90;
			break;
		case 3:		//180度回転（↓）
			$degrees = 180;
			break;
		case 6:		//右に270度回転（←）
			$degrees = 270;
			break;
		case 2:		//反転（↑）
			$mode = IMG_FLIP_HORIZONTAL;
			break;
		case 7:		//反転して右90度s（→）
			$degrees = 90;
			$mode = IMG_FLIP_HORIZONTAL;
			break;
		case 4:		//反転して180度なんだけど縦反転と同じ（↓）
			$mode = IMG_FLIP_VERTICAL;
			break;
		case 5:		//反転して270度（←）
			$degrees = 270;
			$mode = IMG_FLIP_HORIZONTAL;
			break;
	}
	//反転(2,7,4,5)
	if (isset($mode)) {
		$image = imageflip($image, $mode);
	}
	//回転(8,3,6,7,5)
	if ($degrees > 0) {
		$image = imagerotate($image, $degrees, 0);
  }

  //回転させた状態で仮保存している
  ImageJPEG($image, $img_data);
  // ここで仮保存されていたものを指定のフォルダへ保存している
  move_uploaded_file($img_data,$filename);
	//メモリ解放
	imagedestroy($image);
}
?>