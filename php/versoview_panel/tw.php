<?php
require 'application/libraries/Twitter/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY', getenv('CONSUMER_KEY'));
define('CONSUMER_SECRET', getenv('CONSUMER_SECRET'));
define('OAUTH_CALLBACK', getenv('OAUTH_CALLBACK'));

session_start();
$connection = new TwitterOAuth('ikYtLFZ5jg2m9SibBq5fXCBrQ', 'IcMaOtHxg6aKLKs4Kjk7dfSUwIPqPujvOvZgma5XmCbREakHpr');
$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => "http://localhost/agencyfish/weblist/versoview/tw-cl.php"));
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
var_dump($_SESSION['oauth_token']);
$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
echo "<a href='$url'>$url</a>";