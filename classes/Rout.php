<?php
namespace MyProject\classes;
use \MyProject\classes\RoutInterface;

class Rout implements RoutInterface
{
	protected array $routs;

	protected string $view;

	public function start($requestPath, $requestData)
	{
		$arData = [];

		if(array_key_exists($requestPath, $this->routs)) {
			$this->view = $this->routs[$requestPath][0];
			$class = $this->routs[$requestPath][1];
			$method = $this->routs[$requestPath][2];
			$arData['title'] = $this->routs[$requestPath][3];
		}

		if(!empty($class)){
			$obModel = new $class($requestData);

			if(!empty($method)){
				$arData = array_merge($arData, $obModel->$method($requestData));
			}
		}


		$this->requireHeader($this->view, $arData);

		$this->requireView($this->view, $arData, $requestPath);

		$this->requireFooter($this->view);
	}

	protected function requireHeader($view, $arData)
	{
		$headerPath = DOCUMENT_ROOT . "/resources/views/$view";
		while (!file_exists($headerPath . '/header.php')){
			$reg = '/(\/[^\/]*)$/';
			$headerPath = preg_replace($reg, '', $headerPath);
		}
		require_once $headerPath . '/header.php';
	}

	protected function requireView($view, $arData, $requestPath)
	{
		$viewTemplatePath = DOCUMENT_ROOT . "/resources/views/$view/template.php";
		if(file_exists($viewTemplatePath)){
			require_once $viewTemplatePath;
		}
		else{
			$this->require404($requestPath);
		}
	}

	protected function requireFooter($view)
	{
		$footerPath = DOCUMENT_ROOT . "/resources/views/$view";
		while (!file_exists($footerPath . '/footer.php')){
			$reg = '/(\/[^\/]*)$/';
			$footerPath = preg_replace($reg, '', $footerPath);
		}
		require_once $footerPath . '/footer.php';
	}

	protected function require404($requestPath)
	{
		$pageName = $_SERVER['HTTP_HOST'] . $requestPath;
		$view404Path = DOCUMENT_ROOT . "/resources/views/404.php";
		require_once $view404Path;
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