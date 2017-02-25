<?php

namespace Blade\Interfaces\Kernel;


use Blade\Interfaces\AxE\IAxE as AxE;
use Blade\Interfaces\Routing\IRouter as Router;

interface IKernel
{
    
     /**
     * New HttpKernel instance
     *
     * @param AxE
     * @param Router
     * @param Processor
     * @return void
     */
    public function __construct(AxE $axe, Router $router);


    /**
     * Check middleware existence
     *
     * @param mixed
     * @return bool
     */
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


     /**
     * Boot up the framework
     *
     * @param Request
     * @return void
     */
    public function boot($request);


    /**
     * Returns AxE instance
     *
     * @param null
     * @return void
     */
    public function axe();

}