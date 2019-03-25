<?php 

class Functions
{
	public function index($function)
	{
		require_once '../_app/functions/' . $function . '.php';
		return new $function;
	}
}