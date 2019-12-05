<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH . 'libraries/queries/CURD.php');

class Delete extends CURD
{
	public function __construct() {
		parent::__construct();
	}

	public function autoload() {
		if(isset($this->post['func'])) {
			switch ($this->post['func']) {
				case 'empty' :
					return $this->empty_table();
				case 'truncate' :
					return $this->truncate_table();
				default:
					return $this->delete();
			}
		} else {
			return false;
		}
	}

	protected function empty_table() {
		$this->ci->db->empty_table($this->post['table']);
		return ($this->ci->db->affected_rows() == 0) ? false : true;
	}

	protected function truncate_table() {
		$this->ci->db->truncate($this->post['table']);
		return ($this->ci->db->affected_rows() == 0) ? false : true;
	}

	protected function delete() {
		$this->condition();
		$this->ci->db->delete($this->post['table']);
		return ($this->ci->db->affected_rows() == 0) ? false : true;
	}
}
