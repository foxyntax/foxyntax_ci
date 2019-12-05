<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH . 'libraries/media/Remove.php');

class Downloader extends Remove
{
	public function get_path_file() {
		$this->ci->load->helper('encrypt_file');
		$this->ci->db->select('dir_key, name, extension');
		if( isset($this->post['name']) || (isset($this->post['owner']) && isset($this->post['type'])) ) {

			if(isset($this->post['name'])) { // when you have origin to get path

				$this->ci->db->where('origin_name', $this->post['name']);

			} elseif(isset($this->post['owner']) && isset($this->post['type'])) { // when you have owner to get path (use for read file)

				$this->ci->db->where(array(
					'owner'	=> $this->post['owner'],
					'type'	=> $this->post['type'],
				));

			}

			$dir = $this->ci->db->get('ci_media')->row_array();
			$options = get_media_options();
			return $options['prefix'] . $options['code'] . $dir['dir_key'] . DIRECTORY_SEPARATOR . $dir['name']. $dir['extension'];

		}
		return false;
	}

	public function read_file() {
		$path = $this->get_path_file();
		if($this->get_type_dir()) {
			$dir = $this->ci->config->item('base_media_dir') . DIRECTORY_SEPARATOR . $this->post['type'] . $path;
			return array (
				'content'=> file_get_contents($dir),
				'path'	=> $dir
			);
		}
		return false;
	}
}
