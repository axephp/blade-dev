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

			if (class_exists($class)) {

				$reflection = new ReflectionClass($class);

				var_dump($reflection);

			}else{
				//error
				throw new Exception("Error Processing Request", 1);				
			}	

		}else {

			echo "Puhiyo";
			/*
			$request = array_shift($this->requests);

			if (is_dir(Path::process($dir, $request))) {
				$this->inside($class, $request);
			}else{
				// home
				var_dump("Home");
			}
			*/
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