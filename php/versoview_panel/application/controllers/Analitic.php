<?php

date_default_timezone_set('Asia/Jakarta');
defined('BASEPATH') OR exit('No direct script access allowed');

class Analitic extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('Analitics');    
	}
	public function index(){	
		$this->setCorsHeaders();

		if ($this->input->method(TRUE) === 'OPTIONS') {
			return $this->jsonResponse(array("success" => true));
		}

		$payload = $this->getJsonPayload();

		if ($this->isV2Payload($payload)) {
			return $this->storeV2Payload($payload);
		}

		return $this->storeLegacyPost();
	}	

	private function setCorsHeaders()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
	}

	private function getJsonPayload()
	{
		$raw = file_get_contents('php://input');

		if (!$raw) {
			return null;
		}

		$payload = json_decode($raw, true);

		if (json_last_error() !== JSON_ERROR_NONE || !is_array($payload)) {
			return null;
		}

		return $payload;
	}

	private function isV2Payload($payload)
	{
		return is_array($payload) && isset($payload['events']) && is_array($payload['events']);
	}

	private function storeV2Payload($payload)
	{
		$totalEvents = isset($payload['events']) && is_array($payload['events']) ? count($payload['events']) : 0;
		$rows = $this->buildRowsFromEvents($payload);

		if (count($rows) === 0) {
			return $this->jsonResponse(array(
				"success" => true,
				"inserted" => 0,
				"dropped" => $totalEvents,
				"message" => "No analytics events with period greater than 0"
			));
		}

		$inserted = $this->Analitics->clickBatch($rows);

		return $this->jsonResponse(array(
			"success" => true,
			"inserted" => $inserted,
			"dropped" => $totalEvents - count($rows)
		));
	}

	private function storeLegacyPost()
	{
		$post = $this->input->post();

		if (!$post) {
			return $this->jsonResponse(array("success" => false), 400);
		}

		$arr = $this->buildLegacyRow();

		if (!$this->hasPositivePeriod($arr)) {
			return $this->jsonResponse(array(
				"success" => true,
				"inserted" => 0,
				"dropped" => 1,
				"message" => "Analytics period is 0"
			));
		}

		$this->Analitics->click($arr);

		return $this->jsonResponse(array("success" => true));
	}

	private function buildRowsFromEvents($payload)
	{
		$rows = array();
		$session = isset($payload['session']) && is_array($payload['session']) ? $payload['session'] : array();
		$uq = $this->pickValue($payload, 'uq', $this->pickValue($session, 'uq', null));

		foreach ($payload['events'] as $event) {
			if (!is_array($event)) {
				continue;
			}

			$row = $this->normalizeEventRow($event, $session, $uq);

			if (!$this->hasPositivePeriod($row)) {
				continue;
			}

			$rows[] = $row;
		}

		return $rows;
	}

	private function hasPositivePeriod($row)
	{
		$period = isset($row['period']) ? (int) $row['period'] : 0;
		return $period > 0;
	}

	private function normalizeEventRow($event, $session, $uq)
	{
		$ip = $this->firstValue(array(
			$this->pickValue($event, 'ip', null),
			$this->pickValue($session, 'ip', null)
		), 'unknown');

		if ($ip === '' || $ip === 'unknown') {
			$ip = $this->getIP();
		}

		$guid = $this->firstValue(array(
			$this->pickValue($event, 'guid', null),
			$this->pickValue($session, 'guid', null),
			$this->getCookieGuid()
		), '-');

		$url = $this->firstValue(array(
			$this->pickValue($event, 'url', null),
			$this->pickValue($session, 'url', null)
		), '');

		$row = array(
			"app" => $this->firstValue(array($this->pickValue($event, 'app', null), $this->pickValue($session, 'app', null)), null),
			"edition" => $this->firstValue(array($this->pickValue($event, 'edition', null), $this->pickValue($session, 'edition', null)), null),
			"page" => $this->pickValue($event, 'page', null),
			"position" => $this->firstValue(array($this->pickValue($event, 'position', null), $this->pickValue($session, 'position', null)), null),
			"period" => $this->pickValue($event, 'period', 0),
			"ip" => $ip,
			"country" => $this->firstValue(array($this->pickValue($event, 'country', null), $this->pickValue($session, 'country', null)), 'unknown'),
			"browser" => $this->firstValue(array($this->pickValue($event, 'browser', null), $this->pickValue($session, 'browser', null)), null),
			"device" => $this->firstValue(array($this->pickValue($event, 'device', null), $this->pickValue($session, 'device', null)), null),
			"size" => $this->firstValue(array($this->pickValue($event, 'size', null), $this->pickValue($session, 'screen', null)), null),
			"custom" => $this->firstValue(array($this->pickValue($event, 'custom', null), $this->pickValue($session, 'userAgent', null)), null),
			"years" => $this->firstValue(array($this->pickValue($event, 'years', null), $this->pickValue($session, 'years', null)), null),
			"guid" => $guid,
			"uid" => $this->firstValue(array($this->pickValue($event, 'uq', null), $uq), null),
			"url" => substr($url, 0, 100),
			"type" => $this->pickValue($event, 'type', null),
			"event_type" => $this->pickValue($event, 'type', null),
			"reading_id" => $this->firstValue(array($this->pickValue($event, 'readingId', null), $this->pickValue($event, 'reading_id', null)), null),
			"reading_status" => $this->pickValue($event, 'status', null),
			"is_final" => $this->pickValue($event, 'final', 0),
			"session" => $this->firstValue(array($this->pickValue($session, 'session', null), $this->pickValue($session, 'id', null)), null),
			"session_id" => $this->firstValue(array($this->pickValue($session, 'session', null), $this->pickValue($session, 'id', null)), null),
			"timestamp" => $this->firstValue(array($this->pickValue($event, 'timestamp', null), $this->pickValue($event, 'ts', null)), null),
			"event_timestamp" => $this->firstValue(array($this->pickValue($event, 'timestamp', null), $this->pickValue($event, 'ts', null)), null)
		);

		return $row;
	}

	private function buildLegacyRow()
	{
		$arr = array();
		$arr["app"] = $this->input->post('app');
		$arr["edition"] = $this->input->post('edition');
		$arr["page"] = $this->input->post('page');
		$arr["position"] = $this->input->post('position');
		$arr["period"] = $this->input->post('period');
		$ipnya = $this->input->post('ip');
		$arr["browser"] = $this->input->post('browser');
		$arr["device"] = $this->input->post('device');
		$arr["size"] = $this->input->post('size');
		$arr["custom"] = $this->input->post('custom');
		$arr["years"] = $this->input->post('years');
		$country = $this->input->post('country');

		if (is_array($country)) {
			foreach ($country as $key => $value) {
				$arr[$key] = $value;
			}
		} else {
			$arr["country"] = $country;
		}

		if ($ipnya == "" || $ipnya == "unknown") {
			$ipnya = $this->getIP();
		}

		$arr["ip"] = $ipnya;

		if ($this->input->post("guid")) {
			$guid = $this->input->post('guid');
			if (strlen($guid) == 0) {
				$cookieGuid = $this->getCookieGuid();
				if ($cookieGuid) {
					$arr["guid"] = $cookieGuid;
				}
			} else {
				$arr["guid"] = $guid;
			}
		}

		if ($this->input->post("uq")) {
			$arr["uid"] = $this->input->post('uq');
		}

		if ($this->input->post("url")) {
			$arr["url"] = substr($this->input->post('url'), 0, 100);
		}

		return $arr;
	}

	private function pickValue($source, $key, $default = null)
	{
		return isset($source[$key]) ? $source[$key] : $default;
	}

	private function firstValue($values, $default = null)
	{
		foreach ($values as $value) {
			if ($value !== null && $value !== '') {
				return $value;
			}
		}

		return $default;
	}

	private function getCookieGuid()
	{
		return isset($_COOKIE['MAGS_ID']) ? $_COOKIE['MAGS_ID'] : null;
	}

	private function jsonResponse($data, $status = 200)
	{
		return $this->output
			->set_status_header($status)
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}
	
	private function getIP()
	{
		// Cloudflare
		if (!empty($_SERVER['HTTP_CF_CONNECTING_IP']) &&
			filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
			return $_SERVER['HTTP_CF_CONNECTING_IP'];
		}

		// Proxy / Load balancer
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			foreach ($ips as $ip) {
				$ip = trim($ip);
				if (filter_var($ip, FILTER_VALIDATE_IP)) {
					return $ip;
				}
			}
		}

		// Client IP langsung
		if (!empty($_SERVER['HTTP_CLIENT_IP']) &&
			filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
			return $_SERVER['HTTP_CLIENT_IP'];
		}

		return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
	}
}
