<?php

namespace Blade\AxE;

use ReflectionClass;
use Exception;
use Blade\Interfaces\AxE\AxE as IAxE;
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
    protected $managers = [ 'eventManager', 'routeManager'];


    /**
     * Loaded managers
     *
     * @var array
     */
    protected $loadedManagers = [];


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
    protected $configFile = 'axe.php';


    /**
     * Create a new AxE application
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct(string $basePath = null)
    {
        $this->attendance();
        $this->attendImportantManagers();

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
        $this->map(\Blade\Container\Container::class, $this);

        $this->register(['event' => \Blade\Events\Trigger::class]);

    }


    /**
     * Register important managers
     *
     * @return void
     */
    protected function attendImportantManagers()
    {   
        if (class_exists(\App\Managers\EventManager::class)) {
            $this->map('eventManager', new \App\Managers\EventManager($this));
        }else{
            $this->map('eventManager', new \Blade\Events\EventManager($this));
        }

        if (class_exists(\App\Managers\RouteManager::class)) {
            $this->map('routeManager', new \App\Managers\RouteManager($this));
        }else{
            $this->map('routeManager', new \AxE\Routing\RouteManager($this));
        }
    
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
    public function launch(array $managers = [])
    {
        $this->executed = true;

        $all = array_unique(array_merge_recursive($managers, $this->managers));

        foreach ($all as $manager) {

            $this->trigger("executing->".$manager, [$this]);
            $this->resolve($manager)->run($this);
            $this->loadedManagers[] = $manager;
            $this->trigger("executed->".$manager, [$this]);

        }
    }


    /**
     * Add Manager
     *
     * @param  mixed
     * @return void
     */
    public function addManager($manager)
    {
        if (is_array($manager)) {
            foreach ($manager as $man) {
                $this->managers[] = $this->trim($man);
            }
        }else{
            $this->managers[] = $this->trim($manager);
        }
        
    }


    /**
     * Blend page
     *
     * @param  CompiledRoute
     * @return void
     */
    public function process(CompiledRoute $route)
    {
        return $this->resolve(\Blade\Interfaces\Routing\Processor\Processor::class)->blend($route);
    }


    /**
     * Triggers Event
     *
     * @param string
     * @param array
     * @return void
     */
    public function trigger($event, $args = [])
    {
        $eventer = $this->resolve('event');
        $eventer->fire($event, $args);
    }

    public function log($log, $args = [])
    {
        $eventer = $this->resolve('log');
        $eventer->log($log, $args);
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
        return $this->path().DIRECTORY_SEPARATOR.'Managers';
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
     * Get the path to logs
     *
     * @return string
     */
    public function logPath()
    {
        return $this->storagePath().DIRECTORY_SEPARATOR.'logs';
    }


    /**
     * Get the path to the database directory
     *
     * @return string
     */
    public function databasePath()
    {
        return $this->databasePath ?: $this->storagePath().DIRECTORY_SEPARATOR.'database';
    }


    /**
     * Set the database directory
     *
     * @param  string  $path
     * @return $this
     */
    public function setDatabasePath($path)
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
    public function setStoragePath($path)
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
     * Get the path to the events directory
     *
     * @return string
     */
    public function eventPath()
    {
        return $this->userPath().DIRECTORY_SEPARATOR.'events';
    }


    /**
     * Get the path to the middlewares directory
     *
     * @return string
     */
    public function middlewarePath()
    {
        return $this->userPath().DIRECTORY_SEPARATOR.'middlewares';
    }


    /**
     * Get the path to the models directory
     *
     * @return string
     */
    public function modelPath()
    {
        return $this->userPath().DIRECTORY_SEPARATOR.'models';
    }


    /**
     * Get the path to the pages directory
     *
     * @return string
     */
    public function pagePath()
    {
        return $this->userPath().DIRECTORY_SEPARATOR.'pages';
    }


    /**
     * Get the path to the resources directory
     *
     * @return string
     */
    public function resourcePath()
    {
        return $this->userPath().DIRECTORY_SEPARATOR.'resources';
    }


    /**
     * Get the path to the themes directory
     *
     * @return string
     */
    public function themePath()
    {
        return $this->userPath().DIRECTORY_SEPARATOR.'themes';
    }


    /**
     * Get the path to tests
     *
     * @return string
     */
    public function testPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'tests';
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
        return $this->configPath().DIRECTORY_SEPARATOR.$this->configFile ?: $this->configPath().DIRECTORY_SEPARATOR.'axe.php';
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