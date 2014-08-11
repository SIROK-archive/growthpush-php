<?php

require (dirname(__FILE__) . '/src/ApiNotification.php');
require (dirname(__FILE__) . '/src/Client.php');
require (dirname(__FILE__) . '/src/Event.php');
require (dirname(__FILE__) . '/src/Notification.php');
require (dirname(__FILE__) . '/src/Tag.php');
require (dirname(__FILE__) . '/src/Trial.php');
require (dirname(__FILE__) . '/src/HttpClient.php');
require (dirname(__FILE__) . '/src/HttpResponse.php');
require (dirname(__FILE__) . '/src/GrowthPushException.php');

class GrowthPush {

	const OS_IOS = 'ios';
	const OS_ANDROID = 'android';

	const ENVIRONMENT_PRODUCTION = 'production';
	const ENVIRONMENT_DEVELOPMENT = 'development';

	const ORDER_ASCENDING = 'ascending';
	const ORDER_DESCENDING = 'descending';

	private $applicationId = null;
	private $secret = null;
	private $environment = null;

	public function __construct($applicationId, $secret, $environment = self::ENVIRONMENT_PRODUCTION) {

		$this->applicationId = $applicationId;
		$this->secret = $secret;
		$this->environment = $environment;

	}

	public function fetchEvents($goalId, $exclusiveTimestamp = null, $order = GrowthPush::ORDER_ASCENDING, $limit = 1000) {

		return GrowthPush\Event::fetch($this, $goalId, $exclusiveTimestamp, $order, $limit);

	}

	public function fetchTags($tagId, $exclusiveClientId = null, $order = GrowthPush::ORDER_ASCENDING, $limit = 1000) {

		return GrowthPush\Tag::fetch($this, $tagId, $exclusiveClientId, $order, $limit);

	}

	public function fetchNotifications($page = 1, $limit = 100) {

		return GrowthPush\Notification::fetch($this, $page, $limit);

	}

	public function createClient($token, $os) {

		$client = new GrowthPush\Client($token, $os);
		return $client->save($this);

	}

	public function createEvent($client, $name, $value = null) {

		if (!($client instanceof GrowthPush\Client))
			$client = new GrowthPush\Client($client);

		$event = new GrowthPush\Event($client, $name, $value);
		return $event->save($this);

	}

	public function createTag($client, $name, $value = null) {

		if (!($client instanceof GrowthPush\Client))
			$client = new GrowthPush\Client($client);

		$tag = new GrowthPush\Tag($client, $name, $value);
		return $tag->save($this);

	}

	public function createNotification($text, $query = null, $sound = false, $badge = false, $extra = null, $duration = null) {

		$api_notification = new GrowthPush\ApiNotification($text, $query, $sound, $badge, $extra, $duration);
		return $api_notification->save($this);

	}

	public function getApplicationId() {
		return $this->applicationId;
	}

	public function getSecret() {
		return $this->secret;
	}

	public function getEnvironment() {
		return $this->environment;
	}

}
