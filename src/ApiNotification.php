<?php

namespace GrowthPush;
use GrowthPush\HttpClient;

class ApiNotification {

	private $text = null;
	private $query = null;
	private $sound = false;
	private $badge = false;
	private $extra = null;
	private $clientIds = array();

	public function __construct($text, $query = null, $sound = null, $badge = null, $extra = null) {

		$this->text = $text;
		$this->query = $query;
		$this->sound = (boolean)$sound;
		$this->badge = (boolean)$badge;
		$this->extra = $extra;

	}

	private function set($attributes) {

		if (array_key_exists('clientIds', $attributes))
			$this->clientIds = $attributes['clientIds'];

	}

	public function save($growthPush) {

		try {
			$httpResponse = HttpClient::getInstance()->post('notifications', array(
				'applicationId' => $growthPush->getApplicationId(),
				'secret' => $growthPush->getSecret(),
				'text' => $this->text,
				'query' => $this->query,
				'sound' => (boolean)$this->sound,
				'badge' => (boolean)$this->badge,
				'extra' => $this->extra
			));
		} catch(GrowthPushException $e) {
			throw new GrowthPushException('Failed to save notification: ' . $e->getMessage());
		}

		$body = json_decode($httpResponse->getBody(), true);
		$this->set($body);

		return $this;

	}

	public function getText() {
		return $this->text;
	}

	public function getQuery() {
		return $this->query;
	}

	public function getSound() {
		return $this->sound;
	}

	public function getBadge() {
		return $this->badge;
	}

	public function getExtra() {
		return $this->extra;
	}

	public function getClientIds() {
		return $this->clientIds;
	}

}
