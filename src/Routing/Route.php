<?php

namespace Blade\Routing;

use Exception;

use Blade\Interfaces\Routing\Router as IRouter;
use Blade\Routing\Processor\Path;
use Blade\Interfaces\Routing\CompiledRoute as ICompiledRoute;
use Blade\Interfaces\Routing\Route as IRoute;

class Route implements IRoute
{


	/**
	 * Request of current route
	 *
	 * @var Request
	 */
	protected $request;

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
     * Get middlewares.
     *
     * @param  null
     * @return $this
     */
	public function gatherMiddleware()
	{
		return $this->router->getMiddlewares();
	}


	/**
     * Get middlewares
     *
     * @param  null
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