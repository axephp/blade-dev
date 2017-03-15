<?php

namespace Blade\Routing\Processor;

use Exception;
use ReflectionClass;

use Blade\Interfaces\AxE\AxE;
use Blade\Interfaces\Routing\Processor\Processor as IProcessor;

use Blade\Routing\CompiledRoute;
use Blade\Routing\CompiledAsset;

class Processor implements IProcessor
{
	
	protected $axe;

	protected $requests;

	protected $asset = false;


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
		$this->requests = array_flatten($route->requests());

		$request = array_shift($this->requests);

		if (empty($request)) {
			$request = explode('/', $this->axe->config('site')->home_page) ?: ["home"];
		}

		$compiled = $this->inside("User\\Pages", $request);

		foreach ($compiled->retrieveMiddlewares() as $key => $value) {
			$route->getRouter()->middleware($key, $value);
		}

		$compiled->setMethod($route->method()[0]);
		return $compiled;
	}


	/**
	 * Asset compilation
	 *
	 * @param AssetRoute
	 * @return CompiledAsset
	 */
	public function asset($route)
	{
		$this->requests = array_flatten($route->requests());
		array_shift($this->requests);

		$this->axe->map('asset', $route);

		$this->asset = true;

		$request = array_shift($this->requests);
		if (!is_array($request)) {
			$request = [$request];
		}
		$compiled = $this->inside("User\\Pages", $request);

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
			$class .= "\\".(implode("\\", array_flatten($request)));

			if (class_exists($class)) {
				
				$reflection = new ReflectionClass($class);
				$current = $request;
				$params = $this->requests;

				// Compiled Route
				$compiled = new CompiledRoute($this->axe);
				$compiled->setRequest($current);
				$compiled->setParameters($params);
				$compiled->setPath($dir);
				$compiled->setReflection($reflection);

				return $compiled;
				
			}else{
				throw new Exception("Error Processing Class '$class' ", 1);
			}

		}elseif (is_dir($dir) && !is_file($file)) {
			
			$new = array_shift($this->requests);
			if (!is_null($new)) {
				$request = [$request, $new];
				return $this->inside($class, $request);
			}else{
				throw new Exception("Error Processing Request", 12);
			} 
			
		}else{
			array_unshift($this->requests, $request);
			$request = ["home"];
			$dir = Path::process($this->axe->pagesPath(), $request);
			$file = Path::controller($dir);
			if (file_exists($file)) {
				return $this->inside($class, $request);
			}else{
				throw new Exception("Error Processing Request", 1936);
				
			}
			
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
		$this->axe->register(\Blade\Templating\Templater::class);
		if ($route instanceof CompiledRoute) {
			$output = $this->suber($route);

			if ($this->asset) {
				return $this->axe->resolve('asset')->compile($output);
			}

			return $this->axe->resolve(\Blade\Templating\Templater::class)->template($output);
		}
		else{
			$output = "Custom TODO";
		}	

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

		if ($this->asset) {
				
			$path = $compiled->getPath();
			$file = Path::process($path, $this->requests);

			if (!file_exists($file) || is_dir($file)) {
				throw new Exception("Error Processing Request", 191);
			}

			return $file;
		}

		$action = $reflection->getMethod($name);

		$parameters = $action->getParameters();
		$values = $compiled->getParameters();

		$args = $this->prepareParams($parameters, $values);

		$object = $reflection->newInstanceArgs([$this->axe]);

		ob_start();
		$actionReturn = $action->invokeArgs($object, $args);
		
		$content = ob_get_contents();
		ob_clean();

		if ($actionReturn['type'] == "route") {
			$new = $reflection->getMethod('router')->invokeArgs($object, [$compiled, $actionReturn['path']]);
			
			// TODO : Inside redirection
			// return $this->inside($new);
		}else{
			$output = $reflection->getMethod('prepare')->invokeArgs($object, [$compiled, $actionReturn, $content]);
			return $output;
		}		
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
		var_dump(func_get_args());
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
					$args[] = $values[$i] ?? null;
					$i++;
				}
			}

		}

		

		return $args;
	}
}