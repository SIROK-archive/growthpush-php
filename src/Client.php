<?php

namespace GrowthPush;
use GrowthPush\HttpClient;
use GrowthPush\GrowthPushException;

class Client {

	private $id = null;
	private $applicationId = null;
	private $code = null;
	private $token = null;
	private $os = null;
	private $environment = null;
	private $status = null;
	private $created = null;

	public function __construct($token, $os = null) {

		$this->token = $token;
		$this->os = $os;

	}

	public function save($growthPush) {

		try {
			$httpResponse = HttpClient::getInstance()->post('clients', array(
				'applicationId' => $growthPush->getApplicationId(),
				'secret' => $growthPush->getSecret(),
				'token' => $this->token,
				'os' => $this->os,
				'environment' => $growthPush->getEnvironment(),
			));
		} catch(GrowthPushException $e) {
			throw new GrowthPushException('Failed to save client: ' . $e->getMessage());
		}

		$body = json_decode($httpResponse->getBody(), true);
		$this->set($body);

		return $this;

	}

	private function set($attributes) {

		$this->id = $attributes['id'];
		$this->applicationId = $attributes['applicationId'];
		$this->code = $attributes['code'];
		$this->token = $attributes['token'];
		$this->os = $attributes['os'];
		$this->environment = $attributes['environment'];
		$this->status = $attributes['status'];
		$this->created = $attributes['created'];

	}

	public function getId() {
		return $this->id;
	}

	public function getApplicationId() {
		return $this->applicationId;
	}

	public function getCode() {
		return $this->code;
	}

	public function getToken() {
		return $this->token;
	}

	public function getOs() {
		return $this->OS;
	}

	public function getEnvironment() {
		return $this->environment;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getCreated() {
		return $this->created;
	}

}
