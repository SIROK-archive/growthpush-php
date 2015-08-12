<?php

namespace GrowthPush;
use GrowthPush\HttpResponse;
use GrowthPush\GrowthPushException;

class HttpClient {

	private static $instance = null;

	const endpoint = 'https://api.growthpush.com/';

	private function __construct() {
	}

	public static function getInstance() {

		if (!self::$instance)
			self::$instance = new self();
		return self::$instance;

	}

	public function get($api, $params, $version = 1) {

		$url = self::endpoint . "/${version}/$api";
		$body = http_build_query($params);
		if ($body)
			$url .= '?' . $body;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$response = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		$HttpResponse = new HttpResponse($info, $response);

		if (!$HttpResponse->isOK()) {
			$body = json_decode($HttpResponse->getBody(), true);
			throw new GrowthPushException($body['message'], $info['http_code']);
		}

		return $HttpResponse;

	}

	public function post($api, $params, $version = 1) {

		$url = self::endpoint . "/${version}/$api";
		$body = http_build_query($params);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$response = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		$HttpResponse = new HttpResponse($info, $response);

		if (!$HttpResponse->isOK()) {
			$body = json_decode($HttpResponse->getBody(), true);
			throw new GrowthPushException($body['message'], $info['http_code']);
		}

		return $HttpResponse;

	}

    public function put($api, $params, $version = 1)
    {

        $url  = self::endpoint . "/${version}/$api";
        $body = http_build_query($params);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $response = curl_exec($ch);
        $info     = curl_getinfo($ch);
        curl_close($ch);

        $HttpResponse = new HttpResponse($info, $response);

        if (!$HttpResponse->isOK()) {
            $body = json_decode($HttpResponse->getBody(), true);
            throw new GrowthPushException($body['message'], $info['http_code']);
        }

        return $HttpResponse;

    }
}
