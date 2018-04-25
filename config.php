<?php
@session_start();

date_default_timezone_set('Asia/Kolkata');
error_reporting(E_ALL); 
ini_set("display_errors", 1);

require_once "notification.php";

$env = "dev";

if ($env == "dev") {

	// Ip
	//$ip = '192.168.1.104/';
	$ip = 'localhost/';
	$cur_dir = $ip . 'lion_admin/';


	// URL
	$url['_base'] = 'http://' . $cur_dir;
	$url['_web'] = $url['_base'] .'web/';
	$url['_assets'] = $url['_web'] .'assets/';


	// PATH
	$path['_base'] = realpath(__DIR__.'/../');
	$path['_files'] = realpath(__DIR__.'/../').'/web/files/';


	// VALIDATION
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

	//AC TYPE for Device ////////

	$ac_type['cass'] = 'Cassette';
	$ac_type['duct'] = 'Ductable';
	$ac_type['split'] = 'Split';
	////////////////////////////////


	// DB CREDENTIALS
	$dbhost="localhost";
	$dbuser="root";
	$dbpass="x";
	$dbname="lion_bridge";

	// PDO CALL
	$conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("SET NAMES UTF8");
	



}elseif($env == "prod"){



	$ip = 'localhost/';
	$host_ip = $ip;
	$cur_dir = $ip . 'lion_admin/web/';

	$url['_base'] = 'http://' . $cur_dir;
	$url['_assets'] = $url['_base'] .'/view/';

	$path['_base'] = realpath(__DIR__.'/../../');
	$path['_image'] = $path['_base'] . '/view/images/';

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


	$dbhost="localhost";
	$dbuser="root";
	$dbpass="x";
	$dbname="lion_bridge";

	$conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("SET NAMES UTF8");
	return $conn;

}