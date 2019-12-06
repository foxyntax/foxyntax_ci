<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH . 'controllers/api/Auth.php');


class Register extends Token
{

   protected $user_exists = array('response' => 'User Exists', 'status' => 200);
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
         case 'JWT': return $this->sign_by_jwt(); break;
         default: return $this->bad_request;
      }
   }

   /**
    * @author Milad Rasoolian support@foxyntax.com
    *
    *
    * @return array of results, includes JWT or Error message.
    * @todo If it returns JWT, you can use query library to save user or admin information and save JWT in local storage for use secure actions which need authenticate
    */
   private function sign_by_jwt() {
      $check = $this->ci->db  ->select($this->post['check'])
                              ->get_where($this->post['table'], $this->post['condition'])
                              ->num_rows();

      if($check !== 0) {
         $jwt = $this->generate_jwt($this->post['payload']);
         return array(
            'response'  => $jwt,
            'status'    => 200
         );
      }

      return $this->user_exists;

   }
}
