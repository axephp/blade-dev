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


	/**
	 * The reflection instance
	 *
	 * @var Reflection
	 */
	protected $reflection;


	/**
	 * Array of request
	 *
	 * @var array
	 */
	protected $request;


	/**
	 * Array of parameters
	 *
	 * @var array
	 */
	protected $params;


	/**
	 * The directory path
	 *
	 * @var string
	 */
	protected $directory;


	/**
	 * The method name
	 *
	 * @var string
	 */
	protected $method;


	/**
	 * New CompiledRoute Instance
	 *
	 * @param AxE
	 * @return AxE
	 */
	function __construct(AxE $axe)
	{
		$this->axe = $axe;
	}


	/**
	 * Return reflection for the compiled route
	 *
	 * @param null
	 * @return Reflection
	 */
	public function getReflection()
	{
		return $this->reflection;
	}


	/**
	 * Set reflection for the compiled route
	 *
	 * @param Reflection
	 * @return void
	 */
	public function setReflection($reflection)
	{
		$this->reflection = $reflection;
	}


	/**
	 * Set request of the compiled route
	 *
	 * @param array
	 * @return void
	 */
	public function setRequest($request)
	{
		$this->request = $request;
	}


	/**
	 * Set path of the compiled route
	 *
	 * @param string
	 * @return void
	 */
	public function setPath($path)
	{
		$this->directory = $path;
	}


	/**
	 * Set parameters of the compiled route
	 *
	 * @param array
	 * @return void
	 */
	public function setParameters($params)
	{
		$this->params = $params;
	}


	/**
	 * Get parameters of the compiled route
	 *
	 * @param array
	 * @return void
	 */
	public function getParameters()
	{
		return $this->params;
	}


	/**
	 * Set method of the compiled route
	 *
	 * @param string
	 * @return void
	 */
	public function setMethod($method)
	{
		$this->method = $method;
	}


	/**
	 * Return request of the compiled route
	 *
	 * @param null
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}


	/**
	 * Return middlewares of the compiled route
	 *
	 * @param null
	 * @return arrray
	 */
	public function retrieveMiddlewares()
	{
		if ($this->reflection->hasProperty('middlewares')){
			$array = $this->reflection->getDefaultProperties()['middlewares'];

			return $array;
		}
	}


	/**
	 * Return action of the compiled route
	 *
	 * @param null
	 * @return string
	 */
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

