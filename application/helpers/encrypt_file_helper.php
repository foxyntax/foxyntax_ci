<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*
|--------------------------------------------------------------------------
| Basic Functions
|--------------------------------------------------------------------------
*/
if ( ! function_exists('create_salt')) {
	function create_salt() {
		$ci =& get_instance();
		$items = str_split($ci->config->item('alpha_generate'));
		shuffle($items);
		$salt = '';
		for($i = 0; $i <= $ci->config->item('salt_file_length'); $i++) {
			$salt .= $items[$i];
		}
		return $salt . time();
	}
}

if ( ! function_exists('get_media_options')) {
	function get_media_options() {
		$ci =& get_instance();
		$options = array();
		$results = $ci->db->select('name, value')
								->where('name', 'media_prefix')
								->or_where('name', 'media_code')
								->get('ci_options')->result_array();
		foreach ($results as $key) {
			if($key['name'] == 'media_prefix') {
				$options['prefix'] = $key['value'];
			} elseif ($key['name'] == 'media_code') {
				$options['code'] = $key['value'];
			}
		}
		return $options;
	}
}

if ( ! function_exists('regenerate_media_dir')) {
	function regenerate_media_dir($mode = 'manually') {
		$ci =& get_instance();
		if($mode == 'manually') {
			$exp = $ci->db	->select('value')
								->get_where('ci_options', array('name' => 'last_generate_media'))
								->row_array();
			if((time() - $exp['value']) > (12*3600)) {
				return update_generate_code_options();
			}
		} else {
			return update_generate_code_options();
		}
		return false;
	}
}

if ( ! function_exists('edit_file')) {
	function edit_file() {
		$ci =& get_instance();
		file_put_contents($ci->input->post('path'), $ci->input->post('content'));
		return 'تغییرات شما اعمال شد.';
	}
}

/*
|--------------------------------------------------------------------------
| Instanse Functions
|--------------------------------------------------------------------------
*/

if ( ! function_exists('update_generate_code_options')) {
	function update_generate_code_options() {
		$ci =& get_instance();
		$salt = create_salt();
		$base = $ci->config->item('base_media_dir') . DIRECTORY_SEPARATOR . 'media';
		$code = $ci->db->select('value')
							->get_where('ci_options', array('name' => 'media_code'))
							->row_array();
		$ci->db	->where('name', 'media_code')
					->update('ci_options', array('value' => $salt));
		$ci->db	->where('name', 'last_generate_media')
					->update('ci_options', array('value' => time()));


		if($ci->db->affected_rows() != 0) {
			$scan_base = array_diff(scandir($base), array('.', '..'));
			foreach ($scan_base as $type) {
				$types = $base . DIRECTORY_SEPARATOR . $type;
				$scan_types = array_diff(scandir($types), array('.', '..'));
				foreach ($scan_types as $dir) {
					$old_name = $types . DIRECTORY_SEPARATOR . $dir;
					$new_name = $types . DIRECTORY_SEPARATOR . str_replace($code['value'], $salt, $dir);
					rename($old_name, $new_name);
				}
			}
			return true;
		}
		return false;
	}
}
