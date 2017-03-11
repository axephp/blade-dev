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


	/**
	 * Content compilation
	 *
	 * @param Route
	 * @return CompiledRoute
	 */
	public function compile($route)
	{
		$this->requests = $route->requests();

		$request = array_shift($this->requests);

		if (empty($request)) {

			$request = explode('/', $this->axe->config('site')->home_page) ?: ["home"];
		}

		$compiled = $this->inside("AxE\\Pages", $request);

		foreach ($compiled->retrieveMiddlewares() as $key => $value) {
			$route->getRouter()->middleware($key, $value);
		}

		$compiled->setMethod($route->method()[0]);

		return $compiled;

	}


	/**
	 * Process inside the page
	 *
	 * @param string
	 * @param array
	 * @return CompiledRoute
	 */
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


	/**
	 * Blend Page
	 *
	 * @param CompiledRoute
	 * @return mixed
	 */
	public function blend($route)
	{	
		if ($route instanceof CompiledRoute) {
			$output = $this->suber($route);
		}else{
			$output = "Custom TODO";
		}
		

		$response = new SymfonyResponse();

		$response->setContent($output);

		$response->headers->set('Content-Type', "text/html");

		return $response;
	}


	/**
	 * Sub Page Processing
	 *
	 * @param CompiledRoute
	 * @return mixed
	 */
	public function suber($compiled)
	{	
		$name = $compiled->action();
		$reflection = $compiled->getReflection();

		$action = $reflection->getMethod($name);

		$parameters = $action->getParameters();
		$values = $compiled->getParameters();

		$args = $this->prepareParams($parameters, $values);

		$reflection->getParentClass()->getConstructor()->invoke($reflection->newInstanceWithoutConstructor());
		$object = $reflection->newInstanceWithoutConstructor();
		$output = $action->invokeArgs($object, $args);
		
		if ($output instanceof CompiledRoute) {
			return $this->suber($output);
		}

		return $output;
	}


	/**
	 * Prepare request parameters
	 *
	 * @param array
	 * @param array
	 * @return array
	 */
	protected function prepareParams($params, $values)
	{
		$args = [];
		$i = 0;
		foreach ($params as $key=>$param) {
			
			if (!is_null($param->getClass())) {
				
				try {
					$class = $param->getClass();
					$count = $class->getConstructor()->getNumberOfParameters();
					$tmp = array_slice($values, $i, $count - $i);
					if ($count != count($tmp)) {
						$args[] = $class->newInstanceWithoutConstructor();
						//throw new Exception("Error Processing Request", 1);
					}else{
						$object = $class->newInstanceArgs($tmp);
						$args[] = $object;
						$i += $count;
					}
					
				}
				catch (Exception $e) {
					throw $e;
				}

			}else{
				if ($key == count($params) - 1) {
					$args[] = array_slice($values, $i);
				}else{
					$args[] = $values[$i];
					$i++;
				}
			}

		}

		

		return $args;
	}
}