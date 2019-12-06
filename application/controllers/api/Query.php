<?php
header(ACCESS_CONTROL_ALLOW_ORIGIN);
header(ACCESS_CONTROL_REQUEST_METHOD);
header(CONTENT_TYPE);
header(ACCESS_CONTROL_ALLOW_HEADERS);

class Query extends CI_Controller
{
	protected $library = array('queries/create', 'queries/update', 'queries/read', 'queries/delete', 'queries/curd');
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
    * @api is http://YOUR_DOMAIN/api/query/curd/$type/$auth
    */
	public function curd($type, $auth = 0) {
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
         case 'create': $this->response = $this->create->autoload(); break;
         case 'update': $this->response = $this->update->autoload(); break;
         case 'read'  : $this->response = $this->read->autoload(); break;
         case 'delete': $this->response = $this->delete->autoload(); break;
         case 'custom': $this->response = $this->curd->query(); break;
         default: api_responser('Not Implemented',501); return;
      }
   }
}
