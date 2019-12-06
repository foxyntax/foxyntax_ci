<?php
header(ACCESS_CONTROL_ALLOW_ORIGIN);
header(ACCESS_CONTROL_REQUEST_METHOD);
header(CONTENT_TYPE);
header(ACCESS_CONTROL_ALLOW_HEADERS);

class Sessions extends CI_Controller
{
	protected $library = array('sessions/flashdata', 'sessions/sessdata', 'sessions/tempdata');
	protected $response, $method;

	public function __construct()
	{
		parent::__construct();
      $this->method = $this->config->item('auth_method');
		$this->load->library($this->library);
		$this->load->helper('http');
	}

   /**
    * @author Milad Rasoolian support@foxyntax.com
    * @api is http://YOUR_DOMAIN/api/sessions/sess/$type/$auth
    */
	public function sess($type, $auth = 0) {
      if($auth == 1) {
         $this->load->library('auth/tracking');
         $permission = $this->tracking->autoload($this->method);
         if($permission['response']) {
            $this->autoload($type);
         } else {
            api_responser('Unauthorized',401);
         }
      } else {
         $this->autoload($type);
      }
	}

	private function autoload($type) {
      switch ($type) {
         case 'session': $this->response = $this->sessdata->autoload(); break;
         case 'flash': $this->response = $this->flashdata->autoload(); break;
         case 'temp': $this->response = $this->tempdata->autoload(); break;
         default: api_responser('Not Implemented',501); return;
      }
   }
}
