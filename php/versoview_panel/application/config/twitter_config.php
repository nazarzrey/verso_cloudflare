<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------
| Twitter API Configuration
|--------------------------------------------------------
|
| To get API details you have to create a Twitter app
| at Twitter Application Management (https://apps.twitter.com/app/new)
| 
| twitter_consumer_key        string   Your Twitter App Key.
| twitter_consumer_secret    string   Your Twitter App secret.
| twitter_redirect_url        string   URL to redirect back to after login. (do not include base URL)
|
*/
$config['twitter_consumer_key']     = 'ikYtLFZ5jg2m9SibBq5fXCBrQ';
$config['twitter_consumer_secret']  = 'IcMaOtHxg6aKLKs4Kjk7dfSUwIPqPujvOvZgma5XmCbREakHpr';
$config['twitter_redirect_url']     = base_url().'login/twauth';