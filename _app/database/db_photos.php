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

	private function deletePhoto($args)
	{
		$update = "UPDATE `shindi_photos` SET 
		`status`=:one
		WHERE
		`id`=:id";

		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":one"=>1,
			":id"=>(int)$args["id"]
		));

		return true;
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

	private function selectByRoomId($args)
	{
		$db_fetch = [];
		
		$select = "SELECT * FROM `shindi_photos` WHERE `attach_id`=:attach_id AND `status`!=:one";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":attach_id"=>$args["attach_id"],
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}


}