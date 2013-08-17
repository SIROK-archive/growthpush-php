<?php

namespace GrowthPush;
use GrowthPush\HttpClient;

class Tag {

	private $name = null;
	private $tagId = null;
	private $clientId = null;
	private $value = null;
	private $client = null;

	public function __construct($client, $name, $value = null) {

		$this->client = $client;
		$this->name = $name;
		$this->value = $value;

	}

	public function save($growthPush) {

		try {
			if ($this->client->getId() && $this->client->getCode()) {
				$httpResponse = HttpClient::getInstance()->post('tags', array(
					'clientId' => $this->client->getId(),
					'code' => $this->client->getCode(),
					'name' => $this->name,
					'value' => $this->value,
				));
			} else if ($this->client->getToken()) {
				$httpResponse = HttpClient::getInstance()->post('tags', array(
					'applicationId' => $growthPush->getApplicationId(),
					'secret' => $growthPush->getSecret(),
					'token' => $this->client->getToken(),
					'name' => $this->name,
					'value' => $this->value,
				));
			} else {
				throw new GrowthPushException('Failed to save tag: Invalid client');
			}
		} catch(GrowthPushException $e) {
			throw new GrowthPushException('Failed to save tag: ' . $e->getMessage());
		}

		$body = json_decode($httpResponse->getBody(), true);
		$this->set($body);

		return $this;

	}

	private function set($attributes) {

		$this->tagId = $attributes['tagId'];
		$this->clientId = $attributes['clientId'];
		$this->value = $attributes['value'];

	}

	public function getName() {
		return $this->name;
	}

	public function getTagId() {
		return $this->tagId;
	}

	public function getClientId() {
		return $this->clientId;
	}

	public function getValue() {
		return $this->value;
	}

}
