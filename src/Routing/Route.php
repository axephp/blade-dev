<?php

namespace Blade\Routing;

use Exception;

use Blade\Interfaces\Routing\IRouter as Router;
use Blade\Interfaces\Routing\IPath as Path;
use Blade\Interfaces\Routing\ICompiledRoute as CompileRoute;
use Blade\Interfaces\Routing\IRoute;

class Route implements IRoute
{


	/**
	 * Request of current route
	 *
	 * @var Request
	 */
	protected $request;


	/**
	 * Processing path of current route
	 *
	 * @var Path
	 */
	protected $path;


	/**
	 * The router instance
	 *
	 * @var Router
	 */
	protected $router;


	/**
	 * Array of HTTP Methods
	 *
	 * @var array
	 */
	protected $methods = [];


	/**
	 * Route fetch status
	 *
	 * @var bool
	 */
	protected $fetchable;


	/**
	 * The compiled route
	 *
	 * @var CompiledRoute
	 */
	protected $compiled;


	/**
	 * Route name
	 *
	 * @var string
	 */
	protected $name;


	/**
	 * New Route Instance
	 *
	 * @param array
	 * @param string
	 * @return void
	 */
	public function __construct(array $methods, $request)
	{
		$this->setMethod($methods);
		$this->request = $request;
	}


	/**
	 * Set router for this route
	 *
	 * @param Router
	 * @return void
	 */
	public function setRouter(Router $router)
	{
		$this->router = $router;
	}


	/**
	 * Return router for this route
	 *
	 * @param null
	 * @return Router
	 */
	public function getRouter()
	{
		return $this->router;
	}

	/**
	 * Return uri for this route
	 *
	 * @param null
	 * @return string
	 */
	public function getUri()
	{
		return $this->request->uri();
	}


	/**
	 * Return uri for this route (alias)
	 *
	 * @param null
	 * @return string
	 */
	public function uri()
	{
		return $this->getUri();
	}


	/**
	 * Set path for this route
	 *
	 * @param Path
	 * @return void
	 */
	public function setPath(Path $path)
	{
		$this->path = $path;
	}


	/**
	 * Return path for this route
	 *
	 * @param null
	 * @return Path
	 */
	public function getPath()
	{
		return $this->path;
	}


	/**
	 * Return path for this route (alias)
	 *
	 * @param null
	 * @return Path
	 */
	public function path()
	{
		return $this->getPath();
	}


	/**
	 * Set method(s) for this route
	 *
	 * @param array
	 * @return void
	 */
	public function setMethod(array $method)
	{
		$this->method = $method;
	}


	/**
	 * Return method(s) for this route
	 *
	 * @param null
	 * @return array
	 */
	public function getMethod()
	{
		return $this->method;
	}


	/**
	 * Return method(s) for this route (alias)
	 *
	 * @param null
	 * @return array
	 */
	public function method()
	{
		return $this->getMethod();
	}


	/**
	 * Set name for this route
	 *
	 * @param string
	 * @return void
	 */
	public function setName(string $name)
	{
		$this->name = $name;
	}


	/**
	 * Return name for this route
	 *
	 * @param null
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * Return name for this route (alias)
	 *
	 * @param null
	 * @return string
	 */
	public function name()
	{
		return $this->getName();
	}


	/**
     * Register a middleware.
     *
     * @param  string  $name
     * @param  string  $class
     * @return $this
     */
	public function gatherMiddleware()
	{
		return $this->router->getMiddlewares();
	}


	/**
     * Register a middleware.
     *
     * @param  string  $name
     * @param  string  $class
     * @return $this
     */
	public function middleware()
	{
		return $this->gatherMiddleware();
	}


	/**
	 * Set fetchable for this route
	 *
	 * @param bool
	 * @return void
	 */
	public function setFetchable(string $fetchable)
	{
		$this->fetchable = $fetchable;
	}


	/**
	 * Set fetchable for this route (alias)
	 *
	 * @param bool
	 * @return void
	 */
	public function fetchable(string $fetchable)
	{
		$this->setFetchable($fetchable);
	}


	/**
	 * Return domain name for the site
	 *
	 * @param null
	 * @return string
	 */
	public function domain()
	{
		return explode('/', str_replace(['http://', 'https://'], '', $this->uri()))[0];
	}


	/**
	 * (NEEDS MAINTENANCE) Return status of HTTP
	 *
	 * @param null
	 * @return bool
	 */
	public function isHttp()
	{
		return strpos($this->url(), 'http') !== false;
	}


	/**
	 * (NEEDS MAINTENANCE) Return status of HTTPS
	 *
	 * @param null
	 * @return bool
	 */
	public function isHttps()
	{
		return strpos($this->url(), 'https') !== false;
	}


	/**
	 * Return request array
	 *
	 * @param string
	 * @return $this
	 */
	public function requests()
	{
		return $this->request->requests();

	}


	/**
	 * Return request array (alias)
	 *
	 * @param string
	 * @return $this
	 */
	public function getRequests()
	{
		return $this->requests();
	}

}