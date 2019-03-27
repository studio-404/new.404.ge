<?php 

class fu_redirect
{
	public function gotoUrl($url = '')
	{
		header("Location: ".$url);
		exit;
	}
}