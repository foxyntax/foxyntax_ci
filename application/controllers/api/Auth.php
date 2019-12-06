<?php
   header(ACCESS_CONTROL_ALLOW_ORIGIN);
   header(ACCESS_CONTROL_REQUEST_METHOD);
   header(CONTENT_TYPE);
   header(ACCESS_CONTROL_ALLOW_HEADERS);

class Auth extends CI_Controller
{
   protected $method;

   public function __construct() {
      parent::__construct();
      $this->method = $this->config->item('auth_method');
      $this->load->helper(array('http'));

   }

   /**
    * @author Milad Rasoolian support@foxyntax.com
    * @api is http://YOUR_DOMAIN/api/auth/sign_up/
    */
   public function sign_up() {
      $this->load->library('auth/register');
      $sign_up = $this->register->autoload($this->method);
      api_responser($sign_up['response'], $sign_up['status']);
   }

   /**
    * @author Milad Rasoolian support@foxyntax.com
    * @api is http://YOUR_DOMAIN/api/auth/login/
    */
   public function login() {
      $this->load->library('auth/login');
      $login = $this->login->autoload($this->method);
      api_responser($login['response'], $login['status']);
   }


   /**
    * @author Milad Rasoolian support@foxyntax.com
    * @api is http://YOUR_DOMAIN/api/auth/check_token/
    */
   public function check_token() {
      $this->load->library('auth/tracking');
      $track = $this->tracking->autoload($this->method);
      api_responser($track['response'], $track['status']);
   }

}
