<?php
session_start();

date_default_timezone_set('Asia/Kolkata');
error_reporting(E_ALL); 
ini_set("display_errors", 1);

//require_once "notification.php";

$env = "dev";

if ($env == "dev") {

	// Ip
	//$ip = '192.168.1.104/';
	$ip = 'localhost/';

	$cur_dir = $ip . 'PROJECT_NAME/';


	// URL
	$url['_base'] = 'http://' . $cur_dir;
	$url['_web'] = $url['_base'] .'web/';
	$url['_assets'] = $url['_web'] .'assets/';


	// PATH
	$path['_base'] = realpath(__DIR__.'/../');
	$path['_files'] = realpath(__DIR__.'/../').'/web/files/';


	// VALIDATION PATTERN
	$val['id'] = '/^[0-9.]*$/';
	$val['number'] = '/^[0-9 +]*$/';
	$val['text'] = '/^[a-zA-Z .,]*$/';
	$val['title'] ='/^[a-zA-Z .,]*$/';
	$val['description'] = '/^[a-zA-Z0-9 ,.:;?=_\-&\'"()\[\]\\/*@#!^]*$/';
	$val['password'] = '/^[a-zA-Z0-9_ @.,#]*$/';
	$val['address'] = '/^[a-zA-Z0-9 ,-]*$/'; 
	$val['date_time'] ='/^[a-zA-Z0-9\/-]*$/';
	$val['url'] = '/^[a-zA-Z0-9\/\-.?=+&:]*$/';
	$val['lat_long'] = '/^[a-zA-Z0-9.#]*$/';
	$val['greeeting_msg'] = '/^[a-zA-Z0-9 ,.?!\-\"\'`\(\)\{\[\]\}]*$/';

	// DB CREDENTIALS
	$dbhost="HOST";
	$dbuser="USER";
	$dbpass="PASS";
	$dbname="DB_NAME";

	// PDO CALL
	$conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("SET NAMES UTF8");

}elseif($env == "prod"){

	// Ip
	//$ip = '192.168.1.104/';
	$ip = 'localhost/';

	$cur_dir = $ip . 'PROJECT_NAME/';


	// URL
	$url['_base'] = 'http://' . $cur_dir;
	$url['_web'] = $url['_base'] .'web/';
	$url['_assets'] = $url['_web'] .'assets/';


	// PATH
	$path['_base'] = realpath(__DIR__.'/../');
	$path['_files'] = realpath(__DIR__.'/../').'/web/files/';


	// VALIDATION PATTERN
	$val['id'] = '/^[0-9.]*$/';
	$val['number'] = '/^[0-9 +]*$/';
	$val['text'] = '/^[a-zA-Z .,]*$/';
	$val['title'] ='/^[a-zA-Z .,]*$/';
	$val['description'] = '/^[a-zA-Z0-9 ,.:;?=_\-&\'"()\[\]\\/*@#!^]*$/';
	$val['password'] = '/^[a-zA-Z0-9_ @.,#]*$/';
	$val['address'] = '/^[a-zA-Z0-9 ,-]*$/'; 
	$val['date_time'] ='/^[a-zA-Z0-9\/-]*$/';
	$val['url'] = '/^[a-zA-Z0-9\/\-.?=+&:]*$/';
	$val['lat_long'] = '/^[a-zA-Z0-9.#]*$/';
	$val['greeeting_msg'] = '/^[a-zA-Z0-9 ,.?!\-\"\'`\(\)\{\[\]\}]*$/';

	// DB CREDENTIALS
	$dbhost="HOST";
	$dbuser="USER";
	$dbpass="PASS";
	$dbname="DB_NAME";

	// PDO CALL
	$conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("SET NAMES UTF8");

}
