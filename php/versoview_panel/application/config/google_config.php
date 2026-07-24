<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------
| Google API Configuration
|--------------------------------------------------------
|
| To get API details you have to create a Google app
| at Google Application Management (https://apps.google.com/app/new)
| 
| google_consumer_key        string   Your Google App Key.
| google_consumer_secret    string   Your Google App secret.
| google_redirect_url        string   URL to redirect back to after login. (do not include base URL)
|
*/

#$config['google_id']     		= '656596008436-kk761fnq5as3p0dd2pbe4aup9o3iiq28.apps.googleusercontent.com';
#$config['google_id']     		= '656596008436-1kfru6flrkljmmqfi9k2nfb7iqugj1ho.apps.googleusercontent.com'; #new auth
$config['google_id']     		= '277606920663-l7u1pmoomsaimlj4vkuvuqm23o891av5.apps.googleusercontent.com'; #new auth
#$config['google_secret']  		= 'PJpbgPzuU8XagjzKVLsdFe3E';
#$config['google_secret']  		= 'lijHcBR-5dxoITZH03nMtMDw';
$config['google_secret']  		= 'pHH2mlXt5fFeI9CEItOfsuct';
$config['google_redirect_url']  = base_url().'login/goauth';
#echo base_url().'login/goauth';

/*$clientID = '';
$clientSecret = 'PJpbgPzuU8XagjzKVLsdFe3E';
$redirectUri = 'http://localhost/ci/google-login-native/go.php';
*/