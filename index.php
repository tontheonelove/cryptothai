<?php
    $content=file_get_contents("https://bx.in.th/api/");  // add your url which contains json file
    $json = json_decode($content, true);
   // print_R($json);
    $count=count($json);
    echo'<th>pairing_id</th><th>change</th><th>last_price</th><th>volume_24hours</th>';
    for($i=0;$i<$count;$i++)
    {
      echo'<tr><td>'.$json[$i]['pairing_id:1'].'</td><td>'.$json[$i]['change'].'</td><td>'.$json[$i]['last_price'].'</td><td>'.$json[$i]['volume_24hours'].'</td></tr>';
    }
  
  ?>
