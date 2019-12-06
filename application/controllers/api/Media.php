<?php
header(ACCESS_CONTROL_ALLOW_ORIGIN);
header(ACCESS_CONTROL_REQUEST_METHOD);
header(CONTENT_TYPE);
header(ACCESS_CONTROL_ALLOW_HEADERS);

class Media extends CI_Controller
{
	protected $response, $method;

	public function __construct() {
		parent::__construct();
      $this->method = $this->config->item('auth_method');
		$this->load->helper(array('http', 'encrypt_file'));
	}

   /**
    * @author Milad Rasoolian support@foxyntax.com
    * @api is http://YOUR_DOMAIN/api/media/surf/$func/$name/$auth
    */
	public function surf($func, $name = 'img', $auth = 0) {
		if($auth == 1) {
         $this->load->library('auth/tracking');
		   $permission = $this->tracking->autoload($this->method);
		   if($permission['response']) {
            $this->autoload($func, $name);
         } else {
            api_responser('Unauthorized',401);
         }
		} else {
         $this->autoload($func, $name);
      }
	}

	private function autoload() {
      switch ($func) {
         case 'upload': {
            $this->load->library('media/uploader');
            $this->response = $this->uploader->upload_file($name);
            break;
         }
         case 'get_path': {
            $this->load->library('media/downloader');
            $this->response = $this->downloader->get_path_file();
            break;
         }
         case 'read': {
            $this->load->library('media/downloader');
            $this->response = $this->downloader->read_file();
            break;
         }
         case 'write': {
            $this->load->library('media/writer');
            $this->response = $this->writer->write_file();
            break;
         }
         case 'remove': {
            $this->load->library('media/remove');
            $this->response = $this->remove->remove_file();
            break;
         }
         case 'edit'    : $this->response = edit_file(); break;
         case 'generate': $this->response = regenerate_media_dir('auto'); break;
         default: api_responser('Not Implemented',501); return;
      }
      api_responser($this->response); return;
   }
}
