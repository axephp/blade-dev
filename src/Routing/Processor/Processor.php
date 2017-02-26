<?php

namespace Blade\Routing\Processor;

use Exception;
use ReflectionClass;

use Blade\Interfaces\AxE\IAxE as AxE;
use Blade\Interfaces\Routing\Processor\IProcessor;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Processor implements IProcessor
{
	
	protected $axe;

	protected $requests;

	public function __construct(AxE $axe)
	{
		$this->axe = $axe;
	}


	public function compile($route)
	{
		$this->requests = $route->requests();

		//$request = array_shift($this->requests);

		var_dump($this->requests);

		if (empty($request)) {
			$request = "home"; //$this->axe->config('home_page') ?: "home";
		}

		//$file = $this->inside("AxE\\Pages", $request);

	}


	public function inside($class, $request)
	{	

		$dir = Path::process($this->axe->pagesPath(), $request);
		$file = Path::controller($dir);

		echo "$dir  | $file";

		if (file_exists($file)) {

			$class .= "\\".ucfirst($request);

			var_dump($class);

		}elseif (is_dir($dir)) {
			
			$new = array_shift($this->requests);
			$request = [$request, $new];

			$this->inside($class, $request);
			
		}else{
			// 
			echo "samosa";
		}


	}


	public function blend($route)
	{
		$response = new SymfonyResponse();

		$response->setContent("Successful");

		$response->headers->set('Content-Type', "text/html");

		return $response;
	}
}