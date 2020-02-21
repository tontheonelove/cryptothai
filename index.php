<?php
$access_token = 'p3tMahpMNaNoL1CGZqubvt0ni1Q1t1SwTPFvuv+QmWMPBBo+OWLSGL1KHp4cQLeruzpmctPp1abnfkTAqCZtu9ntMkEJg3aM/zMe8gv0I1WkX4nzwFO1zr8EvtLi8Qc1DF6faY5jYcvQNU5+5RQFIQdB04t89/1O/w1cDnyilFU=';

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
			$list = array('bch'=>'bitcoin-cash','btc'=>'bitcoin','evx'=>'everex','eth'=>'ethereum','omg'=>'omisego','zec'=>'zcash','xrp'=>'ripple','ltc'=>'litecoin','gno'=>'gnosis-gno','dash'=>'dash','neo'=>'neo','xmr'=>'monero','etc'=>'ethereum-classic','rep'=>'augur','rcn'=>'ripio-credit-network','xzc'=>'zcoin','waves'=>'waves','doge'=>'dogecoin','btg'=>'bitcoin-gold','ada'=>'cardano','trx'=>'tron','iota'=>'iota','xem'=>'nem','xlm'=>'stellar','eos'=>'eos','qtum'=>'qtum','bnb'=>'binance coin');
			if($list[$text]){
				$json=json_decode(file_get_contents("https://api.coinmarketcap.com/v1/ticker/".$list[$text]."/?convert=THB"),true);
				$count=count($json);
				$text='';
				for($i=0;$i<$count;$i++){
					$text=$text+'เหรียญ : '.$json[$i]['name']."\nอันดับของโลก :".$json[$i]['rank']."\nอัตราขึ้น-ลง วันนี้ : ".$json[$i]['percent_change_24h']."\nราคา(บาท) :".$json[$i]['price_thb']."\nราคา(BTC) :".$json[$i]['price_btc']."\nราคา(USD) :".$json[$i]['price_usd']."\nVolume วันนี้ :".$json[$i]['24h_volume_thb']."\n";
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
}
echo "OK";
