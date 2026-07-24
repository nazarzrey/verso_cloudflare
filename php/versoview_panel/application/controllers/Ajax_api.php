<?php
#ajaxrequest adalah yang systemnya get
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_api extends CI_Controller {
	function __construct() {
		parent::__construct();
    	$this->load->library('session');
    	$this->load->model(array('Analitics'));
	}
	#index
	public function index(){
		echo  json_encode(array("result"=>"this api request"));
	}

	public function analitik(){
		
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
		$arr = array();
		$arr["app"] = $this->input->post('app');
		$arr["edition"] = $this->input->post('edition');
		$arr["page"] = $this->input->post('page');
		$arr["position"] = $this->input->post('position');
		$arr["period"] = $this->input->post('period');
		$arr["ip"] = $this->input->post('ip');
		$arr["country"] = $this->input->post('country');
		$arr["browser"] = $this->input->post('browser');
		$arr["device"] = $this->input->post('device');
		$arr["size"] = $this->input->post('size');
		$arr["custom"] = $this->input->post('custom');
		$arr["years"] = $this->input->post('years');
		
		$data = $this->Analitics->click($arr);
  		echo json_encode($this->input->post());
	}


	public function getip($ip = NULL, $purpose = "location", $deep_detect = TRUE)
	{
		$output = NULL;
	    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
	        $ip = $_SERVER["REMOTE_ADDR"];
	        if ($deep_detect) {
	            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
	                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
	                $ip = $_SERVER['HTTP_CLIENT_IP'];
	        }
	    }
	    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
	    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
	    $continents = array(
	        "AF" => "Africa",
	        "AN" => "Antarctica",
	        "AS" => "Asia",
	        "EU" => "Europe",
	        "OC" => "Australia (Oceania)",
	        "NA" => "North America",
	        "SA" => "South America"
	    );
	    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
	        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
	        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
	            switch ($purpose) {
	                case "location":
	                    $output = array(
	                        "city"           => @$ipdat->geoplugin_city,
	                        "state"          => @$ipdat->geoplugin_regionName,
	                        "country"        => @$ipdat->geoplugin_countryName,
	                        "country_code"   => @$ipdat->geoplugin_countryCode,
	                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
	                        "continent_code" => @$ipdat->geoplugin_continentCode
	                    );
	                    break;
	                case "address":
	                    $address = array($ipdat->geoplugin_countryName);
	                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
	                        $address[] = $ipdat->geoplugin_regionName;
	                    if (@strlen($ipdat->geoplugin_city) >= 1)
	                        $address[] = $ipdat->geoplugin_city;
	                    $output = implode(", ", array_reverse($address));
	                    break;
	                case "city":
	                    $output = @$ipdat->geoplugin_city;
	                    break;
	                case "state":
	                    $output = @$ipdat->geoplugin_regionName;
	                    break;
	                case "region":
	                    $output = @$ipdat->geoplugin_regionName;
	                    break;
	                case "country":
	                    $output = @$ipdat->geoplugin_countryName;
	                    break;
	                case "countrycode":
	                    $output = @$ipdat->geoplugin_countryCode;
	                    break;
	            }
	        }
	    }
	    return $output;
	}


	public function country(){
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
		$res = new stdClass();
		$res->ip = $_SERVER['REMOTE_ADDR'];
		$res->country = $this->getip("Visitor", "Country");
		echo json_encode($res);		
	}

}