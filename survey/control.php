<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面</title>
    <link rel="stylesheet" href="css/survey.css">
</head>
<body>
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
            <div class="resultTitle">顧客様登録した情報</div>
            
            
            
            <div class="result-info">
            <table id="table1"  border="1" cellpadding="10" >
            　<tr>
              　<th class="lione">お名前</th>
                <th class="litwo">総合評価</th>
                <th class="lithree">感想</th>
             </tr>
          <!-- </table> -->
              <?php
                // CSV
                
           
                // ファイルを開く
                $openFile = fopen('./data/data.txt','r');
                // ファイル内容を1行ずつ読み込んで出力
                while($str = fgets($openFile)){
                 
                  // echo nl2br($str);
                  $name=substr($str,0,strpos($str, '1'));
                  $comment=substr($str,strpos($str, '2')+1);
                  $gradeOne=substr($str,0,strpos($str, '2'));
                  $grade=substr($gradeOne,strpos($str, '1')+1);

              
                  $td_width = floor(100 / $cols)."%";
                  $tab_str = "<table id=\"table1\" border=\"1\" width=\"100%\" border-collapse=\"collapse\" text-align=\"center\">\n";

              
                      $tab_str.="<tr>\n";

                      $tab_str.= "<td width=15%>$name</td>\n";
                      $tab_str.= "<td width=25%>$grade</td>\n";
                      $tab_str.= "<td width=60%>$comment</td>\n";

                      $tab_str.="</tr>\n";
                  
                  $tab_str.="</table>\n";

                  print $tab_str;
                  // echo nl2br('<tr><td class="lione">'.$name.'</td><td class="litwo">'.$grade.'</td><td class="lithree">'.$comment.'</td></tr>');
                  
                 
                    // echo nl2br($name);
                    // echo nl2br($grade);
                    // echo nl2br($comment);
                }
                // ファイルを閉じる
                fclose($openFile);

              ?>
          </table>
            
            </div>
        
        </div>
    </div>
    
  

    <!--Piechart  -->
    <div id="piechart" style="width:900px;height:500px;">

    </div>

  

</body>




<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      
      

      function drawChart() {

        <?php
                $lone = 0;
                $ltwo = 0;
                $lthree = 0;
                $lfour = 0;
                $lfive = 0;

                // ファイルを開く
                $openFile = fopen('./data/data.txt','r');
                // ファイル内容を1行ずつ読み込んで出力
                while($str = fgets($openFile)){
                 

                  $gradeOne=substr($str,0,strpos($str, ' '));
                  $grade=substr($gradeOne,strpos($str, '1')+1);
                  
                  
                  if(strpos($str, "非常に満足")!== false){
                    $lone += 1;
                    
                  }else if(strpos($str, "やや満足")!== false){
                    $ltwo += 1;
                  }else if(strpos($str, "どちらともいえない")!== false){
                    $lthree += 1;
                  }else if(strpos($str, "やや不満")!== false){
                    $lfour += 1;
                  }else if(strpos($str, "非常に不満足")!== false){
                    $lfive += 1;
                  }

      

                }
                // ファイルを閉じる
                fclose($openFile);
                
              ?>
       


        // Piechart
        let a = "<?=$lone;?>";
        let b = "<?=$ltwo;?>";
        let c = "<?=$lthree;?>";
        let d = "<?=$lfour;?>";
        let e = "<?=$lfive;?>";

        var data = google.visualization.arrayToDataTable([
          
            ['総合評価' , '評価人数'],
            ['非常に満足' , parseInt(a)],
            ['やや満足' , parseInt(b)],
            ['どちらともいえない' ,parseInt(c)],
            ['やや不満' , parseInt(d)],
            ['非常に不満' ,parseInt(e)]
        ]);

        var options = {
          title: '顧客の総合評価'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }

       
      
    </script>

</html>