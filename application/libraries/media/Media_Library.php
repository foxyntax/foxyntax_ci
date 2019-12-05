<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media_Library
{
	protected $ci, $post, $base, $dir, $dir_key, $multiple, $options;

	public function __construct()
	{
		$this->ci =& get_instance();
		$this->post = (array) json_decode($this->ci->input->raw_input_stream);
		$this->base = $this->ci->config->item('base_media_dir');
		$this->multiple = $this->post['multiple'];
		$this->get_options();
		if(isset($this->post['type']) || isset($this->post['multiple'])) {
			$this->provider($this->post['type']);
		} else {
			return false;
		}
	}

	protected function provider($type = 'goods') {
		switch($type) {
			case 'blog'    : $this->base .= DIRECTORY_SEPARATOR . 'media/blog/';     break;
			case 'content' : $this->base .= DIRECTORY_SEPARATOR . 'media/content/';  break;
			case 'user' 	: $this->base .= DIRECTORY_SEPARATOR . 'media/user/';  	 break;
			default        : $this->base .= DIRECTORY_SEPARATOR . 'media/goods/';
		}
	}

	protected function get_options() {
		$result = $this->ci->db	->select('name, value')
										->get('ci_options')
										->result();
		foreach ($result as $item) {
			switch ($item->name) {
				case 'media_prefix'  : $this->options['prefix']    = $item->value; break;
				case 'max_save_file' : $this->options['maximum']   = $item->value; break;
				case 'media_code'    : $this->options['generator'] = $item->value; break;
			}
		}
	}

	protected function get_type_code() {
		switch ($this->post['type']) {
			case 'goods'	: return 1;
			case 'content' : return 2;
			case 'blog' 	: return 3;
			case 'user' 	: return 4;
		}
	}
}
