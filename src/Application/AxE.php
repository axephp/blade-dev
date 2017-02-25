<?php

namespace Blade\Application;

use ReflectionClass;
use Exception;
use Blade\Interfaces\Application\IAxE;
use Blade\Container\Container;


class AxE extends Container implements IAxE
{

    /**
     * The AxE PHP framework version.
     *
     * @var string
     */
    const VERSION = '2.0.3';


    /**
     * The base path
     *
     * @var string
     */
    protected $basePath;


    /**
     * Indicates if bootstrapped
     *
     * @var bool
     */
    protected $hasBeenBootstrapped = false;


    /**
     * Indicates if the application has "booted"
     *
     * @var bool
     */
    protected $booted = false;


    /**
     * All of the registered managers
     *
     * @var array
     */
    protected $managers = [];


    /**
     * Loaded managers
     *
     * @var array
     */
    protected $loadedProviders = [];


    /**
     * The database path
     *
     * @var string
     */
    protected $databasePath;


    /**
     * The storage path
     *
     * @var string
     */
    protected $storagePath;


    /**
     * The environment path
     *
     * @var string
     */
    protected $environmentPath;


    /**
     * The config file
     *
     * @var string
     */
    protected $configFile = '.config';


    /**
     * The application namespace.
     *
     * @var string
     */
    protected $namespace;


}