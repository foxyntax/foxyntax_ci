<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flashdata
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
				case 'addFlash' : return $this->add_flash();
				case 'readFlash' : return $this->read_flash();
				case 'keepFlash' : return $this->keep_flash();
				default: return $this->unset_flash();
			}
		} else {
			return false;
		}
	}

	protected function add_flash() {
		$this->ci->session->set_flashdata($this->post['flash']);
	}

	protected function read_flash() {
		if(isset($this->post['flash'])) {
			return $this->ci->session->flashdata($this->post['flash']);
		} else {
			return $this->ci->session->flashdata();
		}
	}

	protected function keep_flash() {
		$this->ci->session->keep_flashdata($this->post['flash']);
	}

	protected function unset_flash() {
		$this->ci->session->unset_userdata($this->post['flash']);
	}
}
