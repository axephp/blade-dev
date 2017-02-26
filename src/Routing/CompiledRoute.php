<?php

namespace Blade\Routing;

use Exception;

use Blade\Interfaces\Container\IContainer as Container;
use Blade\Interfaces\Routing\ICompiledRoute;


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

	function __construct(AxE $axe)
	{
		$this->axe = $axe;
	}


	public function getReflection()
	{
		return $this->reflection;
	}

}