<?php
final class Gateway
{
	static public function recvRequest($httpMethod, $httpBody, &$request, &$errorMsg)
	{
		if($httpMethod != 'POST'){
			$errorMsg = 'please use http post';
			return;
		}

		if(strlen($httpBody) <= 0){
			$errorMsg = 'post data can not be empty';
			return;
		}

		$jsonData = json_decode($httpBody, true);

		if(json_last_error() != JSON_ERROR_NONE){
			$errorMsg = 'post data is not a json string';
			return;
		}

		if(!(array_key_exists('op', $jsonData) && array_key_exists('data', $jsonData))){
			$errorMsg = 'post data format error';
			return;
		}

		$request = new Request($jsonData['op'], $jsonData['data']);
	}

	static public function sendResponse($response)
	{
		exit(json_encode($response));
	}
}