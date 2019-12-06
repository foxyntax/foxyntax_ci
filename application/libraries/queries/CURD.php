<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH . 'libraries/queries/Customize_Lib.php');

class CURD extends Customizer
{
	protected $ci, $response, $where, $order, $have, $like, $syntax;

	public function __construct() {
		$this->ci =& get_instance();
		$this->post = (array) json_decode($this->ci->input->raw_input_stream);
		$this->ci->load->library('jdf');
		$this->check_cols();
		$this->decoder(array('row', 'join', 'where', 'order', 'have', 'like'));
		$this->check_conditions();
		if(! $this->syntax) {
			return false;
		}
	}

	protected function check_cols() {
		if(! isset($this->post['cols'])) {
			$this->post['cols'] = '*';
		}
	}

	protected function decoder($items) {
		foreach ($items as $item) {
			if(isset($this->post[$item]) && is_string($this->post[$item])) {
				$this->post[$item] = json_decode($this->post[$item]);
			}
		}
	}

	protected function check_conditions() {
		$this->where = (isset($this->post['where'])) ? $this->post['where'] : null;
		$this->order = (isset($this->post['order'])) ? $this->post['order'] : null;
		$this->have  = (isset($this->post['have'])) ? $this->post['have'] : null;
		$this->like  = (isset($this->post['like'])) ? $this->post['like'] : null;
		if(is_object($this->where) || is_object($this->order) || is_object($this->have) || is_object($this->like)) {
			$this->syntax = false;
		}
	}

	public function query() {
		if($this->post['result']) {
			$response = $this->ci->db->query($this->post['query']);
			return $response;
		} else {
			$this->ci->db->query($this->post['query']);
			return ($this->ci->db->affected_rows() == 0) ? false : true;
		}
	}

	protected function condition() {
		if(! is_null($this->where)) {
			foreach ($this->where as $cond) {
				if(property_exists($cond, 'combine')) {
					if($cond->combine == 'or') {
						$this->ci->db->or_where($cond->query);
					} else {
						$this->ci->db->where($cond->query);
					}
				} else {
					$this->ci->db->where($cond->query);
				}
			}
		}

		if(! is_null($this->order)) {
			foreach ($this->order as $cond) {
				$this->ci->db->order_by($cond->col, $cond->val);
			}
		}

		if(! is_null($this->have)) {
			foreach ($this->have as $cond) {
				if(property_exists($cond, 'combine')) {
					if($cond->combine === 'or') {
						$this->ci->db->or_having( (string) $cond->query);
					} else {
						$this->ci->db->having( (string) $cond->query);
					}
				} else {
					$this->ci->db->having( (string) $cond->query);
				}
			}
		}

		if(! is_null($this->like)) {
			$field = (property_exists($this->post['like'], 'field')) ? $this->post['like']->field : null;
			$match = (property_exists($this->post['like'], 'match')) ? $this->post['like']->match : null;
			$side = (property_exists($this->post['like'], 'side')) ? $this->post['like']->side : null;
			$comb = (property_exists($this->post['like'], 'combine')) ? $this->post['like']->combine : 'and';
			if(! is_null($field) || ! is_null($match)) {
				if($comb === 'or') {
					$this->ci->db->or_like($field, $match, $side);
				} else {
					$this->ci->db->or_like($field, $match, $side);
				}
			} else {
				return;
			}
		}
	}

	protected function get($tablename = null, $limit = null, $offset = null, $type) {
		$get = (is_null($tablename)) ? $this->ci->db->get() : $this->ci->db->get($tablename, $limit, $offset);
		switch ($type) {
			case 'row' : 			$this->response = $get->row(); break;
			case 'rowArray' : 	$this->response = $get->row_array(); break;
			case 'resultArray' : $this->response = $get->result_array(); break;
			case 'numRows' : 		$this->response = $get->num_rows(); break;
			default : 				$this->response = $get->result();
		}
	}

}
