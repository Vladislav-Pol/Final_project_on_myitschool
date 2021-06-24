<?php
namespace MyProject\classes;

interface RoutInterface
{
	public function start($requestPath, $requestData);

	public function __construct($routs);
}