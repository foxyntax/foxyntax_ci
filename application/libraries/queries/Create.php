<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH . 'libraries/queries/CURD.php');

class Create extends CURD
{
	public function __construct() {
		parent::__construct();
		$this->before_query();
	}

	public function autoload() {
		if(isset($this->post['func'])) {
			switch ($this->post['func']) {
				case 'insertBatch' :
					return $this->batch();
				default:
					return $this->insert();
			}
		} else {
			return false;
		}
	}

	protected function batch() {
		$this->ci->db->insert_batch($this->post['table'], $this->post['row']);
		return ($this->ci->db->affected_rows() == 0) ? false : true;
	}

	protected function insert() {
		$this->ci->db->insert($this->post['table'], $this->post['row']);
		return ($this->ci->db->affected_rows() == 0) ? false : true;
	}
}
