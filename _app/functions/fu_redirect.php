<?php 

class fu_redirect
{
	public function gotoUrl($url = '')
	{
		if($url==""){
			$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";	
		}

		header("Location: ".$url);
		exit;
	}
}