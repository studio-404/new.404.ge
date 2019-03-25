<?php 

class fu_path
{
	public function cache($method, $additional = '')
	{
		$path = Config::DIR . Config::CACHE_FOLDER . "/".$method.$additional.".json";
		return $path;
	}
}