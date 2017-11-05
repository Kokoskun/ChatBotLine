<?php
class MessageController{
	private $access_token='zGIMjMg6cuW8fSNj7lMxSTnC75BD3nt9jaJxpJK3dMxvHmMX0jhkwuxlZFJA9EK0VhAMRi3Hbx1d5Pglty7ro542/RtVzD0U+y08a+6e3hBOLD9mLnK2lWUHYcrRJO+y10fWxMTs+Yj141SnwdSE9wdB04t89/1O/w1cDnyilFU=';
    public function getMessage(){
		header('Content-Type: text/html; charset=utf-8');
		$content=file_get_contents('php://input');
		$events=json_decode($content,true);
		if(!is_null($events['events'])) {
			foreach($events['events'] as $event){
				if($event['type']=='message'&&$event['message']['type']=='text'){
					$text = $event['message']['text'];
					$replyToken = $event['replyToken'];
					$json_output=json_decode($text,true);
					$status=strpos($json_output,'hi');
					if($status!==FALSE){
						$textSend="Hello";
					}else{
						$textSend="ฉันไม่รู้จัก";
					}
					$this->sendMessage($textSend,$replyToken);
					break;
				}
			}
		}
    }

    public function sendMessage($textSend,$replyToken){
		$messages=[
			'type'=>'text',
			'text'=>$textSend
		];
		$url='https://api.line.me/v2/bot/message/reply';
		$data=[
			'replyToken'=>$replyToken,
			'messages'=>[$messages]
		];
		$post=json_encode($data);
		$headers=array('Content-Type: application/json','Authorization: Bearer '.$this->access_token);
		$ch=curl_init($url);
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
		curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_exec($ch);
		curl_close($ch);
    }
}