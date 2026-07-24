<?php

#ajaxrequest adalah yang systemnya get
defined('BASEPATH') or exit('No direct script access allowed');

class Openview_theme extends CI_Controller
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
    public function index($id = '', $page = '', $open = '')
    {
        if (empty($id)) {
            echo  json_encode(array("result" => "this ajax openview " . $id));
        } else {
            #$return = $this->Mod_openview->openview_hdr($id,$page);
            #echo $return;
            $data_page  = min_space($page, "-");
            #echo "xx".$id.$data_page.current_url();
            $v_hdr = $this->Mod_openview->openview_hdr($id, $data_page);
            $v_dtl = $this->Mod_openview->openview_dtl($id, $data_page);

            #if(Host()=="localhost"){ 
            #}
            #var_dump($v_hdr[0]->magz_name);
            if ($v_dtl == "0") {
                $data["hdr_openview"] = $v_hdr;
            } else {
                $data["dtl_openview"] = $v_dtl;
            }
            $data["hdr_id"]   = $id;
            $data["hdr_page"] = $data_page;
            if (!empty($open)) {
                $this->load->view("backend/openview_template_single", $data);
            } else {
                $this->load->view("templates/openview_header", $data);
                $this->load->view("backend/openview_template", $data);
                $this->load->view("templates/openview_footer");
            }
        }
    }
    public function magz($var = null, $edisi = "")
    {
        $data["magz"]  = $var;
        $data["edisi"] = $edisi;
        if ($edisi == "") {
            $data["header"] = $this->Mod_openvi->magazine_data($var);
            $this->load->view("templates/theme1_content", $data, "", "");
        } else {
            $data["header"] = $this->Mod_openvi->magazine_data($edisi);
            $this->load->view("templates/theme1_content_ovi", $data, "", "");
        }
    }
    public function archive()
    {
        $data["header"] = $this->Mod_openvi->magazine_data("archive");
        $this->load->view("templates/theme1_archive", $data, "", "");
    }
    // public function header($status)
    // {
    //     $data = "";
    //     $this->load->view("templates/theme1_header", $data);
    // }
    // public function footer()
    // {
    //     $data     = "footer";
    //     $this->load->view("templates/theme1_footer", $data);
    // }
    // public function template($view, $data, $status, $form)
    // {
    //     $this->header($status);
    //     #die($form);
    //     if (!empty($form)) {
    //         $this->load->view("form/modal_form", $form);
    //     }
    //     if (is_array($data)) {
    //         $this->load->view($view, $data);
    //     } else {
    //         if ($data == "view") {
    //             $this->load->view($view);
    //         } else {
    //             echo $view;
    //         }
    //     }
    //     $this->footer();
    // }
}
