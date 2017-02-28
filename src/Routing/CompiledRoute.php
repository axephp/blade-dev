<?php

namespace Blade\Routing;

use Exception;

use Blade\Interfaces\Container\IContainer as Container;
use Blade\Interfaces\Routing\ICompiledRoute;
use Blade\Interfaces\AxE\IAxE as AxE;


class CompiledRoute implements ICompiledRoute
{


	/**
	 * The AxE instance
	 *
	 * @var AxE
	 */
	protected $axe;

	protected $reflection;  // ReflectionClass

	protected $request;    // array

	protected $params;     // array

	protected $directory;  // string

	protected $method;

	function __construct(AxE $axe)
	{
		$this->axe = $axe;
	}


	public function getReflection()
	{
		return $this->reflection;
	}

	public function setReflection($reflection)
	{
		$this->reflection = $reflection;
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

	public function setPath($path)
	{
		$this->directory = $path;
	}

	public function setParameters($params)
	{
		$this->params = $params;
	}

	public function getParameters()
	{
		return $this->params;
	}

	public function setMethod($method)
	{
		$this->method = $method;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function retrieveMiddlewares()
	{
		if ($this->reflection->hasProperty('middlewares')){
			$array = $this->reflection->getDefaultProperties()['middlewares'];

			return $array;
		}
	}

	public function action()
	{	
		if (isset($this->params[0])) {
			$action = $this->params[0].'_'.strtolower($this->method);

			if ($this->reflection->hasMethod($action)) {
				$this->request[] = array_shift($this->params);
				return $action;
			}elseif ($this->reflection->hasMethod('__arg_'.strtolower($this->method))) {
				return '__arg_'.strtolower($this->method);
			}
		}else {
			return 'index_'.strtolower($this->method);
		}

	}

}