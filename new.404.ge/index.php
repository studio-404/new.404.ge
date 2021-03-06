<?php 
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
ini_set('post_max_size', '5120M');
ini_set('upload_max_filesize', '5120M');
ini_set('memory_limit', '5120M');
ini_set('session.cookie_httponly', 1);

session_start([
    'cookie_lifetime' => 86400,
    'read_and_close'  => true
]);

header('X-Frame-Options: DENY');
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('Asia/Tbilisi');

require_once '../_app/init.php';

$app = new App; 