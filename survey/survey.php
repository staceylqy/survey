<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アンケート</title>
    <link rel="stylesheet" href="css/survey.css">
</head>
<body class="background">
  
  <div class="header">
    <div class="header-left">商品検索詳細ページ</div>
    <div class="header-right">
      <ul>
        <li class="selected">
        <a class="buttonsetting" href="survey.php">
            <button class="selectbutton">感想共有</button>
        </a>
        </li>
          
        <li style="border-bottom: none;">
        <a class="buttonsetting" href="control.php">
            <button class="selectbutton">管理画面</button>
        </a>
        </li>
      </ul>
    </div>
   </div>

    <div class = "exhibitIntro">
      <?php
        $rakuten_relust = getRakutenResult('【新品】　進撃の巨人/Vita', 2000); // キーワードと最低価格を指定
        foreach ($rakuten_relust as $item) :
      ?>
      
      <div class = "exhibitIntro" style=' width: 70%; padding: 50px;margin-top:80px; margin-bottom: 20px; padding: 30px; border: 1px solid #c62a88; overflow:hidden; margin-left:auto;margin-right:auto;'>
      <div style='float: left;'><img src='<?php echo $item['img']; ?>'></div>
      　<div style='float: left; padding: 20px;'>
          <div><?php echo $item['name']; ?></div>
          <div><a href='<?php echo $item['url']; ?>' target="_blank"><?php echo $item['url']; ?></a></div>
          <div><?php echo $item['price']; ?>円</div>
          <div><?php echo $item['shop']; ?></div>
          <div><?php echo $item['info']; ?></div>
        </div>
      </div>
      <?php
      endforeach;
      ?>
    </div>

  <div class="share">
    <div class="form">
      <div class="form-title">感想共有</div>
      <div class="survey">
        <form action="sent.php" method="post">
          <div class="form-item">お名前</div>
          <input type="text" name="name" >

          <div class="form-item">この商品の総合評価</div>
        <?php 
          $types = array('非常に満足　☆☆☆☆☆', 'やや満足　☆☆☆☆', 'どちらともいえない　☆☆☆', 'やや不満　☆☆', '非常に不満　☆', 'わからない');
         ?>
     
        <select name = 'grade' >
          <option value = '未選択'>選択してください</option>
          <?php
          foreach($types as $type){
            echo "<option value='$type'>$type</option>";
          }
          ?>
        </select>
        <div class="form-item">ここに自分の感想を書いてください</div>
        <textarea name="comment"></textarea>
     
          <input id="send" type="submit" value="送信">
        </form>
      </div>

    </div>
  </div>

    
</body>

</html>

<?php 

function getRakutenResult($keyword, $min_price) {

// ベースとなるリクエストURL
$baseurl = 'https://app.rakuten.co.jp/services/api/IchibaItem/Search/20140222';
// リクエストのパラメータ作成
$params = array();
$params['applicationId'] = '1015017304057811343'; // アプリID
$params['keyword'] = urlencode_rfc3986($keyword); // 任意のキーワード。※文字コードは UTF-8
$params['sort'] = urlencode_rfc3986('+itemPrice'); // ソートの方法。※文字コードは UTF-8
$params['minPrice'] = $min_price; // 最低価格

$canonical_string='';

foreach($params as $k => $v) {
    $canonical_string .= '&' . $k . '=' . $v;
}
// 先頭の'&'を除去
$canonical_string = substr($canonical_string, 1);

// リクエストURL を作成
$url = $baseurl . '?' . $canonical_string;

// XMLをオブジェクトに代入
$rakuten_json=json_decode(@file_get_contents($url, true));

$items = array();
foreach($rakuten_json->Items as $item) {
    $items[] = array(
                    'name' => (string)$item->Item->itemName,
                    'url' => (string)$item->Item->itemUrl,
                    'img' => isset($item->Item->mediumImageUrls[0]->imageUrl) ? (string)$item->Item->mediumImageUrls[0]->imageUrl : '',
                    'price' => (string)$item->Item->itemPrice,
                    'shop' => (string)$item->Item->shopName,
                    'info'=> (string)$item->Item->catchcopy
                    );
}

return $items;
}

// RFC3986 形式で URL エンコードする関数
function urlencode_rfc3986($str) {
    return str_replace('%7E', '~', rawurlencode($str));
}?>

