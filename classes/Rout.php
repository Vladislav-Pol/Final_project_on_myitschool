<?php
namespace MyProject\classes;
use \MyProject\classes\RoutInterface;

class Rout implements RoutInterface
{
	protected array $routs;

	protected string $view;

	public function start($requestPath, $requestData)
	{
		if(array_key_exists($requestPath, $this->routs)) {
			$this->view = $this->routs[$requestPath][0];
			$class = $this->routs[$requestPath][1];
			$method = $this->routs[$requestPath][2];
		}

		if(isset($class) && isset($method)){
			$obModel = new $class;
			$arData = $obModel->$method($requestData);
		}


		echo'<pre>';
		var_dump($this->view);
		echo "</pre><br><br><br>";
		print_r($requestPath);
		print_r($requestData);
		// TODO: Implement start() method.
//		require_once
	}

	protected function get404view()
	{

	}

	public function __construct($routs)
	{
		foreach ($routs as $rout){
			$routPath = array_shift($rout);
			$this->routs[$routPath] = $rout;
		}
		$this->view = '';
	}
}