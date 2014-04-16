GrowthPush SDK for PHP
==================

GrowthPush is push notification and analysis platform for smart devices. GrowthPush SDK for PHP provides registration function of client devices and events.

```php
require './growthpush-php-sdk/GrowthPush.php';

$growthPush = new GrowthPush(YOUR_APP_ID,'YOUR_APP_SECRET');
$client = $growthPush->createClient('DEVICE_TOKEN','ios');
```

## Track events and tags.

If you want to track events of client devices, the following code are useful.

```php
$event = $growthPush->createEvent('DEVICE_TOKEN', 'Launch');
```

You can tag the devices.

```php
$tag = $growthPush->createTag('DEVICE_TOKEN', 'Gender', 'male');
```

## Push Notifications

You can send push notification to device's your application has.

```php
$apiNotification = $this->growthPush->createNotification('text', 'segmentation query json', 'true/false for sound', 'true/false for badge', 'custom json in payload');
```

That's all. Client devices can be browsed with dashboard. You can send push notifications to the devices and analyze the events.

## License

Licensed under the Apache License.
