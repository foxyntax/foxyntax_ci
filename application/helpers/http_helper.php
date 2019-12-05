<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('request_method'))
{
	function request_method()
	{
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'POST': return 'POST';
			case 'GET': return 'GET';
			case 'UPDATE': return 'UPDATE';
			case 'DELETE': return 'DELETE';
			case 'PUSH': return 'PUSH';
			case 'PUT': return 'PUT';
			case 'PATCH': return 'PATCH';
		}
	}
}

if ( ! function_exists('set_response_header'))
{
	function set_response_header($status = 200, $type = 'application/json')
	{
		$ci =& get_instance();
		$ci->output
			->set_status_header($status)
			->set_content_type($type);

		// this is guid for you about http response code:
		/*
		 * | 100: Continue
		 * | 101 Switching Protocols
		 * | 102 Processing
		 * | 200 OK !
		 * | 201 Created
		 * | 202 Accepted
		 * | 203 Non-Authoritative Information
		 * | 204 No Content
		 * | 205 Reset Content
		 * | 206 Partial Content
		 * | 207 Multi-Status
		 * | 300 Multi Choices
		 * | 301 Moved Permanently
		 * | 302 Found
		 * | 303 See other
		 * | 304 Not Modified
		 * | 305 Use Proxy
		 * | 307 Temporary Redirect
		 * | 308 Permanent Redirect
		 * | 400 Bad Request
		 * | 401 Unauthorized
		 * | 402 Payment Required
		 * | 403 Forbidden
		 * | 404 Not Found
		 * | 405 Method Not Allowed
		 * | 406 Not Acceptable
		 * | 407 Proxy Authentication Required
		 * | 408 Request Time-out
		 * | 409 Conflict
		 * | 410 Gone
		 * | 411 Length Required
		 * | 412 Precondition Failed
		 * | 413 Request Entity Too Large
		 * | 414 Request URI Too Large
		 * | 415 Unsupported Media Type
		 * | 416 Request Range Not Satisfiable
		 * | 417 Expectation Failed
		 * | 421 Misdirected Request
		 * | 422 Unprocessable Entity
		 * | 423 Locked
		 * | 424 Failed Dependency
		 * | 425 Unordered Collection
		 * | 426 Upgrade Required
		 * | 428 Precondition Required
		 * | 429 Too Many Requests
		 * | 431 Request Header Fields Too Large
		 * | 451 Unavailable For Legal Reasons
		 * | 500 Internal Server Error
		 * | 501 Not Implemented
		 * | 502 Bad Gateway
		 * | 503 Service Unavailable
		 * | 504 Gateway Time-out
		 * | 505 HTTP Version Not Supported
		 * | 506 Variant Also Negotiates
		 * | 507 Insufficient Storage
		 * | 508 Loop Detected
		 * | 510 Not Extended
		 * | 511 Network Authentication Required
		 */
	}
}

if ( ! function_exists('api_responser'))
{
	function api_responser($output, $status = 200, $type = 'application/json')
	{
		set_response_header($status, $type);
		echo json_encode(array(
			'output' => $output
		), JSON_UNESCAPED_UNICODE);
	}
}

if ( ! function_exists('user_metadata'))
{
	function user_metadata()
	{
		$ci =& get_instance();
		if ($ci->agent->is_browser()) {
			$agent = $ci->agent->browser().' '.$ci->agent->version();
		} elseif ($ci->agent->is_robot()) {
			$agent = $ci->agent->robot();
		} elseif ($ci->agent->is_mobile()) {
			$agent = $ci->agent->mobile();
		} else {
			$agent = 'Unidentified User Agent';
		}

		$platform = $this->agent->platform();

		echo json_encode(array(
			'user_aganet' 	=> $ci->input->user_agent(),
			'device' 		=> $agent,
			'platform' 		=> $platform,
			'ip'				=> htmlspecialchars($_SERVER['REMOTE_ADDR'])
		), JSON_UNESCAPED_UNICODE);
	}
}
