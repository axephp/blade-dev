<?php

namespace Blade\Routing;

use Exception;

use Blade\Interfaces\AxE\IAxE as AxE;
use Blade\Interfaces\Routing\IRouter;
use Blade\Interfaces\Routing\IProcessor as Processor;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;


class Router implements IRouter
{
	

	/**
	 * The AxE instance
	 *
	 * @var AxE
	 */
	protected $axe;


	/**
     * The route collection instance.
     *
     * @var RouteList
     */
    protected $routes;


 	/**
     * The currently processing route instance.
     *
     * @var CompiledRoute
     */
    protected $current;


    /**
     * The request currently being processed.
     *
     * @var Request
     */
    protected $currentRequest;


    /**
     * Middlewares of route
     *
     * @var array
     */
    protected $middlewares = [];


    /**
     * Blocked route
     *
     * @var array
     */
    protected $blocked = [];


    /**
     * All of the verbs supported by the router.
     *
     * @var array
     */
    public static $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];



    /**
     * Create a new Router instance.
     *
     * @param  AxE  $axe
     * @param  Processor  $processor
     * @return void
     */
	public function __construct(AxE $axe)
	{

		$this->axe = $axe;

	}


	/**
     * Register a new GET route with the router.
     *
     * @param  string  $uri
     * @return Route
     */
    public function get($uri)
    {
        return $this->add(['GET', 'HEAD'], $uri);
    }


    /**
     * Register a new POST route with the router.
     *
     * @param  string  $uri
     * @return Route
     */
    public function post($uri)
    {
        return $this->add('POST', $uri);
    }


    /**
     * Register a new PUT route with the router.
     *
     * @param  string  $uri
     * @return Route
     */
    public function put($uri)
    {
        return $this->add('PUT', $uri);
    }


    /**
     * Register a new PATCH route with the router.
     *
     * @param  string  $uri
     * @return Route
     */
    public function patch($uri)
    {
        return $this->add('PATCH', $uri);
    }


    /**
     * Register a new DELETE route with the router.
     *
     * @param  string  $uri
     * @return Route
     */
    public function delete($uri)
    {
        return $this->add('DELETE', $uri);
    }


    /**
     * Register a new OPTIONS route with the router.
     *
     * @param  string  $uri
     * @return Route
     */
    public function options($uri)
    {
        return $this->add('OPTIONS', $uri);
    }


    /**
     * Register a new route responding to all verbs.
     *
     * @param  string  $uri
     * @return Route
     */
    public function any($uri)
    {
        $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE'];
        return $this->add($verbs, $uri);
    }


    /**
     * Add a route to the underlying route collection.
     *
     * @param  array|string  $methods
     * @param  string  $uri
     * @return Route
     */
    protected function add($methods, $uri)
    {
        return $this->routes->insert($this->create($methods, $uri));
    }


    /**
     * Create a new route instance.
     *
     * @param  array|string  $methods
     * @param  string  $uri
     * @return Route
     */
    protected function create($methods, $uri)
    {
        
        return (new Route($methods, $uri))->setRouter($this);
    }


    /**
     * Dispatch the request to the application.
     *
     * @param  Request  $request
     * @return Route
     */
    public function route(Request $request, array $middlewares)
    {
        $this->currentRequest = $request;
        return $this->dispatch($request);
    }


    /**
     * Dispatch the request to route.
     *
     * @param  Request  $request
     * @return Route
     */
    protected function dispatch(Request $request)
    {
        # Checking and resolving of routes
        $route = $this->findRoute($request);

        $this->axe->handle("route_found", [ $route, $request ]);;

        return $route;
    }	


    /**
     * Get all of the defined middlewares
     *
     * @return array
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }


    /**
     * Register a middleware.
     *
     * @param  string  $name
     * @param  string  $class
     * @return $this
     */
    public function middleware($name, $class)
    {
        $this->middleware[$name] = $class;
        return $this;
    }


    /**
     * Get the current route instance.
     *
     * @return Route
     */
    public function getCurrentRoute()
    {
        return $this->current();
    }


    /**
     * Get the current route instance.
     *
     * @return Route
     */
    public function current()
    {
        return $this->current;
    }


    /**
     * Check if a route with the given name exists.
     *
     * @param  string  $name
     * @return bool
     */
    public function has($name)
    {
        return $this->routes->hasNamedRoute($name);
    }


    /**
     * Get the current route name.
     *
     * @return string|null
     */
    public function currentRouteName()
    {
        return $this->current() ? $this->current()->getName() : null;
    }


    /**
     * Get the current route action.
     *
     * @return Closure|string|null
     */
    public function currentRouteAction()
    {
        if (! $this->current()) {
            return;
        }
        $action = $this->current()->getAction();
        return isset($action) ? $action : null;
    }


    /**
     * Determine if the current route action matches a given action.
     *
     * @param  string  $action
     * @return bool
     */
    public function currentRouteUses($action)
    {
        return $this->currentRouteAction() == $action;
    }


    /**
     * Get the request currently being dispatched.
     *
     * @return Request
     */
    public function getCurrentRequest()
    {
        return $this->currentRequest;
    }


    /**
     * Get the routes list.
     *
     * @return RouteList
     */
    public function getRoutes()
    {
        return $this->routes;
    }


    /**
     * Find the route matching a given request.
     *
     * @param  Request  $request
     * @return Route
     */
    protected function findRoute($request)
    {
        $route = $this->routes->match($request);

        if ($route) {
        	$this->disableFetch($route);
        }else{
        	$route = $this->fetch($request);
        }
        $this->current = $route;

        $this->axe->instance(Route::class, $route);

        return $route;
    }


    /**
     * Set the route collection instance.
     *
     * @param  RouteList  $routes
     * @return void
     */
    public function setRoutes(RouteList $routes)
    {
        foreach ($routes as $route) {
            $route->setRouter($this);
        }
        
        $this->routes = $routes;

    }


    /**
     * Disable fetching of given route
     *
     * @param  string  $route
     * @return void
     */
    public function disableFetch($route)
    {
    		$route->fetachable(false);
    }


    /**
     * Block the given route
     *
     * @param  string  $route
     * @return void
     */
    public function block(string $route)
    {
    		// Block folder URL
    		$this->blocked[] = $route;
    }


    /**
     * Fetch route for given uri
     *
     * @param  Request $request
     * @return Route
     *
     * @throws Exception
     */
    public function fetch($request)
    {
            $uri = $request->uri();

    		if (!in_array($uri, $this->blocked)) {
    			$route =  (new Route($this->verbs, $request));
	    		$route->setRouter($this);

                $processor = $this->axe->resolve(Processor::class);
                
	    		return $processor->compile($route);

    		}else{
    			throw new Exception("Blocked route detected.", 1);
    			
    		}
    		
    }

}