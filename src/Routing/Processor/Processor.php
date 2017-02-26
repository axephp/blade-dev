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

		$file = $this->inside("AxE\\Pages", $request);

	}


	public function inside($class, $request)
	{

		$dir = Path::process($this->axe->pagesPath(), $request);
		$file = Path::controller($dir);

		if (is_file($file)) {

			$class .= "\\".ucfirst($request);

			var_dump($class);

		}else {

			$request = array_shift($this->requests);

			if (empty($request)) {
				$request = "home"; //$this->axe->config('home_page') ?: "home";
			}

			if (is_dir(Path::process($dir, $request))) {

				//$this->inside($class, $request);
				var_dump($this->requests);
			}
			
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