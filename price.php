<?php
    $content=file_get_contents("https://api.coinmarketcap.com/v1/ticker/bitcoin-cash/?convert=THB");  // add your url which contains json file
    $json = json_decode($content, true);
   // print_R($json);
    $count=count($json);
    echo'<table><th>เหรียญ</th><th>ขึ้น-ลง</th><th>ราคาล่าสุด</th>';
    for($i=0;$i<$count;$i++)
    {
      echo'<tr><td>'.$json[$i]['name'].'</td><td>'.$json[$i]['percent_change_24h'].'</td><td>'.$json[$i]['price_thb'].'</td></tr>';
    }
   echo'</table>';
  ?>