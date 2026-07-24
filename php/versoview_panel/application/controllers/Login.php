<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/Twitter/autoload.php');
#require_once(APPPATH.'libraries/Google/auth/autoload.php');
require_once(APPPATH . 'vendor/autoload.php');
#require_once(APPPATH.'libraries/Google/apiclient/src/Google/autoload.php');
#require_once(APPPATH.'libraries/Google/apiclient/src/Google/client.php');
#require_once(APPPATH.'libraries/Google/auth/src/OAuth2.php');

use Abraham\TwitterOAuth\TwitterOAuth;
#use Google\AuthClient\AuthClient;
#use Google\AuthClient;
#use Google\OAuth2\Auth;


class Login extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model(array('Mod_login', 'Mod_data', 'Socmed'));
    $this->load->library(array('facebook', 'session'));
    $this->config->load('twitter_config');
    $this->config->load('google_config');
  }

  public function index()
  {
    $data[] = "x";
    #echo Host();
    if (Host() == "localhost" || Host() == "192.168.31.162") {
      $data['fb_login'] = array();
      $data['tw_login'] = array();
      $data['go_login'] = array();
    } else {
      $data['fb_login'] = $this->facebook->login_url();
      $data['tw_login'] = $this->twlogin();
      $data['go_login'] = $this->goauth();
    }
    $this->load->view("templates/backend_header", $data);
    $this->load->view("backend/v_login", $data);
    $this->load->view("templates/backend_footer", $data);
  }
  public function custom($value = "")
  {
    $data[] = "x";
    #echo Host();
    $last = $this->uri->total_segments();
    $data["clients"] = $this->uri->segment($last);
    // dbg($record_num);
    echo Host();
    if (Host() == "localhost" || Host() == "192.168.1.201") {
      $data['fb_login'] = array();
      $data['tw_login'] = array();
      $data['go_login'] = array();
    } else {
      $data['fb_login'] = $this->facebook->login_url();
      $data['tw_login'] = $this->twlogin();
      $data['go_login'] = $this->goauth();
    }
    $this->load->view("templates/backend_header", $data);
    $this->load->view("backend/v_login_custom", $data);
    $this->load->view("templates/backend_footer", $data);
  }

  public function signup()
  {
    $data[] = "x";
    $data['fb_login'] = $this->facebook->login_url();
    $data['tw_login'] = $this->twlogin();
    $data['go_login'] = $this->goauth();
    $this->load->view("templates/backend_header", $data);
    $this->load->view("backend/v_signup", $data);
    $this->load->view("templates/backend_footer", $data);
  }

  public function goauth()
  {
    #require_once(APPPATH.'libraries/Google/auth/src/OAuth2.php');    
    #require_once(APPPATH.'libraries/Google/apiclient/src/Google/apiclient.php');

    $client = new Google_Client();
    #var_dump($this->config->item('google_redirect_url'));
    #var_dump($this->config->item('twitter_consumer_key'));
    $client->setClientId($this->config->item('google_id'));
    $client->setClientSecret($this->config->item('google_secret'));
    $client->setRedirectUri($this->config->item('google_redirect_url'));
    $client->addScope("email");
    $client->addScope("profile");

    // authenticate code from Google OAuth Flow
    if (isset($_GET['code'])) {
      $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
      if (!$token['access_token']) {
        redirect('login');
        die();
      }
      $client->setAccessToken($token['access_token']);
      // get profile info
      $google_oauth   = new Google_Service_Oauth2($client);
      $userProfile    = $google_oauth->userinfo->get();
      #var_dump($userProfile);  
      $goid   = $userProfile->id;
      $gomail = $userProfile->email;
      $goname = $userProfile->name;
      $go_fnm = $userProfile->given_name;
      $go_lnm = $userProfile->family_name;
      $go_sex = $userProfile->gender;
      $go_lok = $userProfile->locale;
      $go_img = $userProfile->picture;
      $go_url = ""; #$userProfile->url;
      $go_array = array($goname, $go_fnm, $go_lnm, $go_sex, $go_lok, $go_img, $go_url);
      #var_dump($userProfile);
      #echo "<br/><br/>";
      $insertgo = $this->Mod_login->go_auth($goid, $gomail, $go_array);
      #var_dump($insertgo);
      #echo "<br/><br/>";
      $cek = $this->Mod_login->cek($gomail, $goid, "go");
      #var_dump($cek);
      if ($cek->num_rows() > 0) {
        $this->setSession($cek, "go", $go_img);
      }
    } else {
      $url = $client->createAuthUrl();
      return $url;
    }
  }

  public function twlogin()
  {
    $connection = new TwitterOAuth($this->config->item('twitter_consumer_key'), $this->config->item('twitter_consumer_secret'));
    $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => $this->config->item('twitter_redirect_url')));

    #echo "x";
    #var_dump($request_token."XX");
    $_SESSION['oauth_token'] = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
    #var_dump($_SESSION['oauth_token']);
    $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
    return $url;
  }

  public function twauth()
  {
    $request_token = [];
    $request_token['oauth_token'] = $_SESSION['oauth_token'];
    $request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

    if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
      echo 'Abort! Something is wrong.';
    }

    $connection = new TwitterOAuth($this->config->item('twitter_consumer_key'), $this->config->item('twitter_consumer_secret'), $request_token['oauth_token'], $request_token['oauth_token_secret']);
    $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);
    #var_dump($access_token);
    $_SESSION['access_token'] = $access_token;
    $access_token = $_SESSION['access_token'];
    $connection = new TwitterOAuth($this->config->item('twitter_consumer_key'), $this->config->item('twitter_consumer_secret'), $access_token['oauth_token'], $access_token['oauth_token_secret']);
    $userProfile = $connection->get('account/verify_credentials', ['tweet_mode' => 'extended', 'include_entities' => 'true', 'include_email' => 'true']);

    #var_dump($userProfile);
    $twid   = $userProfile->id;
    $twmail = $userProfile->email;
    $twname = $userProfile->name;
    $tw_fnm = $userProfile->screen_name;
    $tw_lok = $userProfile->location;
    $tw_img = str_replace("_normal", "", $userProfile->profile_image_url);
    $tw_url = "https://twitter.com/" . $tw_fnm;
    $tw_array = array($twname, $tw_fnm, $tw_lok, $tw_img, $tw_url);

    $inserttw = $this->Mod_login->tw_auth($twid, $twmail, $tw_array);
    #var_dump($inserttw);
    $cek = $this->Mod_login->cek($twmail, $twid, "tw");
    if ($cek->num_rows() > 0) {
      $this->setSession($cek, "tw", $tw_img);
    }
  }

  public function loginfb()
  {
    #var_dump($this->facebook->is_authenticated());
    if ($this->facebook->is_authenticated()) {
      $userProfile = $this->facebook->request('get', '/me?fields=id,name,first_name,last_name,email,gender,locale,picture.type(large)');
      $fbid   = $userProfile['id'];
      $fbmail = $userProfile['email'];
      $fbname = $userProfile['name'];
      $fb_fnm = $userProfile['first_name'];
      $fb_lnm = $userProfile['last_name'];
      $fb_sex = ""; #$userProfile['gender'];
      $fb_lok = ""; #$userProfile['locale'];
      $fb_img = $userProfile['picture']['data']['url'];
      $fb_url = ""; #$userProfile['url'];
      $fb_array = array($fbname, $fb_fnm, $fb_lnm, $fb_sex, $fb_lok, $fb_img, $fb_url);

      #$fb_array = array($fbname,"","","","","","");
      $this->Mod_login->fb_auth($fbid, $fbmail, $fb_array);
      $cek = $this->Mod_login->cek($fbmail, $fbid, "fb");
      if ($cek->num_rows() > 0) {
        $this->setSession($cek, "fb", $fb_img);
      }
    } else {
    }
  }

  public function validate()
  {
    $this->form_validation->set_rules('useremail', 'useremail', 'required|trim');
    $this->form_validation->set_rules('password', 'password', 'required|trim');
    if ($this->form_validation->run() == FALSE) {
      redirect('login');
    } else {
      $usr = $this->input->post('useremail');
      $psw = $this->input->post('password');
      $cek = $this->Mod_login->cek($usr, $psw, "web");
      if ($cek->num_rows() > 0) {
        $this->setSession($cek, "web", "");
      } else {
        $this->session->set_flashdata('result_login', 'Username atau Password yang anda masukkan salah.');
        redirect(base_url('login'));
      }
    }
  }

  public function setSession($cek, $tipe, $img)
  {
    foreach ($cek->result() as $qad) {
      $sess_data['uid']   = $qad->user_id;
      $sess_data['uname'] = $qad->user_name;
      $sess_data['utype'] = $qad->user_type;
      $sess_data['uacc']  = $qad->user_account;
      $sess_data['uem']   = $qad->user_email;
      $sess_data['uph']   = $qad->user_phone;
      if ($tipe == "web") {
        $sess_data['uimg']  = $qad->$P_img;
      } else {
        # $P_img = "user_".$tipe."_img";
        #$img   = $img;
        $sess_data['uimg']  = $img;
      }
      $sess_data['prov']  = $tipe;
      $this->session->set_userdata($sess_data);
    }
    $this->session->set_flashdata('success', 'Login Berhasil !');
    redirect(admin_url(""));
  }

  public function fbmobile()
  {
    if ($this->input->post('email')) {
      $userProfile = $this->facebook->request('get', '/me?fields=id,name,first_name,last_name,email,gender,locale,picture.type(large)');
      $fbid   = $this->input->post('id');
      $fbmail = $this->input->post('email');
      $fbname = $this->input->post('name');
      $fb_fnm = $this->input->post('first_name');
      $fb_lnm = $this->input->post('last_name');
      $fb_sex = "";
      $fb_lok = "";
      $fb_img = "";
      $fb_url = "";
      $fb_array = array($fbname, $fb_fnm, $fb_lnm, $fb_sex, $fb_lok, $fb_img, $fb_url);

      $this->Mod_login->fb_auth($fbid, $fbmail, $fb_array);
      $cek = $this->Mod_login->cek($fbmail, $fbid, "fb");
      echo json_encode('sukses broo');
    }
  }

  public function twtmobile()
  {
    if ($this->input->post('email')) {
      $twid   = $this->input->post('id');
      $twmail = $this->input->post('email');
      $twname = $this->input->post('name');
      $tw_fnm = '';
      $tw_lok = '';
      $tw_img = '';
      $tw_url = '';
      $tw_array = array($twname, $tw_fnm, $tw_lok, $tw_img, $tw_url);

      $inserttw = $this->Mod_login->tw_auth($twid, $twmail, $tw_array);
      #var_dump($inserttw);
      $cek = $this->Mod_login->cek($twmail, $twid, "tw");
      echo json_encode('sukses broo');
    }
  }

  public function gomobile()
  {
    if ($this->input->post('email')) {
      $goid   = $this->input->post('id');
      $gomail = $this->input->post('email');
      $goname = $this->input->post('name');
      $go_fnm = $this->input->post('');
      $go_lnm = $this->input->post('');
      $go_sex = $this->input->post('');
      $go_lok = $this->input->post('');
      $go_img = $this->input->post('');
      $go_url = "";
      $go_array = array($goname, $go_fnm, $go_lnm, $go_sex, $go_lok, $go_img, $go_url);
      $insertgo = $this->Mod_login->go_auth($goid, $gomail, $go_array);
      $cek = $this->Mod_login->cek($gomail, $goid, "go");
      echo json_encode('sukses broo');
    }
  }
}
