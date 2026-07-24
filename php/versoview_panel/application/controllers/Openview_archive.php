<?php

#ajaxrequest adalah yang systemnya get
defined('BASEPATH') or exit('No direct script access allowed');

class Openview_archive extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model(array('User_activity', 'Mod_openvi'));
        Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
        Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
        Header('Access-Control-Allow-Methods: GET, POST');
    }
    #index
    public function index()
    {
        // echo FCPATH;
        $marr = array("hain", "gnb", "ilw");
        if (DIRECTORY_SEPARATOR === '/') {
            $dire = "../html/openview/";
        } else {
            $dire = "../verso_openview/pageturner/";
        }
        $data[] = "";
        $mspath = str_replace("versoview\\", "", FCPATH);
        $masdir = $mspath . str_replace("../", "", $dire);
        if (is_dir($dire)) {
            $scan = scandir($dire);
            $hasil = "";
            foreach ($scan as $keys => $file) {
                $dir1 = $dire . $file;
                if (is_dir($dir1)) {
                    if (is_numeric($file)) {
                        // echo $dire . $file;
                        #scan subdir 3
                        $hasil = $this->scan($dir1, 5, $marr);
                    }
                }
            }
            dbg($hasil);
        } else {
            echo $dire . " not exists";
        }
    }

    public function scan($dir, $subdir, $marr)
    {
        global $data;
        if ($subdir > 0) {
            $scan = scandir($dir);
            foreach ($scan as $keys => $file) {
                $mdir = $dir . "/" . $file;
                if (is_dir($mdir)) {
                    if ($file != "." && $file != "..") {
                        $page   = $mdir . "/1.jpg";
                        if (file_exists($page) && strpos($mdir, "s/page") !== false && str_replace($marr, '', $mdir) != $mdir) {
                            $medium = str_replace("s/page", "s/medium", $mdir);
                            $med    = $medium . "/1.jpg";
                            if (!is_dir($medium)) {
                                echo " folder " . $medium . " sedang dibuat";
                                echo "<br/>";
                                mkdir($medium, 0755, true);
                            }
                            if (!file_exists($med)) {
                                $medium = sys('conv') . ' ' . $page . ' -sampling-factor 4:2:0 -strip -quality 90  -resize 373x497 -interlace JPEG -colorspace sRGB ' . $med;
                                echo "convert medium ->" . $medium;
                                echo "<br/>";
                                shell_exec($medium);
                            }
                            $data[]  = array($page);
                        }
                        $this->scan($mdir, $subdir - 1, $marr);
                    }
                }
            }
        }
        return $data;
    }
    // public function scan2($dir)
    // {
    //         $scan = scandir($dir);
    //         // echo $dir;
    //         foreach ($scan as $keys => $file) {
    //                 $mdir = $dir . "/" . $file;
    //                 if ($file != "." && $file != "..") {
    //                         echo $mdir;
    //                         echo "<br/>";
    //                 }
    //         }
    // }
    public function archive()
    {
    }
}
