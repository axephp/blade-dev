<?php

namespace Blade\Kernel;

use Exception;
use Throwable;
use Blade\Interfaces\Kernel\Kernel as IKernel;


use Blade\Interfaces\AxE\AxE;
use Blade\Interfaces\Routing\Router;

use Blade\AxE\AxE_Error;

use Blade\AxE\Core\Configurer;
use Blade\AxE\Core\Shutter;
use Blade\AxE\Core\Logger;
use Blade\AxE\Core\Auther;

use Blade\Validation\ValidationManager as Validation;
use Blade\Session\SessionManager as Session;


class Kernel implements IKernel
{
	

	/**
	 * The AxE instance
	 *
	 * @var AxE
	 */
	protected $axe;


	/**
	 * The router instance
	 *
	 * @var Router
	 */
	protected $router;


	/**
	 * Managing classes for AxE
	 *
	 * @var AxE
	 */
	protected $managers = [
		Configurer::class, Shutter::class, Logger::class, Session::class, Validation::class //, Auther::class
	]; 


	/**
	 * Middlewares to execute
	 *
	 * @var AxE
	 */
	protected $middlewares = [ Auther::class ];


	/**
	 * The default middlewares
	 *
	 * @var AxE
	 */
	protected $default_middlewares = [ 
		
	];


     /**
	 * New HttpKernel instance
	 *
	 * @param AxE
	 * @param Router
	 * @param Processor
	 * @return void
	 */
	public function __construct(AxE $axe, Router $router)
	{

		$this->axe = $axe;
		$this->router = $router;

	}


	/**
	 * Check middleware existence
	 *
	 * @param mixed
	 * @return bool
	 */
	public function hasMiddleware($item)
	{
		return in_array($item, $this->middlewares);
	}


    /**
     * Add a new middleware to beginning of the stack if it does not already exist.
     *
     * @param  string  $middleware
     * @return $this
     */
    public function prependMiddleware($middleware)
    {
        if (array_search($middleware, $this->middlewares) === false) {
            array_unshift($this->middlewares, $middleware);
        }

        return $this;
    }


    /**
     * Add a new middleware to end of the stack if it does not already exist.
     *
     * @param  string  $middleware
     * @return $this	
     */
    public function pushMiddleware($middleware)
    {
        if (array_search($middleware, $this->middlewares) === false) {
            $this->middlewares[] = $middleware;
        }

        return $this;
    }


     /**
	 * Boot up the framework
	 *
	 * @param Request
	 * @return void
	 */
	public function boot($request)
	{
		
		try{

			$this->execute();

			$route = $this->router->route($request, $this->middlewares);

			$response = $this->axe->process($route);

			$this->axe->trigger("kernel_booted", [ $request, $response ]);

		}catch(Throwable $ex){

			if (!$this->axe->isConsole() && !$request->isAjax()) {
				$response = AxE_Error::render($this->axe, $request, $ex);
			}elseif ($request->isAjax()) {
				$response = json_encode($ex, JSON_PRETTY_PRINT);
			}else{
				$response = strip_tags($ex->getMessage());
			}
			
			$this->axe->trigger("kernel_booted", [ $request, $response ]);

		}


		return $response;
	}


	/**
	 * Execute the managers
	 *
	 * @param null
	 * @return void
	 */
	protected function execute()
	{
		if (!$this->axe->executed()) {
			$this->axe->launch($this->managers);
		}
		
	}


	public function end($request, $response)
	{
		$this->axe->resolve(\Blade\Log\Log::class)->save($request);

		// For Caching $response can be used
	}


	/**
	 * Returns AxE instance
	 *
	 * @param null
	 * @return void
	 */
	public function axe()
	{
		return $this->axe;
	}

}