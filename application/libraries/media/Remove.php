<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remove
{
	protected $ci, $post, $subject;
	public function __construct() {
		$this->ci =& get_instance();
		$this->post = (array) json_decode($this->ci->input->raw_input_stream);
	}

	public function remove_file() {
		if($this->get_type_dir()) {
			$this->get_subject_dir();
			$dir = $this->ci->config->item('base_media_dir') . DIRECTORY_SEPARATOR . $this->post['type'] . $this->subject;
			unlink($dir);
			if(! file_exists($dir)) {
				$this->ci->db	->where('id', $this->post['id'])
									->delete('ci_media');
				return ($this->ci->db->affected_rows() == 0) ? false : 'فایل مورد نظر حذف شد.';
			}
			return false;
		}
		return false;
	}

	protected function get_type_dir() {
		switch ((int) $this->post['type']) {
			case 1: $this->post['type'] = 'media/goods/'; 	return true;
			case 2: $this->post['type'] = 'media/content/'; return true;
			case 3: $this->post['type'] = 'media/blog/'; 	return true;
			case 4: $this->post['type'] = 'media/user/'; 	return true;
			default: return false;
		}
	}

	protected function get_subject_dir() {
		$this->ci->load->helper('encrypt_file');
		$options = get_media_options();
		$dir = $this->ci->db	->select('dir_key')
									->where('id', $this->post['id'])
									->get('ci_media')->row_array();

		$this->subject = $options['prefix'] . $options['code'] . $dir['dir_key'] . DIRECTORY_SEPARATOR . $this->post['file'];
	}
}
