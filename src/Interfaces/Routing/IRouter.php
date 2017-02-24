<?php

namespace Blade\Interfaces\Routing;

use Exception;

use Blade\Interfaces\AxE\IAxE as AxE;
use Blade\Interfaces\Http\IRequest as Request;

interface IRouter
{
	

    /**
     * Create a new Router instance.
     *
     * @param  AxE  $axe
     * @param  Processor  $processor
     * @return void
     */
	public function __construct(AxE $axe);


	/**
     * Register a new GET route with the router.
     *
     * @param  string  $uri
     * @return Route
     */
    public function get($uri);


    /**
     * Register a new POST route with the router.
     *
     * @param  string  $uri
     * @return Route
     */
    public function post($uri);


    /**
     * Register a new PUT route with the router.
     *
     * @param  string  $uri
     * @return Route
     */
    public function put($uri);


    /**
     * Register a new PATCH route with the router.
     *
     * @param  string  $uri
     * @return Route
     */
    public function patch($uri);


    /**
     * Register a new DELETE route with the router.
     *
     * @param  string  $uri
     * @return Route
     */
    public function delete($uri);


    /**
     * Register a new OPTIONS route with the router.
     *
     * @param  string  $uri
     * @return Route
     */
    public function options($uri);


    /**
     * Register a new route responding to all verbs.
     *
     * @param  string  $uri
     * @return Route
     */
    public function any($uri);


    /**
     * Dispatch the request to the application.
     *
     * @param  Request  $request
     * @return Route
     */
    public function route(Request $request, array $middlewares);


    /**
     * Get all of the defined middlewares
     *
     * @return array
     */
    public function getMiddlewares();


    /**
     * Register a middleware.
     *
     * @param  string  $name
     * @param  string  $class
     * @return $this
     */
    public function middleware($name, $class);


    /**
     * Get the current route instance.
     *
     * @return Route
     */
    public function getCurrentRoute();


    /**
     * Get the current route instance.
     *
     * @return Route
     */
    public function current();


    /**
     * Check if a route with the given name exists.
     *
     * @param  string  $name
     * @return bool
     */
    public function has($name);


    /**
     * Get the current route name.
     *
     * @return string|null
     */
    public function currentRouteName();


    /**
     * Get the current route action.
     *
     * @return Closure|string|null
     */
    public function currentRouteAction();


    /**
     * Determine if the current route action matches a given action.
     *
     * @param  string  $action
     * @return bool
     */
    public function currentRouteUses($action);


    /**
     * Get the request currently being dispatched.
     *
     * @return Request
     */
    public function getCurrentRequest();


    /**
     * Get the routes list.
     *
     * @return RouteList
     */
    public function getRoutes();


    /**
     * Set the route collection instance.
     *
     * @param  RouteList  $routes
     * @return void
     */
    public function setRoutes(RouteList $routes);


    /**
     * Disable fetching of given route
     *
     * @param  string  $route
     * @return void
     */
    public function disableFetch($route);


    /**
     * Block the given route
     *
     * @param  string  $route
     * @return void
     */
    public function block(string $route);


    /**
     * Fetch route for given uri
     *
     * @param  Request $request
     * @return Route
     *
     * @throws Exception
     */
    public function fetch($request);
    

}