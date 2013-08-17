<?php

namespace GrowthPush;

class HttpResponse {

	private $info;
	private $header;
	private $body;

	public function __construct($info, $response) {

		$this->info = $info;
		$this->header = substr($response, 0, $info["header_size"]);
		$this->body = substr($response, $info["header_size"]);

	}

	public function getInfo() {
		return $this->info;
	}

	public function getHeader() {
		return $this->header;
	}

	public function getBody() {
		return $this->body;
	}

	public function isOK() {
		return ($this->info['http_code'] >= 200 && $this->info['http_code'] < 300);
	}

}
