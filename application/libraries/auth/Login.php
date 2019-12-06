<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH . 'libraries/auth/Token.php');

class Login extends Token
{
   protected $login_failed = array('response' => 'Login Failed', 'status' => 200);
   protected $bad_request = array('response' => 'Bad Request', 'status' => 400);

   /**
    * @author Milad Rasoolian support@foxyntax.com
    *
    *
    * @param string $method
    * @return array of results, includes JWT or Error message.
    */
   public function autoload($method) {
      switch ($method) {
         case 'JWT': return $this->login_by_jwt(); break;
         default: return $this->bad_request;
      }
   }

   /**
    * @author Milad Rasoolian support@foxyntax.com
    *
    *
    * @return array of results, includes JWT or Error message.
    * @todo If it returns JWT, you can save JWT in local storage for use secure actions which need authenticate
    */
   private function login_by_jwt() {
      $col = $this->post['password'];
      $hash_pass = $this->select($col)
                        ->get_where($this->post['table'], $this->post['condition'])
                        ->row_array();

      if(password_verify($this->post['password'], $hash_pass[$col])) {
         $jwt = $this->generate_jwt($this->post['payload']);
         return array(
            'response'  => $jwt,
            'status'    => 200
         );
      }

      return $this->login_failed;

   }
}
