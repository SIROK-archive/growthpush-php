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

		if (array_key_exists('id', $attributes))
			$this->id = $attributes['id'];
		if (array_key_exists('applicationId', $attributes))
			$this->applicationId = $attributes['applicationId'];
		if (array_key_exists('code', $attributes))
			$this->code = $attributes['code'];
		if (array_key_exists('token', $attributes))
			$this->token = $attributes['token'];
		if (array_key_exists('os', $attributes))
			$this->os = $attributes['os'];
		if (array_key_exists('environment', $attributes))
			$this->environment = $attributes['environment'];
		if (array_key_exists('status', $attributes))
			$this->status = $attributes['status'];
		if (array_key_exists('created', $attributes))
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
