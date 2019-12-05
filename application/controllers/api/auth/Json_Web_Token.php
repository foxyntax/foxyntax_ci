<?php
	header(ACCESS_CONTROL_ALLOW_ORIGIN);
	header(ACCESS_CONTROL_REQUEST_METHOD);
	header(CONTENT_TYPE);
	header(ACCESS_CONTROL_ALLOW_HEADERS);

class Json_Web_Token extends CI_Controller
{
	protected $response;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('jwt', 'authorization', 'http', 'encrypt_file'));
		$this->load->library('secure/token');
	}

	public function index() {
		api_responser($this->token->test());

		/*$user = $this->token->check_api_key();
		if(! $user) {
			api_responser($this->token->generate()); return;
		}
		api_responser($user);*/
	}

	public function login() {
		$this->load->library('query/read');
		$this->response = $this->read->autoload();
		if($this->response['avatar'] == 1) {

		}
		/**
		 After check user and password, we must generate new token for user and send these information by token library:
		 * Username as user in vue
		 * Name as name in vue
		 * Family as family in vue
		 * Avatar Address as avatar in vue
		 * Grid as grid in vue
		 */
	}
}
