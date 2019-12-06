<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customizer
{
	protected $post;

	// Add your action if you need before runing query
	protected function before_query() {
			if(isset($this->post['row'])) {
				if (is_array($this->post['row'])) {
					foreach ($this->post['row'] as $item) {
						if(property_exists($item, 'timestamp')) {
							$item['timestamp'] = time();
						}
						if(property_exists($item, 'password')) {
							$item['password'] = password_hash($item['password'], PASSWORD_BCRYPT);
						}
					}
				} elseif (is_object($this->post['row'])) {
					if(property_exists($this->post['row'] , 'timestamp')) {
						$this->post['row']->timestamp = time();
					}
					if(property_exists($this->post['row'], 'password')) {
						$this->post['row']->password = password_hash($this->post['row']->password, PASSWORD_BCRYPT);
					}
				}
			}
		}

	// Add your action if you need after runing query
	protected function after_query() {
		if(isset($this->post['fomratDate'])) {
			$response_type = (isset($this->post['responseType'])) ? $this->post['responseType'] : null;
			switch ($response_type) {
				case 'row': {
					if((isset($this->response->timestamp))) {
						$this->response->timestamp = $this->ci->jdf->jdate($this->post['fomratDate'], (int) $this->response->timestamp);
					}
					// Add your another fields which you must use jdate on them
					if((isset($this->response->start) && isset($this->response->end))) {
						$this->response->start = $this->ci->jdf->jdate($this->post['fomratDate'], (int) $this->response->start);
						$this->response->end = $this->ci->jdf->jdate($this->post['fomratDate'], (int) $this->response->end);
					}
					break;
				}
				case 'rowArray': {
					if(isset($this->response['timestamp'])) {
						$this->response['timestamp'] = $this->ci->jdf->jdate($this->post['fomratDate'], (int) $this->response['timestamp']);
					}
					// Add your another fields which you must use jdate on them
					if(isset($this->response['start']) && isset($this->response['end'])) {
						$this->response['start'] = $this->ci->jdf->jdate($this->post['fomratDate'], (int) $this->response['start']);
						$this->response['end'] = $this->ci->jdf->jdate($this->post['fomratDate'], (int) $this->response['end']);
					}
					break;
				}
				case 'resultArray': {
					foreach ((array) $this->response as $item) {
						if((isset($item['timestamp']))) {
							$item['timestamp'] = $this->ci->jdf->jdate($this->post['fomratDate'], (int) $item['timestamp']);
						}
						// Add your another fields which you must use jdate on them
						if(isset($item['start']) && isset($item['end'])) {
							$item['start'] = $this->ci->jdf->jdate($this->post['fomratDate'], (int) $item['start']);
							$item['end'] = $this->ci->jdf->jdate($this->post['fomratDate'], (int) $item['end']);
						}
					}
					break;
				}
				default: {
					foreach ((array) $this->response as $item) {
						if((isset($item->timestamp))) {
							$item->timestamp = $this->ci->jdf->jdate($this->post['fomratDate'], (int) $item->timestamp);
						}
						// Add your another fields which you must use jdate on them
						if((isset($item->start) && isset($item->end))) {
							$item->start = $this->ci->jdf->jdate($this->post['fomratDate'], (int) $item->start);
							$item->end = $this->ci->jdf->jdate($this->post['fomratDate'], (int) $item->end);
						}
					}
					break;
				}
			}
		}

		// $this->ci->db->reset_query();
	}
}
