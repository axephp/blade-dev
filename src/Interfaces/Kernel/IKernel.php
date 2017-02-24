<?php

namespace Blade\Interfaces\Kernel;


use Blade\Interfaces\AxE\IAxE as AxE;
use Blade\Interfaces\Router\IRouter as Router;
use Blade\Interfaces\Router\IProcessor as Processor;


interface IKernel
{
	


	public function __construct(AxE $axe, Router $router);


	public function hasMiddleware($item);


	/**
     * Add a new middleware to beginning of the stack if it does not already exist.
     *
     * @param  string  $middleware
     * @return $this
     */
    public function prependMiddleware($middleware);


    /**
     * Add a new middleware to end of the stack if it does not already exist.
     *
     * @param  string  $middleware
     * @return $this	
     */
    public function pushMiddleware($middleware);


	public function boot($request);


	public function axe();

}