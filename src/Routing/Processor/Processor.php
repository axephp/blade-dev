<?php

namespace Blade\Routing\Processor;

use Exception;
use ReflectionClass;

use Blade\Interfaces\AxE\IAxE as AxE;
use Blade\Interfaces\Routing\Processor\IProcessor;

use Blade\Routing\CompiledRoute;

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

		$compiled = $this->inside("AxE\\Pages", $request);

		foreach ($compiled->retrieveMiddlewares() as $key => $value) {
			$route->getRouter()->middleware($key, $value);
		}

		return $compiled;

	}


	public function inside($class, $request)
	{	

		$dir = Path::process($this->axe->pagesPath(), $request);
		$file = Path::controller($dir);

		if (file_exists($file)) {

			include_once $file;
			$class .= "\\".(implode("\\", $request));

			if (class_exists($class)) {
				
				$reflection = new ReflectionClass($class);
				$current = $request;
				$params = $this->requests;

				$compiled = new CompiledRoute($this->axe);
				$compiled->setRequest($current);
				$compiled->setParameters($params);
				$compiled->setPath($dir);
				$compiled->setReflection($reflection);

				return $compiled;
			}else{
				throw new Exception("Error Processing Class", 1);
			}

		}elseif (is_dir($dir)) {
			
			$new = array_shift($this->requests);

			if (!is_null($new)) {
				$request = [$request, $new];
				return $this->inside($class, $request);
			}else{
				throw new Exception("Error Processing Request", 1);
			}
			
		}else{
			throw new Exception("Error Processing Request", 1);
		}


	}


	public function blend($route)
	{	
		var_dump($route->action());

		$response = new SymfonyResponse();

		$response->setContent("Successful");

		$response->headers->set('Content-Type', "text/html");

		return $response;
	}
}