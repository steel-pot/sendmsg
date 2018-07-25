<?php
class MsgModel {
	static function sendMsg3($mobile,$content){
		$key=C('msg_key3');
		$secret=C('msg_secret3');
		$url="http://api.motosms.com/json?key={$key}&secret={$secret}&to=86{$mobile}&text=".urlencode($content);
		return file_get_contents($url);
	}
}