<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class token
{
	protected $ci, $post, $jwt;

	public function __construct() {
		$this->ci =& get_instance();
		$header = $this->input->request_headers();
		$this->jwt = (isset($header['Authorization'])) ? $header['Authorization'] : null;
	}

	protected function generate() {
		return AUTHORIZATION::generateToken($this->ci->config->item('api_key'));
	}

	protected function check_api_key() {
		try {
			$key = AUTHORIZATION::validateToken($this->jwt);
			if($key === $this->ci->config->item('api_key')) {
				return true;
			}
			return false;
		} catch (Exception $e) {
			return false;
		}
	}

	protected function sign_up() {
		// get info for ci_user
		// return api_key via generate
	}

	protected function login() {
		// check user and pass
		// return api_key via generate, if checking returned true
		// return false, if checking returned false
	}

	protected function check_logged_user() {
		// check existance of logged cookie and check isset jwt from client or not
		// check logged cookie or jwt, if cookie or jwt exist
		// return true, if cookie or jwt match with api_key
		// return false, if cookie or jwt doesn't exist or can't match with api_key
	}


}
