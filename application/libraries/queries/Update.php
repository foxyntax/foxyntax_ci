<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH . 'libraries/queries/CURD.php');

class Update extends CURD
{
	public function __construct() {
		parent::__construct();
		parent::before_query();
	}

	public function autoload() {
		if(isset($this->post['func'])) {
			switch ($this->post['func']) {
				case 'updateBatch' :
					return $this->batch();
				default:
					return $this->update();
			}
		} else {
			return false;
		}
	}

	protected function batch() {
		$this->condition();
		$this->ci->db->update_batch($this->post['table'], (array) $this->post['row']);
		return ($this->ci->db->affected_rows() == 0) ? false : true;
	}

	protected function update() {
		$this->condition();
		$this->ci->db->update($this->post['table'], (array) $this->post['row']);
		return ($this->ci->db->affected_rows() == 0) ? false : true;
	}

}
