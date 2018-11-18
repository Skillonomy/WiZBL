<?php

namespace App\Http\Controllers\Api\WiZBL;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WiZBLController extends Controller
{

	private static function rpc($data)
	{

		$ch = curl_init();
			
		curl_setopt($ch, CURLOPT_URL, 'localhost');
		curl_setopt($ch, CURLOPT_PORT, 18724);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 300);
		curl_setopt($ch, CURLOPT_USERPWD, "test:123456");  
		//curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888'); // for capturing
		
		$head = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if (!curl_errno($ch)) {

			if ($httpCode != '200') {

				error_log('NETWORK ERROR: ' . $httpCode);

				return false;

			} else {

				$result = json_decode($head, true);

				if (json_last_error()) {

					error_log('JSON PARSE ERROR: '. json_last_error_msg());

					return false;

				} elseif (isset($result->error)) {

					error_log('WiZBL ERROR: '. $result->error);

					return false;

				} else {

					return $result;
				}

			}

		} else {

			error_log('cURL ERROR: ' . curl_error($ch));

			return false;

		}

		curl_close($ch);

	}

	private static function unlock($time = 5)
	{

		$data["jsonrpc"] = "1.0";
		$data["id"] = "test";
		$data["method"] = "walletpassphrase";
		$data["params"] = ["123456", $time];

		return self::rpc(json_encode($data));

	}

	private static function getnewaddress()
	{

		$data["jsonrpc"] = "1.0";
		$data["id"] = "test";
		$data["method"] = "getnewaddress";
		$data["params"] = [];

		return self::rpc(json_encode($data));

	}
 
	private static function setaccount($account, $name)
	{

		$data["jsonrpc"] = "1.0";
		$data["id"] = "test";
		$data["method"] = "setaccount";
		$data["params"] = [$account, $name];

		return self::rpc(json_encode($data));

	}

	private static function dumpprivkey($account)
	{

		$data["jsonrpc"] = "1.0";
		$data["id"] = "test";
		$data["method"] = "dumpprivkey";
		$data["params"] = [$account];

		return self::rpc(json_encode($data));

	}

	private static function importprivkey($key)
	{

		$data["jsonrpc"] = "1.0";
		$data["id"] = "test";
		$data["method"] = "importprivkey";
		$data["params"] = [$key];

		return self::rpc(json_encode($data));

	}

	public static function create($name = null)
	{

		$arr = [];

		// unlock wallet
		$unlock = self::unlock(60);

		// Create keys
		$addr = self::getnewaddress();

		$data = self::setaccount($addr['result'], $name);

		$key = self::dumpprivkey($addr['result']);

		$data = self::importprivkey($key['result']);

		$arr['wallet'] = $name;
		$arr['public'] = $addr['result'];
		$arr['private'] = $key['result'];

		return $arr;

	}

	public static function transfer($to, $comment)
	{

		$data["jsonrpc"] = "1.0";
		$data["id"] = "test";
		$data["method"] = "sendtoaddress";
		$data["params"] = [$to, 1, "donation", $comment];

		$unlock = self::unlock(60);
		
		return self::rpc(json_encode($data));

	}

}
