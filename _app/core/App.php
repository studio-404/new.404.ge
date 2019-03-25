<?php 

class App
{
	public $language = Config::MAIN_LANGUAGE;
	protected $controller = Config::MAIN_CONTROLLER;
	protected $method = Config::MAIN_METHOD;
	protected $params = [];

	public function __construct()
	{
		$url = $this->parseUrl();

		if(isset($url[0])){
			$this->language = $url[0];
			unset($url[0]);
		}

		if(isset($url[1]) && file_exists('../_app/controllers/'.$url[1].'.php')){
			$this->controller = $url[1];
			unset($url[1]);
		}

		require_once '../_app/controllers/'.$this->controller.'.php';

		$this->controller = new $this->controller;
		
		if(isset($url[2])){
			if(method_exists($this->controller, $url[2])){
				$this->method = $url[2];
				unset($url[2]);
			}
		}

		$this->params = $url ? array_values($url) : [];
		array_unshift($this->params, $this->language);

		// echo "<pre>";
		// print_r($this->params);
		// echo "</pre>";

		call_user_func_array([$this->controller, $this->method], $this->params);
	}

	public function parseUrl()
	{
		if(isset($_GET['url'])){
			return $url = explode("/", filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}
}