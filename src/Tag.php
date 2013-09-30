<?php

namespace GrowthPush;
use GrowthPush\HttpClient;

class Tag {

	private $name = null;
	private $tagId = null;
	private $clientId = null;
	private $value = null;
	private $client = null;

	public function __construct($arg0, $arg1 = null, $arg2 = null) {

		if (is_null($arg1)) {
			$this->constructWithAttributes($arg0);
			return;
		}

		if (is_null($arg2)) {
			$this->constructWithClientAndName($arg0, $arg1);
			return;
		}

		$this->constructWithClientAndName($arg0, $arg1, $arg2);

	}

	private function constructWithAttributes($attributes) {

		$this->set($attributes);

	}

	private function constructWithClientAndName($client, $name, $value = null) {

		$this->client = $client;
		$this->name = $name;
		$this->value = $value;

	}

	private function set($attributes) {

		if (array_key_exists('tagId', $attributes))
			$this->tagId = $attributes['tagId'];
		if (array_key_exists('clientId', $attributes))
			$this->clientId = $attributes['clientId'];
		if (array_key_exists('value', $attributes))
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

	public static function fetch($growthPush, $tagId, $exclusiveClientId = null, $order = GrowthPush::ORDER_ASCENDING, $limit = 1000) {

		try {
			$httpResponse = HttpClient::getInstance()->get('tags', array(
				'tagId' => $tagId,
				'secret' => $growthPush->getSecret(),
				'exclusiveClientId' => $exclusiveClientId,
				'order' => $order,
				'limit' => $limit,
			));
		} catch(GrowthPushException $e) {
			throw new GrowthPushException('Failed to fetch tags: ' . $e->getMessage());
		}

		$body = json_decode($httpResponse->getBody(), true);

		$tags = array();
		foreach ($body as $attributes)
			$tags[] = new Tag($attributes);

		return $tags;

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

}
