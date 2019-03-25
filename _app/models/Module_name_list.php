<?php 

class Module_name_list
{
	public $data;
	private $out = '';

	public function __construct()
	{
		$Database = new Database("db_test", array(
			"method"=>"select"
		));	

		$this->data = $Database->getter();
	}

	public function index()
	{
		if(isset($this->data)){
			$this->out .= '<ul>';
			foreach ($this->data as $key => $value) {
				$this->out .= sprintf('<li>%s</li>', $value["title"]);
			}
			$this->out .= '</ul>';
		}

		return $this->out;
	}
}