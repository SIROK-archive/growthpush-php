<?php

namespace GrowthPush;
use GrowthPush\HttpClient;

class Event {

	private $name = null;
	private $goalId = null;
	private $timestamp = null;
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

	public function save($growthPush) {

		try {
			if ($this->client->getId() && $this->client->getCode()) {
				$httpResponse = HttpClient::getInstance()->post('events', array(
					'clientId' => $this->client->getId(),
					'code' => $this->client->getCode(),
					'name' => $this->name,
					'value' => $this->value,
				));
			} else if ($this->client->getToken()) {
				$httpResponse = HttpClient::getInstance()->post('events', array(
					'applicationId' => $growthPush->getApplicationId(),
					'secret' => $growthPush->getSecret(),
					'token' => $this->client->getToken(),
					'name' => $this->name,
					'value' => $this->value,
				));
			} else {
				throw new GrowthPushException('Failed to save event: Invalid client');
			}
		} catch(GrowthPushException $e) {
			throw new GrowthPushException('Failed to save event: ' . $e->getMessage());
		}

		$body = json_decode($httpResponse->getBody(), true);
		$this->set($body);

		return $this;

	}

	private function set($attributes) {

		$this->goalId = $attributes['goalId'];
		$this->timestamp = $attributes['timestamp'];
		$this->clientId = $attributes['clientId'];
		$this->value = $attributes['value'];

	}

	public function getName() {
		return $this->name;
	}

	public function getGoalId() {
		return $this->goalId;
	}

	public function getTimestamp() {
		return $this->timestamp;
	}

	public function getClientId() {
		return $this->clientId;
	}

	public function getValue() {
		return $this->value;
	}

	public static function fetch($growthPush, $goalId, $exclusiveTimestamp = null, $order = GrowthPush::ORDER_ASCENDING, $limit = 1000) {

		try {
			$httpResponse = HttpClient::getInstance()->get('events', array(
				'goalId' => $goalId,
				'secret' => $growthPush->getSecret(),
				'exclusiveTimestamp' => $exclusiveTimestamp,
				'order' => $order,
				'limit' => $limit,
			));
		} catch(GrowthPushException $e) {
			throw new GrowthPushException('Failed to fetch events: ' . $e->getMessage());
		}

		$body = json_decode($httpResponse->getBody(), true);

		$events = array();
		foreach ($body as $attributes)
			$events[] = new Event($attributes);

		return $events;

	}

}
