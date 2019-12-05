<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*if ( ! function_exists('sms_sender'))
{
	function sms_sender($mobile, $config) {

		// This config is for farazsms.ir

		$url = "https://ippanel.com/services.jspd";

		$rcpt_nm = $mobile; // be array
		$param = array
		(
			'uname'		=> $config['user'],
			'pass'		=> $config['pass'],
			'from'		=> $config['from'],
			'message'	=> $config['msge'],
			'to'		=> json_encode($rcpt_nm),
			'op'		=> 'send'
		);

		$handler = curl_init($url);
		curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
		$response2 = curl_exec($handler);

		$response2 = json_decode($response2);
		$res_code = $response2[0];
		$res_data = $response2[1];


		echo $res_data;
	}
}*/


if ( ! function_exists('sms_sender'))
{
	function sms_sender($mobile, $token) {
		$ci =& get_instance();
		require_once(APPPATH.'libraries/unirest/Unirest.php');

		// This config is for https://api.kavenegar.com
		$url = 'https://api.kavenegar.com/v1/' . $ci->config->item('sms_key') . '/sms/send.json';
		$headers = array('Accept' => 'application/json');
		$message = <<<EOT
	به آلینا خوش امدید
	رمز امنیتی شما برای احراز هویت: $token
EOT;
		$params = array(
			'sender'	=> $ci->config->item('sms_from'),
			'message'	=> $message,
			'receptor'	=> $mobile,
			'type'		=> '1'
		);

		$unirest = new Unirest();
		$response = unirest::post($url, $headers, $params);
		return array(
			'status' 	=> $response->code,
			'response' 	=> $response->body,
		);
	}
}

