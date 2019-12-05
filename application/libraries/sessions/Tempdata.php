<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tempdata
{
	protected $ci, $post;

	public function __construct()
	{
		$this->ci =& get_instance();
		$this->post = (array) json_decode($this->ci->input->raw_input_stream);
		$this->ci->load->library('session');
	}

	public function autoload() {
		if(isset($this->post['func'])) {
			switch ($this->post['func']) {
				case 'addTemp' : return $this->add_temp();
				case 'readTemp' : return $this->read_temp();
				default: return $this->unset_temp();
			}
		} else {
			return false;
		}
	}

	protected function add_temp() {
		$this->ci->session->set_tempdata($this->response['temp'], null, $this->response['expire']);
	}

	protected function read_temp() {
		if(isset($this->post['temp'])) {
			return $this->ci->session->tempdata($this->post['temp']);
		} else {
			return $this->ci->session->tempdata();
		}
	}

	protected function unset_temp() {
		$this->ci->session->unset_tempdata($this->post['temp']);
	}
}
