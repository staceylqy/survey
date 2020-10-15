<?php
// POSTを受け取る。
$name = $_POST['name'];
$grade = $_POST['grade'];
$comment = $_POST['comment'];


$str =  $name .'1' . $grade .'2' .  $comment;

//文字作成
$file = fopen("./data/data.txt", "a");

fwrite($file, $str . "\n");

fclose($file);


function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アンケート（受信）</title>
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

    <div class="result-content">
        <div class="result">
            <div class="resultTitle">登録した情報</div>
            <div class="result-info">
                <!-- お名前：<?= h($name) ?>
                総合評価：<?= h($grade) ?>
                自分の感想：<?= h($comment) ?> -->
                <div class="resultItem">
                    お名前：
                </div>
                <div class="resultAnswer">
                    <?= htmlspecialchars($name, ENT_QUOTES) ?>
                </div>
                
                <div class="resultItem">
                    総合評価：
                </div>
                <div class="resultAnswer">
                    <?= htmlspecialchars($grade, ENT_QUOTES) ?>
                </div>

                <div class="resultItem">
                    自分の感想：
                </div>
                <div class="resultAnswer">
                    <?= htmlspecialchars($comment, ENT_QUOTES) ?>
                </div>

            </div>
        
        </div>
    </div>

    <div class="button">
        <a class="buttonsetting" href="control.php">
            <button class="selectbutton">管理画面</button>
        </a>
    </div>
    
</body>


</html>


