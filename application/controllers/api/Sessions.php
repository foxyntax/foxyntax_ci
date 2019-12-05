<?php
header(ACCESS_CONTROL_ALLOW_ORIGIN);
header(ACCESS_CONTROL_REQUEST_METHOD);
header(CONTENT_TYPE);
header(ACCESS_CONTROL_ALLOW_HEADERS);

class Sessions extends CI_Controller
{
	protected $library = array('secure/token','sessions/flashdata', 'sessions/sessdata', 'sessions/tempdata');
	protected $response;

	public function __construct()
	{
		parent::__construct();
		$this->load->library($this->library);
		$this->load->helper('http');
	}

	public function sess($type) {
		if($this->token->check_api_key()) {
			switch ($type) {
				case 'session': $this->response = $this->sessdata->autoload(); break;
				case 'flash': $this->response = $this->flashdata->autoload(); break;
				case 'temp': $this->response = $this->tempdata->autoload(); break;
				default: api_responser('درخواست شما قابل اجرا نیست',501);
			}
			api_responser($this->response); return;
		} else {
			api_responser('احراز صلاحیت شبکه مورد نیاز است', 511); return;
		}
	}
}
