<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessdata
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
				case 'addSess' : return $this->add_sess();
				case 'readSess' : return $this->read_sess();
				case 'checkSess' : return $this->check_sess();
				case 'destroy'   : return $this->destroy();
				default : return $this->unset_sess();
			}
		} else {
			return false;
		}
	}

	protected function add_sess() {
		$this->ci->session->set_userdata($this->post['sess']);
	}

	protected function read_sess() {
		if(isset($this->post['sess'])) {
			return $this->ci->session->userdata($this->post['sess']);
		} else {
			return $this->ci->session->userdata();
		}
	}

	protected function check_sess() {
		return $this->ci->session->has_userdata($this->post['sess']);
	}

	protected function destroy() {
		$this->ci->session->sess_destroy();
	}

	protected function unset_sess() {
		$this->ci->session->unset_userdata($this->post['sess']);
	}
}
