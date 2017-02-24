<?php

namespace Blade\Routing\Processor;

use Exception;

use Blade\Interfaces\Container\IContainer as Container;
use Blade\Interfaces\Routing\IRouter;


class Processor implements IProcessor
{
	

	protected $requests;

	public function __construct()
	{
		
	}


	public function compile($route)
	{
		$this->requests = $route->requests();

		$request = array_shift($this->requests);

		$file = $this->inside("AxE\\Pages", $request);

	}


	public function inside($namespace, $request)
	{

		$dir = Path::process(Path::pagesDir(), $request);
		$file = Path::controller($dir);

		if ($file) {

			$class .= "\\".ucfirst($request);

			if (class_exists($class)) {

				$reflection = new ReflectionClass($class);

				var_dump($reflection);

			}else{
				//error
				throw new Exception("Error Processing Request", 1);				
			}	

		}else {

			$request = array_shift($this->requests);

			if (is_dir(Path::process($dir, $request))) {
				$this->inside($class, $request);
			}else{
				// home
			}
		}	
	}
}