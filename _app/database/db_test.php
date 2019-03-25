<?php 

class db_test
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("db_test", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	private function select($args)
	{
		$db_fetch = [];

		/* functions */
		$Functions = new Functions();
		$path = $Functions->index("fu_path");
		$create_file = $Functions->index("fu_create_file");
		
		if(file_exists($path->cache("db_test"))){
			$db_fetch = json_decode(
				file_get_contents(
					$path->cache("db_test")
				), 
				true
			);
		}else{
			$select = "SELECT * FROM `test`";
			$prepare = $this->conn->prepare($select);
			$prepare->execute();
			if($prepare->rowCount()){
				$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
				
				$create_file->json(
					$path->cache("db_test"), 
					$db_fetch
				);
			}
		}		

		return $db_fetch;
	}
}