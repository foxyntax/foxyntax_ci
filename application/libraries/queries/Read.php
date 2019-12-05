<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH . 'libraries/queries/CURD.php');

class Read extends CURD
{
	public function __construct() {
		parent::__construct();
	}

	protected function check_null($property) {
		foreach ($property as $item) {
			if(isset($this->post[$item]) && $this->post[$item] != '') {
				$this->post[$item] = $this->post[$item];
			} else {
				$this->post[$item] = null;
			}
		}
	}

	public function autoload() {
		$this->check_null(array('limit', 'offset', 'responseType'));

		if(isset($this->post['func'])) {
			switch ($this->post['func']) {
				case 'join' :
					return $this->join();
				case 'count' :
					return $this->count();
				case 'selectSum':
					return $this->select_sum();
				case 'selectMax':
					return $this->select_max();
				case 'selectMin':
					return $this->select_min();
				case 'selectAvg':
					return $this->select_avg();
				case 'selectDis':
					return $this->select_distinct();
				default:
					return $this->select();
			}
		} else {
			return false;
		}
	}

	protected function join() {
		$this->ci->db->select($this->post['cols']);
		$this->ci->db->from($this->post['table']);
		foreach ( $this->post['join'] as $item) {
			$side = (property_exists($itme, 'type')) ? $item->type : NULL;
			$this->ci->db->join($item->table, $item->condition, $type);
		}
		$this->condition();
		$this->get(null, null, null, $this->post['responseType']);
		$this->after_query();
		return $this->response;
	}

	protected function count() {
		$this->condition();
		$response = $this->ci->db->count_all_results($this->post['table']);
		$this->after_query();
		return $response;
	}

	protected function select_sum() {
		$this->ci->db->select_sum($this->post['cols']);
		$this->condition();
		$this->get($this->post['table'], $this->post['limit'], $this->post['offset'], $this->post['responseType']);
		$this->after_query();
		return $this->response;
	}

	protected function select_max() {
		$this->ci->db->select_max($this->post['cols']);
		$this->condition();
		$this->get($this->post['table'], $this->post['limit'], $this->post['offset'], $this->post['responseType']);
		$this->after_query();
		return $this->response;
	}

	protected function select_min() {
		$this->ci->db->select_min($this->post['cols']);
		$this->condition();
		$this->get($this->post['table'], $this->post['limit'], $this->post['offset'], $this->post['responseType']);
		$this->after_query();
		return $this->response;
	}

	protected function select_avg() {
		$this->ci->db->select_avg($this->post['cols']);
		$this->condition();
		$this->get($this->post['table'], $this->post['limit'], $this->post['offset'], $this->post['responseType']);
		$this->after_query();
		return $this->response;
	}

	protected function select_distinct() {
		$this->ci->db->select($this->post['cols']);
		$this->ci->db->distinct();
		$this->condition();
		$this->get($this->post['table'], $this->post['limit'], $this->post['offset'], $this->post['responseType']);
		$this->after_query();
		return $this->response;
	}

	protected function select() {
		$this->ci->db->select($this->post['cols']);
		$this->condition();
		$this->get($this->post['table'], $this->post['limit'], $this->post['offset'], $this->post['responseType']);
		$this->after_query();
		return $this->response;
	}

}
