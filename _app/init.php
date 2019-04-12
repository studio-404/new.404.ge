<?php 

require_once 'core/Config.php';
require_once 'core/Functions.php';
require_once 'core/Database.php';

error_reporting((Config::UNDER_CONSTRUCTION) ? E_ALL : 0); 
ini_set('display_errors', (Config::UNDER_CONSTRUCTION) ? 1 : 0);

$IP = new Database("db_ip", array(
	"method"=>"select",
	"page"=>0,
	"noLimit"=>true
));
$fetchIps = $IP->getter();
$allow = array();
foreach ($fetchIps as $v) {
	$allow[] = $v["ip"];
}

if(!in_array($_SERVER["REMOTE_ADDR"], $allow)){ die("Your Ip Address <b>(".$_SERVER["REMOTE_ADDR"].")</b> is not allowed. Please contact your administrator."); exit; }

require_once 'core/App.php';
require_once 'core/Controller.php';