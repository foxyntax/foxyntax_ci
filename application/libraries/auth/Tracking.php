<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH . 'libraries/auth/Token.php');

class Tracking extends Token
{
   protected $permit_failed = array('response' => false, 'status' => 401);
   protected $permit_accepted = array('response' => true, 'status' => 202);
   protected $bad_request = array('response' => 'Bad Request', 'status' => 400);

   /**
    * @author Milad Rasoolian support@foxyntax.com
    *
    *
    * @param string $method
    * @return array of results, includes JWT or Error message.
    * @todo in "JWT" case, if it returns $this->permit_accepted, you can give permission to user before actions like change routes.
    */
   public function autoload($method) {
      switch ($method) {
         case 'JWT': return ($this->check_jwt() === false) ? $this->permit_failed : $this->permit_accepted;
         default: return $this->bad_request;
      }
   }
}
