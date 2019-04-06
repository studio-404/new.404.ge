<?php 

class fu_upload_room_images
{
	public $images;
	public $message = [];
	public $room_id = 0;

	public function __construct()
	{
	}

	public function upload()
	{
		$uploadOk = 1;
		$target_dir = Config::DIR."uploads/";
		if(isset($this->images["files"]["name"][0])){
			$i = 0;
			foreach ($this->images["files"]["name"] as $key => $value):
				if($this->images["files"]["name"][$key]==""){
					continue;
				}

				$target_file = $target_dir . basename($this->images["files"]["name"][$key]);
				$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
				$target_new_file = $target_dir . $this->room_id."-".md5(time()).$i.".".$imageFileType;

				$check = getimagesize($this->images["files"]["tmp_name"][$key]);

				if($check !== false) {
			        $this->message[] = $this->images["files"]["name"][$key].": ოპერაცია წარმატებით დასტულდა.";
			        $uploadOk = 1;
			    } else {
			        $this->message[] = $this->images["files"]["name"][$key].": ფოტოს ატვირთვისას მოხდა შეცდომა.";
			        $uploadOk = 0;
			    }

			    if ($this->images["files"]["size"][$i] > Config::MAX_FILE_UPLOAD_SIZE) {
				    $this->message[] = $this->images["files"]["name"][$key].": ფოტოს ზომა აღემატება განსაზღვრულს.";
				    $uploadOk = 0;
				}

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
					$this->message[] = $this->images["files"]["name"][$key].": ფოტოს ფორმატი არასწორია.";
					$uploadOk = 0;
				}

				if ($uploadOk == 1) {
					if (move_uploaded_file($this->images["files"]["tmp_name"][$key], $target_new_file)) {
				        $this->message[] = $this->images["files"]["name"][$key].": ოპერაცია წარმატებით დასტულდა 2.";

				        $db_file_name = explode(Config::DIR, $target_new_file);
				        $db_file_name = isset($db_file_name[1]) ? $db_file_name[1] : "error";

				        $Database = new Database("db_photos", array(
				        	"method"=>"add",
				        	"type"=>"rooms",
				        	"attach_id"=>$this->room_id,
				        	"mime_type"=>$imageFileType,
				        	"path"=>$db_file_name,
				        	"size"=>$this->images["files"]["size"][$key]
				        ));
				    } else {
				        $this->message[] = $this->images["files"]["name"][$key].": მოხდა ფატალური შეცდომა.";
				    }
				} 

				$i++;
			endforeach;
		}

		return $this->message;
	}
}