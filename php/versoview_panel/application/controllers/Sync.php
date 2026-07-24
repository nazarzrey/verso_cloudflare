<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sync extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('Mod_sync');
   }
   public function index($value = "", $value2 = "")
   {
      echo $value;
   }
   public function syncip($value = "", $value2 = "", $value3 = "")
   {
      if ($value != "" || $value2 != "") {
         if ($value3 != "") {
            $cek = $this->db->query("SELECT DISTINCT (ip) as ip FROM history WHERE app='$value' and (IFNULL(country,'')='' OR IFNULL(regional,'')='' OR IFNULL(city,'')='') AND IFNULL(ip,'')!='' limit 100");
            // dbg($cek->result());
            foreach ($cek->result() as $key => $value) {
               $ip =  $value->ip;
               echo $this->ipapi($ip);
               echo "<br>";
            }
         } else {
            /*
            $this->db->select("distinct(ip)");
            $cek  = $this->db->get_where("history_bca_94", array("app" => "bca", "edition" => "94", "length(ip)>" => 0));
            dbg($cek->result());
            */
            $qry = $this->db->query("CALL report('$value','$value2')");
            $has = $qry->result();
            echo json_encode($has);
         }
      }
   }
   public function ipapi($ip = "")
   {
      $this->db->select("country,regional,city");
      $cek = $this->db->get_where("ip", array("ip" => $ip));
      $has = $cek->result();
      $ttl = count($has);
      if ($ttl > 0) {
         $cnt = $has[0]->country;
         $reg = $has[0]->regional;
         $cty = $has[0]->city;
         $data = array("country" => $cnt, "regional" => $reg, "city" => $cty);
		 if(strlen($cnt)<2){
			echo $ip . " ga ketemu -> get ipregistry";
			$this->ipregistry($ip, "");
		 }else{
			 if(strlen(strlen($reg)+strlen($reg))<2){
				 echo  $ip." coba ke ip-api.com ";
				 echo $this->ip_api_co($ip);
			 }else{
				 $this->isi($ip, $data);
				 echo $ip . " -> [local data] => ";
			 }
		 }
		 
		 echo " [".$cnt." - ".$reg." - ".$cty."]";
      } else {
         echo "<br>";
         echo $ip . " ga ketemu -> get ipregistry";
         $this->ipregistry($ip, "");
      }
   }

   public function isi($ip, $data)
   {
      $cek = $this->Mod_sync->updDataForm("history", "edit", "ip", $ip, $data);
	  $cek = true;
      return $cek;
   }

   public function ipregistry($ip = "", $tipe = "")
   {
      if (strlen($ip)) {
         $ipapi = file_get_contents("https://api.ipregistry.co/" . $ip . "?key=y26gtsgowgon7wzh");
         if ($tipe == "cek") {
            dbg($ipapi);
         }
         $obj  = json_decode($ipapi);
         $isp  = $obj->connection->domain;
         $ispx = $obj->connection->organization;
         $loc  = $obj->location->country->name;
         $reg  = $obj->location->region->name;
         $cty  = $obj->location->city;
		if(strlen($loc)<2){		
			$this->ip_api_co($ip);
		}else{
			echo "data ipregistry.co ".$loc." ".$reg." ".$cty;
			 $data = array(
				"ip" => $ip,
				"country"     => $loc,
				'regional' => $reg,
				'city' => $cty,
				'isp' => $isp,
				'isp_dtl' => $ispx,
				'ip_data' => json_encode($obj),
				'updrec_date' => date('y-m-d H:i:s')
			 );
			 $data2 = array("country" => $loc, "regional" => $reg, "city" => $cty);
			 $isi = $this->Mod_sync->updDataForm("ip", "add", "ip", $ip, $data);
			 if ($isi) {
				$this->isi($ip, $data2);
			 }
		}
      }
      usleep(250);
   }
   
   public function ip_api_co($ip = "")
   {
      if (strlen($ip)) {
		echo $ip." lokasi di ipregistry.co ga ketemu, -> coba ambil dari  ip-api.com";			
		$loc = file_get_contents('http://ip-api.com/json/'.$ip);
		$obj = json_decode($loc);
		 $data = array(
			"ip" => $ip,
			"country"     => $obj->country,
			'regional' => $obj->regionName,
			'city' => $obj->city,
			'isp' => $obj->isp,
			'isp_dtl' => $obj->org,
			'ip_data' => json_encode($obj),
			'updrec_date' => date('y-m-d H:i:s')
		 );
		 $data2 = array("country" => $obj->country, "regional" => $obj->regionName, "city" => $obj->city);
		 $isi = $this->Mod_sync->updDataForm("ip", "add", "ip", $ip, $data);
		 if ($isi) {
			$this->isi($ip, $data2);
		 }
      }
      usleep(250);
   }
}
