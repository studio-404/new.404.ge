<?php 

class Controller
{
	public function model($model)
	{
		require_once '../_app/models/' . $model . '.php';
		return new $model;
	}

	private function template($data = [], $content){
		if($data){
			foreach ($data as $key => $value) {
				$content = preg_replace("/\[".$key."\]/", $value, $content);
			}
		}

		$content = preg_replace("/\<\!\-\- if (.*) \-\-\>/", '<?php if($1): ?>', $content);
		$content = preg_replace("/\<\!\-\- endif \-\-\>/", '<?php endif; ?>', $content);


		return $content;
	}

	public function view($view, $data = [])
	{
		$temp_file = '../_app/views/' . $view . '.tmp';
		if(file_exists($temp_file)):
			$content = file_get_contents('../_app/views/' . $view . '.tmp');
			$content = $this->template($data, $content);
			
			$that = $this;
			$content = preg_replace_callback(
			"/\[\#include (.*)\]/", 
				function($matches) use($that, $data){
					if(file_exists('../_app/views/'.$matches[1].'.tmp')){
						$file_get_contents = file_get_contents('../_app/views/'.$matches[1].'.tmp');
						return $that->template($data, $file_get_contents);
					}
				}, 
				$content
			);

			try{
				@eval(' ?> ' . $content . ' <?php ');

				if(error_get_last()){
				    echo '<b>Template parse error!</b>';
				    error_log(print_r(error_get_last(), true));
				}
			}catch(ParseError $e){
				die($e);
			}
			exit;
		endif;
	}
}