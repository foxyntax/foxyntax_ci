<?php
header(ACCESS_CONTROL_ALLOW_ORIGIN);
header(ACCESS_CONTROL_REQUEST_METHOD);
header(CONTENT_TYPE);
header(ACCESS_CONTROL_ALLOW_HEADERS);

class Media extends CI_Controller
{
	protected $response;

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('http', 'encrypt_file'));
		$this->load->library('secure/token');
	}

	public function surf($func, $name = 'img') {
		if($this->token->check_api_key()) {
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
				default: api_responser('درخواست شما قابل اجرا نیست', 501); return;
			}
			api_responser($this->response); return;
		} else {
			api_responser('احراز صلاحیت شبکه مورد نیاز است',511);
		}
	}
}
