<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

$access_token = 'OZeZzMfGJ/s4DIIrTz5zsFO255FajuHurfGTjZH46Yjafzqm0g0b8W1c0VDsgud79Q1uiomjpnQ4FGYliCgEAe7WvRh9mB2LPKj1RDGoV6ZcUDpu8OrAR4aUtkBi/9CAS4CSQBJ1L2ZL9Ml19Id6wQdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data


use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
//use LINE\LINEBot\Event;
//use LINE\LINEBot\Event\BaseEvent;
//use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;

use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;

use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text' && $event['message']['text'] == 'mid') {
			// Get text sent

				
			$text = $event['source']['userId'];
				//['userId'];
			// Get replyToken
			$replyToken = $event['replyToken'];
 
			// Build message to reply back
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
		}else{
			                        // กำหนด action 4 ปุ่ม 4 ประเภท
									$actionBuilder = array(
										new MessageTemplateActionBuilder(
											'Message Template',// ข้อความแสดงในปุ่ม
											'This is Text' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
										),
										new UriTemplateActionBuilder(
											'Uri Template', // ข้อความแสดงในปุ่ม
											'https://www.ninenik.com'
										),
										new DatetimePickerTemplateActionBuilder(
											'Datetime Picker', // ข้อความแสดงในปุ่ม
											http_build_query(array(
												'action'=>'reservation',
												'person'=>5
											)), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
											'datetime', // date | time | datetime รูปแบบข้อมูลที่จะส่ง ในที่นี้ใช้ datatime
											substr_replace(date("Y-m-d H:i"),'T',10,1), // วันที่ เวลา ค่าเริ่มต้นที่ถูกเลือก
											substr_replace(date("Y-m-d H:i",strtotime("+5 day")),'T',10,1), //วันที่ เวลา มากสุดที่เลือกได้
											substr_replace(date("Y-m-d H:i"),'T',10,1) //วันที่ เวลา น้อยสุดที่เลือกได้
										),      
										new PostbackTemplateActionBuilder(
											'Postback', // ข้อความแสดงในปุ่ม
											http_build_query(array(
												'action'=>'buy',
												'item'=>100
											)) // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
				//                          'Postback Text'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
										),      
									);
									$imageUrl = 'https://www.mywebsite.com/imgsrc/photos/w/simpleflower';
									$replyData = new TemplateMessageBuilder('Button Template',
										new ButtonTemplateBuilder(
												'button template builder', // กำหนดหัวเรื่อง
												'Please select', // กำหนดรายละเอียด
												$imageUrl, // กำหนด url รุปภาพ
												$actionBuilder  // กำหนด action object
										)
									); 
									
									$text = $event['source']['userId'];
									//['userId'];
								// Get replyToken
								$replyToken = $event['replyToken'];
					 
								// Build message to reply back
								$messages = [
									'type' => 'text',
									'text' => $text
								];
					
								// Make a POST Request to Messaging API to reply to sender
								$url = 'https://api.line.me/v2/bot/message/reply';
								$data = [
									'replyToken' => $replyToken,
									'messages' => $replyData,
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
