<?php
	function getIp() 
	{
		$keys = [
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'REMOTE_ADDR',
			'HTTP_CF_CONNECTING_IP'
		];
	  
		foreach($keys as $key) 
		{
			if(!empty($_SERVER[$key]) && ($exps = explode(',', $_SERVER[$key])))
			{
				$ip = trim($exps[count($exps) - 1]);
			  
				if(filter_var($ip, FILTER_VALIDATE_IP)) {
					return $ip;
				}
			}
		}
		
		return '';
	}
	
	if(true && isset($_SERVER) && isset($_SERVER['SERVER_NAME']))
	{
		$data = [
			'ip' => getIp(),
			'ua' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
			'ref' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
			'uri' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
			'img' => basename($_SERVER['REQUEST_URI']),
		];
		
		try 
		{
			if(true)
			{
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, 'https://zeland.vip/membrsdjf811/pixel_db.php');

				curl_setopt($ch, CURLOPT_TIMEOUT_MS, 250);
				
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, ['data' => base64_encode(json_encode($data))]);

				curl_exec($ch);	curl_close($ch);
			}

			if(false && is_dir(__DIR__ . '/pixels') && file_exists($fname = __DIR__ . '/pixels/' . md5($data['ip'] . $data['ua'] . $data['img'])) == false)
			{
				@file_put_contents($fname, json_encode($data));
				
				$msg  = "<b>ip:</b> <code>{$data['ip']}</code>\n";
				$msg .= "<b>ua:</b> <code>{$data['ua']}</code>\n";
				$msg .= "<b>rf:</b> <code>{$data['ref']}</code>\n";
				$msg .= "<b>im:</b> <code>{$data['img']}</code>";
				
				//оптравка в телеграмм
				foreach([837874300,940937945,365027885,6671000814,6456587851] as $chatId)
				{
					$params = [
						'text' => $msg,
						'parse_mode' => 'HTML',
						'disable_web_page_preview' => 'true',
						'chat_id' => $chatId,
					];
					
					file_get_contents("https://api.telegram.org/bot6832895383:AAErSTRYljv6f3riWfztnFMlBbASoQoxEjA" . http_build_query($params), false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
				}
			}
		} finally {
		}
	}
header('content-type: image/png');
header("content-length: " . filesize(__DIR__ . "/pixelll.png"));
header('cache-control: max-age=1');
readfile(__DIR__ . "/pixelll.png");exit;
?>