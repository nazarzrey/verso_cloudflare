<?php
#ajaxrequest adalah yang systemnya get
defined('BASEPATH') or exit('No direct script access allowed');

class Client extends CI_Controller
{

    public function index($value = "")
    {
        echo $value;
        if (uri_string() == "colours") {
            header('location: https://versoview.com/openview/airlines/garuda-indonesia/colours/');
        } else {
            echo  json_encode(array("result" => "this api request "));
        }
        #
    }

    public function list($value = "")
    {
        $dir = "./";
        $img = "/files/thumb/1.jpg";
        // $url = "https://versoview.com/openview/airlines/garuda-indonesia/colours/";
        $url = "http://localhost/versoview/pageturner/colours/";
        #$mpath = "/var/www/html/openview/";
        $mpath = "/var/www/html/versoview/pageturner/";
        if ($value == "colours" || $value == "ecolours" || $value == "gia") {
            #$xpath = "airlines/garuda-indonesia/colours/";
            $xpath = "colours/";
        } elseif ($value == "bca") {
            $xpath = "finance/bca/";
        }
        $dir = $mpath . $xpath;
        $a = scandir($dir, 1);
        foreach ($a as $key => $direk) {
            $path = $dir . $direk;
            if (is_dir($path)) {
                if ($direk != ".." && $direk != "." && is_numeric($direk)) {
                    //if($direk!=".." && $direk!="."){
                    $b = scandir($path, 1);
                    if (is_array($b)) {
                        $month = array();
                        foreach ($b as $folder) {
                            $path2 = $path . "/" . $folder;
                            if (is_dir($path2)) {
                                if ($folder != ".." && $folder != ".") {
                                    $cek = $dir . "/" . $direk . "/" . $folder . $img;
                                    if (file_exists($cek)) {
                                        $month[] = $direk . "/" . $folder;
                                        // echo $folder;
                                    }
                                }
                            }
                        }
                        $json[] = $this->order_bulan($url, $direk, $month);
                    }
                }
            }
        }
        $json["total"] = count($json);
        $json["url"] = $url;
        echo json_encode($json);
        // dbg($json);
    }
    public    function order_bulan($dir, $thn, $bln)
    {
        global $img;
        $bl = array();
        foreach ($bln as $key => $value) {
            $mon  = date_parse($value);
            $bl[] = $mon["month"];
        }
        rsort($bl);
        $file = array();
        foreach ($bl as $mon) {
            $file[] = $thn . "/" . $this->bln($mon);
        }
        return $file;
    }


    public    function bln($bln)
    {
        $dateObj   = DateTime::createFromFormat('!m', $bln);
        return $monthName = $dateObj->format('F'); // March
    }
}
