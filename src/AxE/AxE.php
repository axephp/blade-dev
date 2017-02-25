<?php

namespace Blade\AxE;

use ReflectionClass;
use Exception;
use Blade\Interfaces\AxE\IAxE;
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
     * Indicates if executed
     *
     * @var bool
     */
    protected $executed = false;


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


    /**
     * Create a new AxE application
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct($basePath = null)
    {
        $this->attendance();
        $this->attendManagers();
        $this->registerCoreContainerAliases();
        if ($basePath) {
            $this->setBasePath($basePath);
        }
    }


    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    protected function attendance()
    {
        $this->instance('axe', $this);
        $this->instance(Blade\Container\Container::class, $this);

        static::setInstance($this);
    }


    /**
     * Register all of the base service providers.
     *
     * @return void
     */
    protected function attendManagers()
    {
        $this->register(new EventManager($this));
        $this->register(new RouteManager($this));
    }

    /**
     * Determine if the managers have been executed
     *
     * @return bool
     */
    public function executed()
    {
        return $this->executed;
    }


    /**
     * Run the given managers
     *
     * @param  array  $managers
     * @return void
     */
    public function launch(array $managers)
    {
        $this->executed = true;
        foreach ($managers as $manager) {

            $this->handle($manager."_executing", [$this]);
            $this->resolve($manager)->run($this);
            $this->handle($manager."_executed", [$this]);

        }
    }


}