<?php

namespace GrowthPush;
use GrowthPush\HttpClient;
use GrowthPush\GrowthPushException;

class Notification {

	private $id = null;
	private $applicationId = null;
	private $segmentId = null;
	private $tagId = null;
	private $status = null;
	private $created = null;
	private $trials = null;

	public function __construct($attributes) {

		$this->set($attributes);

	}

	private function set($attributes) {

		$this->id = $attributes['id'];
		$this->applicationId = $attributes['applicationId'];
		$this->segmentId = $attributes['segmentId'];
		$this->tagId = $attributes['tagId'];
		$this->status = $attributes['status'];
		$this->created = $attributes['created'];
		$this->trials = $attributes['trials'];

	}

	public function getId() {
		return $this->id;
	}

	public function getApplicationId() {
		return $this->applicationId;
	}

	public function getSegmentId() {
		return $this->segmentId;
	}

	public function getTagId() {
		return $this->tagId;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getCreated() {
		return $this->created;
	}

	public function getTrials() {
		return $this->trials;
	}

	public static function fetch($growthPush, $page = 1, $limit = 100) {

		try {
			$httpResponse = HttpClient::getInstance()->get('notifications', array(
				'applicationId' => $growthPush->getApplicationId(),
				'secret' => $growthPush->getSecret(),
				'page' => $page,
				'limit' => $limit,
			));
		} catch(GrowthPushException $e) {
			throw new GrowthPushException('Failed to fetch notifications: ' . $e->getMessage());
		}

		$body = json_decode($httpResponse->getBody(), true);

		$notifications = array();
		foreach ($body as $attributes)
			$notifications[] = new Notification($attributes);

		return $notifications;

	}

}
