<?php 

require_once 'core/Config.php';
require_once 'core/Functions.php';
require_once 'core/Database.php';

error_reporting((Config::UNDER_CONSTRUCTION) ? E_ALL : 0); 
ini_set('display_errors', (Config::UNDER_CONSTRUCTION) ? 1 : 0);

require_once 'core/App.php';
require_once 'core/Controller.php';