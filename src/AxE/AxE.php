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
     * The config file
     *
     * @var string
     */
    protected $configFile = 'site.conf';


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
    public function __construct(string $basePath = null)
    {
        $this->attendance();
        $this->attendManagers();

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

        $this->map('axe', $this);
        $this->map(IAxE::class, $this);
        $this->map(Blade\Container\Container::class, $this);

        //static::setInstance($this);
    }


    /**
     * Register all of the base service providers.
     *
     * @return void
     */
    protected function attendManagers()
    {
        //$this->register(new EventManager($this));
        //$this->register(new RouteManager($this));
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



    public function process($route)
    {
        return $this->resolve(\Blade\Interfaces\Routing\Processor\IProcessor::class)->blend($route);
    }


    public function handle($event, $args = [])
    {
        //skip
    }

    /**
     * Set the base path
     *
     * @param  string  $basePath
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');
        return $this;
    }


    /**
     * Get the path to the axe.
     *
     * @return string
     */
    public function systemPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'system';
    }


    /**
     * Get the path to the axe.
     *
     * @return string
     */
    public function path()
    {
        return $this->systemPath().DIRECTORY_SEPARATOR.'axe';
    }


    /**
     * Get the base path
     *
     * @return string
     */
    public function basePath()
    {
        return $this->basePath;
    }


    /**
     * Get the path to the managers directory
     *
     * @return string
     */
    public function bootstrapPath()
    {
        return $this->systemPath().DIRECTORY_SEPARATOR.'Managers';
    }


    /**
     * Get the path to the configuration files
     *
     * @return string
     */
    public function configPath()
    {
        return $this->systemPath().DIRECTORY_SEPARATOR.'configs';
    }


    /**
     * Get the path to the database directory
     *
     * @return string
     */
    public function databasePath()
    {
        return $this->databasePath ?: $this->basePath.DIRECTORY_SEPARATOR.'database';
    }


    /**
     * Set the database directory
     *
     * @param  string  $path
     * @return $this
     */
    public function useDatabasePath($path)
    {
        $this->databasePath = $path;
        return $this;
    }


    /**
     * Get the path to the language files
     *
     * @return string
     */
    public function langPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'lang';
    }


    /**
     * Get the path to the public_html directory
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'public_html';
    }


    /**
     * Get the path to the storage directory.
     *
     * @return string
     */
    public function storagePath()
    {
        return $this->storagePath ?: $this->basePath.DIRECTORY_SEPARATOR.'storage';
    }


    /**
     * Set the storage directory.
     *
     * @param  string  $path
     * @return $this
     */
    public function useStoragePath($path)
    {
        $this->storagePath = $path;
        return $this;
    }


    /**
     * Get the path to the resources directory.
     *
     * @return string
     */
    public function userPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'user';
    }


    /**
     * Get the path to the pages directory
     *
     * @return string
     */
    public function pagesPath()
    {
        return $this->userPath().DIRECTORY_SEPARATOR.'pages';
    }


    /**
     * Set the config file
     *
     * @param  string  $file
     * @return $this
     */
    public function loadConfig($file)
    {
        $this->configFile = $file;
        return $this;
    }


    /**
     * Get the config file
     *
     * @return string
     */
    public function configFile()
    {
        return $this->configPath().DIRECTORY_SEPARATOR.$this->configFile ?: 'site.conf';
    }


    /**
     * Get the fully qualified path to the config file
     *
     * @return string
     */
    public function configFilePath()
    {
        return $this->configPath().'/'.$this->configFile();
    }


    public function config($offset)
    {  

        return $this->resolve('config')[$offset];
    }


    /**
     * Determine if application is in local environment
     *
     * @return bool
     */
    public function isLocal()
    {
        return $this->config('site')->environment == 'development';
    }


    /**
     * Determine if console
     *
     * @return bool
     */
    public function isConsole()
    {
        return php_sapi_name() == 'cli';
    }


    /**
     * Determine if we are running unit tests
     *
     * @return bool
     */
    public function isUnitTests()
    {
        return $this->config('site')->environment == 'testing';
    }

}