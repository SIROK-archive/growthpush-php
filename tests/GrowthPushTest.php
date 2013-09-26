<?php

class GrowthPushTest extends PHPUnit_Framework_TestCase {

	private $growthPush = null;

	public function setUp() {

		$this->growthPush = new GrowthPush(TestConfiguration::APPLICATION_ID, TestConfiguration::SECRET);

	}

	public function testConstruct() {

		$growthPush = new GrowthPush(TestConfiguration::APPLICATION_ID, TestConfiguration::SECRET);

		$this->assertEquals($growthPush->getApplicationId(), TestConfiguration::APPLICATION_ID);
		$this->assertEquals($growthPush->getSecret(), TestConfiguration::SECRET);
		$this->assertEquals($growthPush->getEnvironment(), GrowthPush::ENVIRONMENT_PRODUCTION);

	}

	public function testFetchNotifications() {

		$notifications = $this->growthPush->fetchNotifications(1, 1);

		$this->assertTrue(is_array($notifications));

	}

	public function testFetchNotificationsWithBadLimit() {

		try {
			$client = $this->growthPush->fetchNotifications(1, 10000);
			$this->fail();
		} catch(GrowthPush\GrowthPushException $e) {
		}

	}

	public function testCreateClient() {

		$token = hash('sha256', rand());

		$client = $this->growthPush->createClient($token, GrowthPush::OS_IOS);

		$this->assertTrue($client->getId() > 0);
		$this->assertEquals($client->getToken(), $token);

	}

	public function testCreateClientWithDuplicateToken() {

		$client = $this->growthPush->createClient(TestConfiguration::TOKEN, GrowthPush::OS_IOS);
		$this->assertEquals($client->getId(), TestConfiguration::CLIENT_ID);

	}

	public function testCreateClientWithBadToken() {

		try {
			$client = $this->growthPush->createClient('bad_token', GrowthPush::OS_IOS);
			$this->fail();
		} catch(GrowthPush\GrowthPushException $e) {
		}

	}

	public function testCreateClientWithBadOS() {

		try {
			$client = $this->growthPush->createClient(TestConfiguration::TOKEN, 'bad_os');
			$this->fail();
		} catch(GrowthPush\GrowthPushException $e) {
		}

	}

	public function testCreateEvent() {

		$event = $this->growthPush->createEvent(TestConfiguration::TOKEN, 'Launch', '');

		$this->assertTrue($event->getGoalId() > 0);
		$this->assertTrue($event->getTimestamp() > 0);
		$this->assertTrue($event->getClientId() > 0);

	}

	public function testCreateEventWithClient() {

		$client = $this->growthPush->createClient(TestConfiguration::TOKEN, GrowthPush::OS_IOS);
		$event = $this->growthPush->createEvent($client, 'Launch', '');

		$this->assertTrue($event->getGoalId() > 0);
		$this->assertTrue($event->getTimestamp() > 0);
		$this->assertTrue($event->getClientId() > 0);

	}

	public function testCreateEventWithEmptyName() {

		try {
			$event = $this->growthPush->createEvent(TestConfiguration::TOKEN, '');
			$this->fail();
		} catch(GrowthPush\GrowthPushException $e) {
		}

	}

	public function testCreateEventWithLongName() {

		try {
			$event = $this->growthPush->createEvent(TestConfiguration::TOKEN, str_repeat('long', 100));
			$this->fail();
		} catch(GrowthPush\GrowthPushException $e) {
		}

	}

	public function testCreateTag() {

		$tag = $this->growthPush->createTag(TestConfiguration::TOKEN, 'Gender', 'male');

		$this->assertTrue($tag->getTagId() > 0);
		$this->assertTrue($tag->getClientId() > 0);
		$this->assertEquals($tag->getValue(), 'male');

	}

	public function testCreateTagWithClient() {

		$client = $this->growthPush->createClient(TestConfiguration::TOKEN, GrowthPush::OS_IOS);
		$tag = $this->growthPush->createTag($client, 'Gender', 'male');

		$this->assertTrue($tag->getTagId() > 0);
		$this->assertTrue($tag->getClientId() > 0);
		$this->assertEquals($tag->getValue(), 'male');

	}

	public function testCreateTagWithEmptyName() {

		try {
			$tag = $this->growthPush->createTag(TestConfiguration::TOKEN, '');
			$this->fail();
		} catch(GrowthPush\GrowthPushException $e) {
		}

	}

	public function testCreateTagWithLongName() {

		try {
			$tag = $this->growthPush->createTag(TestConfiguration::TOKEN, str_repeat('long', 100));
			$this->fail();
		} catch(GrowthPush\GrowthPushException $e) {
		}

	}

}
