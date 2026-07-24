<?php
if(!isset($_SESSION)){
session_start();
}
/*if (!session_id()) {
	session_start(); 
}*/
include "vendor/autoload.php";

$appid = '464212687707069';

$fb = new Facebook\Facebook([
    'app_id' => $appid,
    'app_secret' => '128354dc2eb15c63c69568534f893877',    
    'default_graph_version' => 'v2.11',
    #'default_graph_version' => 'v3.2'
]);
/*echo $ZHost;
echo Z_Host;*/
#lokal

	/*$ZHost = Z_Host;
	$ZPort = Z_Port;
	$ZUser = Z_Users;
	$ZPass = Z_Pass;
	$ZDb   = Z_Db;*/
/*
	'hostname' => 'localhost:3308',
	'username' => 'root',
	'password' => 'toor',
	'database' => 'versoview',
	'dbdriver' => 'mysqli',
$dbf = new PDO("mysql:host=".Z_Host.":".Z_Port.";dbname=".Z_Db."",Z_Users,Z_Pass);
*/
#inet
#$dbf = new PDO("mysql:host=localhost;dbname=garuda_cLot3W","garuda_C0LoUr5C0","C0LoUR$1D@2R3Y");
#self::$connection = new mysqli('localhost','garuda_C0LoUr5C0','C0LoUR$1D@2R3Y','garuda_cLot3W');
