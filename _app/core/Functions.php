<?php 

class Functions
{
	public function load($function)
	{
		require_once '../_app/functions/' . $function . '.php';
		return new $function;
	}
}