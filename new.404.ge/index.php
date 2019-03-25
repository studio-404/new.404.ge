<?php 
session_start();
header('X-Frame-Options: DENY');
header("Content-type: text/html; charset=utf-8");
session_name("newwebsite");
date_default_timezone_set('Asia/Tbilisi');

ini_set('post_max_size', '5120M');
ini_set('upload_max_filesize', '5120M');
ini_set('memory_limit', '5120M');
ini_set('session.cookie_httponly', 1);

require_once '../_app/init.php';

$app = new App; 