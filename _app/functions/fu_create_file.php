<?php 

class fu_create_file
{
	public function json($filename, $data)
	{
		$fh = fopen($filename, 'w') or die("Error opening output file");
		@fwrite($fh, json_encode($data,JSON_UNESCAPED_UNICODE));
		@fclose($fh);
	}
}