<?php

namespace GrowthPush;
use GrowthPush\HttpClient;
use GrowthPush\GrowthPushException;

class Trial {

	private $id = null;
	private $notificationId = null;
	private $text = null;
	private $sound = null;
	private $badge = null;
	private $extra = null;
	private $scheduled = null;
	private $status = null;

	public function __construct($attributes) {

		$this->set($attributes);

	}

	private function set($attributes) {

		if (array_key_exists('id', $attributes))
			$this->id = $attributes['id'];
		if (array_key_exists('notificationId', $attributes))
			$this->notificationId = $attributes['notificationId'];
		if (array_key_exists('text', $attributes))
			$this->text = $attributes['text'];
		if (array_key_exists('sound', $attributes))
			$this->sound = $attributes['sound'];
		if (array_key_exists('badge', $attributes))
			$this->badge = $attributes['badge'];
		if (array_key_exists('extra', $attributes))
			$this->extra = $attributes['extra'];
		if (array_key_exists('scheduled', $attributes))
			$this->scheduled = $attributes['scheduled'];
		if (array_key_exists('status', $attributes))
			$this->status = $attributes['status'];

	}

	public function getId() {
		return $this->id;
	}

	public function getNotificationid() {
		return $this->notificationId;
	}

	public function getText() {
		return $this->text;
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

	public function getScheduled() {
		return $this->scheduled;
	}

	public function getStatus() {
		return $this->status;
	}

}
