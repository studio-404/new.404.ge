<?php 

class db_photos
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("db_photos", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	private function add($args)
	{
		$insert = "INSERT INTO `shindi_photos` SET 
		`type`=:type,
		`attach_id`=:attach_id,
		`mime_type`=:mime_type,
		`path`=:path,
		`size`=:size";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":type"=>$args["type"],
			":attach_id"=>$args["attach_id"],
			":mime_type"=>$args["mime_type"],
			":path"=>$args["path"],
			":size"=>$args["size"]
		));

		return true;
	}


}