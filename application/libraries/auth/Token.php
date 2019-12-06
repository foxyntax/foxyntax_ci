<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH . 'controllers/api/Auth.php');

class Token
{
	protected $ci, $post, $jwt;

	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->helper('jwt', 'authorization');
      $this->post = (array) json_decode($this->ci->input->raw_input_stream);
		$header = $this->ci->input->request_headers();
		$this->jwt = (isset($header['Authorization'])) ? $header['Authorization'] : null;
	}

   /**
    * @param array $data
    * @return string
    */
	protected function generate_jwt($data = array()) {
      (array) $data['api_key'] = password_hash($this->ci->config->item('api_key'), PASSWORD_ARGON2I);
		return AUTHORIZATION::generateToken($data);
	}

   /**
    * @return bool|object
    */
	protected function check_jwt() {
		try {
			$data = AUTHORIZATION::validateToken($this->jwt);
			if(! $data) {
				return false;
			} else if(password_verify($this->ci->config('ap_key'), $data['api_key'])) {
			   return $data;
         }
			return false;
		} catch (Exception $e) {
			return false;
		}
	}

	/*

	protected function check_logged_user() {
		// check existance of logged cookie and check isset jwt from client or not
		// check logged cookie or jwt, if cookie or jwt exist
		// return true, if cookie or jwt match with api_key
		// return false, if cookie or jwt doesn't exist or can't match with api_key
	}*/


}
