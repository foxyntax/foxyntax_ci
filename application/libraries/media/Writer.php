<?php


class Writer
{
	protected $ci, $post, $base, $dir, $dir_key, $options;
	protected $count_files = 1;

	public function __construct()
	{
		$this->ci =& get_instance();
		$this->post = (array) json_decode($this->ci->input->raw_input_stream);
		$this->base = base_url();
		$this->get_options();
		if(isset($this->post['type']) || isset($this->post['multiple'])) {
			$this->provider($this->post['type']);
		} else {
			return false;
		}
	}

	protected function provider($type = 'goods') {
		switch($type) {
			case 'blog'    : $this->base .= 'media/blog/';     break;
			case 'content' : $this->base .= 'media/content/';  break;
			case 'user' : $this->base 	  .= 'media/user/';  break;
			default        : $this->base .= 'media/goods/';    break;
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

	public function write_file() {
		$this->check_available_dir();
		$content = $this->dir . $this->post['nameFile'] . $this->post['extFile'];
		$handle = fopen($content, 'w');
			if(! $handle) {
				return false;
			}
			fwrite($handle, $this->post['content']);
			$inserted = array(
				'name' 			=> $this->post['nameFile'],
				'origin_name' 	=> $this->post['nameFile'],
				'extension' 	=> $this->post['extFile'],
				'owner'			=> $this->post['owner'],
				'type' 			=> $this->get_type_code(),
				'alt' 			=> null,
				'dir_key' 		=> $this->dir_key
			);
			$this->ci->db->insert('ci_media', $inserted);
		fclose($handle);
	}

	protected function check_available_dir() {
		$scan = array_diff(scandir($this->base), array('.', '..'));
		if(count($scan) == 0 ) {
			$this->create_dir();
		} else {
			$this->get_dir($scan);
		}
	}

	protected function create_dir() {
		$this->ci->load->helper('encrypt_file_helper');
		$this->dir_key = create_salt();
		$this->dir = $this->base . $this->options['prefix'] . $this->options['generator'] . $this->dir_key . DIRECTORY_SEPARATOR;
		mkdir($this->dir, 0755);
	}

	protected function get_dir($scan) {
		$this->dir = false;
		foreach ($scan as $folder) {
			$media_count = count(array_diff(scandir($this->base . $folder), array('.', '..')));
			if($media_count <= ((int) $this->options['maximum'] - 1) ) {
				$this->dir = $this->base . $folder . DIRECTORY_SEPARATOR;
				$this->dir_key = str_replace($this->options['prefix'], '', str_replace($this->options['generator'], '', $folder));
			}
		}

		if(! $this->dir) { $this->create_dir(); }
	}
}
