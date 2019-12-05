<?php
header(ACCESS_CONTROL_ALLOW_ORIGIN);
header(ACCESS_CONTROL_REQUEST_METHOD);
header(CONTENT_TYPE);
header(ACCESS_CONTROL_ALLOW_HEADERS);

class Query extends CI_Controller
{
	protected $library = array('secure/token' ,'queries/create', 'queries/update', 'queries/read', 'queries/delete', 'queries/curd');
	protected $response;

	public function __construct()
	{
		parent::__construct();
		$this->load->library($this->library);
		$this->load->helper('http');
	}

	public function curd($type) {
		if($this->token->check_api_key()) {
			switch ($type) {
				case 'create': $this->response = $this->create->autoload(); break;
				case 'update': $this->response = $this->update->autoload(); break;
				case 'read'  : $this->response = $this->read->autoload(); break;
				case 'delete': $this->response = $this->delete->autoload(); break;
				case 'custom': $this->response = $this->curd->query(); break;
				default: api_responser('درخواست شما قابل اجرا نیست', 501); return;
			}
			api_responser($this->response); return;
		} else {
			api_responser('احراز صلاحیت شبکه مورد نیاز است', 511);
		}
	}
}
