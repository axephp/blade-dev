<?php

namespace Blade\Interfaces\Routing;

use Exception;

use Blade\Interfaces\Routing\IRouter as Router;
use Blade\Interfaces\Routing\IPath as Path;


interface IRoute
{


	/**
	 * New Route Instance
	 *
	 * @param array
	 * @param string
	 * @return void
	 */
	public function __construct(array $methods, $request);


	/**
	 * Set router for this route
	 *
	 * @param Router
	 * @return void
	 */
	public function setRoute(Router $router);


	/**
	 * Return router for this route
	 *
	 * @param null
	 * @return Router
	 */
	public function getRoute();


	/**
	 * Return uri for this route
	 *
	 * @param null
	 * @return string
	 */
	public function getUri();


	/**
	 * Return uri for this route (alias)
	 *
	 * @param null
	 * @return string
	 */
	public function uri();


	/**
	 * Set path for this route
	 *
	 * @param Path
	 * @return void
	 */
	public function setPath(Path $path);


	/**
	 * Return path for this route
	 *
	 * @param null
	 * @return Path
	 */
	public function getPath();


	/**
	 * Return path for this route (alias)
	 *
	 * @param null
	 * @return Path
	 */
	public function path();


	/**
	 * Set method(s) for this route
	 *
	 * @param array
	 * @return void
	 */
	public function setMethod(array $method);


	/**
	 * Return method(s) for this route
	 *
	 * @param null
	 * @return array
	 */
	public function getMethod();


	/**
	 * Return method(s) for this route (alias)
	 *
	 * @param null
	 * @return array
	 */
	public function method();


	/**
	 * Set name for this route
	 *
	 * @param string
	 * @return void
	 */
	public function setName(string $name);


	/**
	 * Return name for this route
	 *
	 * @param null
	 * @return string
	 */
	public function getName();


	/**
	 * Return name for this route (alias)
	 *
	 * @param null
	 * @return string
	 */
	public function name();


	/**
     * Register a middleware.
     *
     * @param  string  $name
     * @param  string  $class
     * @return $this
     */
	public function gatherMiddleware();


	/**
     * Register a middleware.
     *
     * @param  string  $name
     * @param  string  $class
     * @return $this
     */
	public function middleware();


	/**
	 * Set fetchable for this route
	 *
	 * @param bool
	 * @return void
	 */
	public function setFetchable(string $fetchable);


	/**
	 * Set fetchable for this route (alias)
	 *
	 * @param bool
	 * @return void
	 */
	public function fetchable(string $fetchable);


	/**
	 * Return domain name for the site
	 *
	 * @param null
	 * @return string
	 */
	public function domain();


	/**
	 * (NEEDS MAINTENANCE) Return status of HTTP
	 *
	 * @param null
	 * @return bool
	 */
	public function isHttp();


	/**
	 * (NEEDS MAINTENANCE) Return status of HTTPS
	 *
	 * @param null
	 * @return bool
	 */
	public function isHttps();


	/**
	 * Return request array
	 *
	 * @param string
	 * @return $this
	 */
	public function requests();


	/**
	 * Return request array (alias)
	 *
	 * @param string
	 * @return $this
	 */
	public function getRequests();


	/**
	 * (NEEDS MAINTENANCE) Compile route for current action
	 *
	 * @param string
	 * @return $this
	 */
	public function compileRoute($name);

}