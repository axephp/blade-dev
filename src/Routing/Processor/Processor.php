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

		$request = array_shift($this->requests);

		if (empty($request)) {
			$request = "home"; //$this->axe->config('home_page') ?: "home";
		}

		$file = $this->inside("AxE\\Pages", $request);

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

			if (!is_null($new)) {
				$request = [$request, $new];
				var_dump($request);
				Path::process($class, $request);	
			}else{
				throw new Exception("Error Processing Request", 1);
			}
			
		}else{
			throw new Exception("Error Processing Request", 1);
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