<?php 

class fu_permision
{
	public function check($permition, $action)
	{
		if(isset($_SESSION["user_data"][$permition])){

			$explode = explode(",", $_SESSION["user_data"][$permition]);
			if(in_array($action, $explode)){
				return true;
			}
		}

		return false;
	}
}