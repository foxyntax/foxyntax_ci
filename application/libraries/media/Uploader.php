<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH . 'libraries/media/Media_Library.php');

class Uploader extends Media_Library
{
	public function upload_file($name) {
		$this->check_available_dir($name);
		return $this->configuration($name);
	}

	protected function check_available_dir($name) {
		$scan = array_diff(scandir($this->base), array('.', '..'));
		if(count($scan) == 0 ) {
			$this->create_dir();
		} else {
			$this->get_dir($scan, $name);
		}
	}

	protected function create_dir() {
		$this->ci->load->helper('encrypt_file');
		$this->dir_key = create_salt();
		$this->dir = $this->base . $this->options['prefix'] . $this->options['generator'] . $this->dir_key . DIRECTORY_SEPARATOR;
		mkdir($this->dir, 0755);
	}

	protected function get_dir($scan, $name) {
		$this->dir = false;
		$this->count_files = count($_FILES[$name]['name']);
		foreach ($scan as $folder) {
			$media_count = count(array_diff(scandir($this->base . $folder), array('.', '..')));
			if($media_count <= ((int) $this->options['maximum'] - $this->count_files) ) {
				$this->dir = $this->base . $folder . DIRECTORY_SEPARATOR;
				$this->dir_key = str_replace($this->options['prefix'], '', str_replace($this->options['generator'], '', $folder));
			}
		}

		if(! $this->dir) { $this->create_dir(); }
	}


	protected function configuration($name) {
		$config['upload_path'] 		= 	$this->dir;
		$config['allowed_types'] 	= (isset($this->post['allowedTypes'])) ? $this->post['allowedTypes'] : $this->ci->config->item('allowed_types_uploaded');
		$config['max_size']   		= (isset($this->post['maxSize']->maxSize)) ? $this->post['maxSize']->maxSize : $this->ci->config->item('max_size_uploaded');
		$config['max_width']  		= (isset($this->post['maxWidth']->maxWidth)) ? $this->post['maxWidth'] : $this->ci->config->item('max_width_uploaded');
		$config['max_height'] 		= (isset($this->post['maxHeight']->maxHeight)) ? $this->post['maxHeight'] : $this->ci->config->item('max_height_uploaded');
		$config['encrypt_name'] 	= (isset($this->post['encryptName']->encryptName)) ? $this->post['encryptName'] : $this->ci->config->item('encrypt_name_uploaded');
		$config['remove_space'] 	= (isset($this->post['removeSpace']->removeSpace)) ? $this->post['removeSpace'] : $this->ci->config->item('remove_space_uploaded');
		$this->ci->load->library('upload', $config);
		$this->ci->upload->initialize($config);

		for($i = 0; $i < $this->count_files; $i++) {
			$_FILES['images']['name'] 		= $_FILES[$name]['name'][$i];
			$_FILES['images']['type'] 		= $_FILES[$name]['type'][$i];
			$_FILES['images']['size'] 		= $_FILES[$name]['size'][$i];
			$_FILES['images']['error'] 	= $_FILES[$name]['error'][$i];
			$_FILES['images']['tmp_name'] = $_FILES[$name]['tmp_name'][$i];

			if (! $this->ci->upload->do_upload('images')) {
				return $this->ci->upload->display_errors();
			} else {
				$upload_data = $this->ci->upload->data();
				$inserted = array(
					'name' 			=> $upload_data['raw_name'],
					'origin_name' 	=> str_replace($upload_data['file_ext'], '', $upload_data['orig_name']),
					'extension' 	=> $upload_data['file_ext'],
					'owner'			=> (isset($this->post['owner'])) ? $this->post['owner'] : null,
					'type' 			=> $this->get_type_code(),
					'alt' 			=> ($this->multiple) ? str_replace($upload_data['file_ext'], '', $upload_data['orig_name']) : $this->post['alt'],
					'dir_key' 		=> $this->dir_key
				);
				$this->ci->db->insert('ci_media', $inserted);
			}
		}
		return 'Upload Finished';
	}
}
