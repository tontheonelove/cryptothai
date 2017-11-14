<?php
$access_token = '8RoaweEYghpr9qq/kbPxI3K8NL4nQQw33ksOMGHoqJiFJZf7f1IonhS7nPM+j5dx6/1Ga9cm8c7in90FrdkxtC/aWTqI7uHe7bStyTozfyHLNQIS294lkLkHm9IZXBSvacmv7/yFYEivA79VYhTKygdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$list = array('bch'=>'bitcoin-cash','btc'=>'bitcoin','evx'=>'everex','eth'=>'ethereum');
			if($list[$text]){
				$json=json_decode(file_get_contents("https://api.coinmarketcap.com/v1/ticker/".$list[$text]."/?convert=THB"),true);
				$count=count($json);
				$text='';
				for($i=0;$i<$count;$i++){
					$text=$text+'เหรียญ : '.$json[$i]['name']."\nขึ้น-ลง 24 ชั่วโมง : ".$json[$i]['percent_change_24h']."\nราคาล่าสุด :".$json[$i]['price_thb']."\nVolume24ชั่วโมง :".$json[$i]['24h_volume_thb']."\n;
				}
			}
				
			$messages = [
				'type' => 'text',
				'text' => $text
				
			];
				

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
