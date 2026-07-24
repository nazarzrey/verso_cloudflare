<?php

session_start();
require 'application/libraries/Twitter/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

var_dump($_SESSION['oauth_token']);
var_dump($_REQUEST['oauth_token']);

$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
    // Abort! Something is wrong.
}

$connection = new TwitterOAuth('ikYtLFZ5jg2m9SibBq5fXCBrQ', 'IcMaOtHxg6aKLKs4Kjk7dfSUwIPqPujvOvZgma5XmCbREakHpr', $request_token['oauth_token'], $request_token['oauth_token_secret']);

$access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);

var_dump($access_token);
$_SESSION['access_token'] = $access_token;
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth('ikYtLFZ5jg2m9SibBq5fXCBrQ', 'IcMaOtHxg6aKLKs4Kjk7dfSUwIPqPujvOvZgma5XmCbREakHpr', $access_token['oauth_token'], $access_token['oauth_token_secret']);

$user = $connection->get('account/verify_credentials', ['tweet_mode' => 'extended', 'include_entities' => 'true']);

var_dump($user);