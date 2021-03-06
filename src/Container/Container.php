<?php

namespace Blade\Container;

use ReflectionClass;
use Exception;
use Blade\Interfaces\Container\Container as IContainer;

class Container implements IContainer
{
	

	/**
	 * Contains all resolved types
	 *
	 * @var array
	 */
	protected $resolved = [];


	/**
	 * Contains all maps
	 *
	 * @var array
	 */
	protected $maps = [];


	/**
	 * Contains all binded aliases
	 *
	 * @var array
	 */
	protected $binds = [];


	/**
	 * Contains all alias linkage
	 *
	 * @var array
	 */
	protected $aliases = [];

    /**
     * Self instance
     *
     * @var Container
     */
    protected static $instance;


	/**
     * Determine if the given type has been resolved.
     *
     * @param  string  $provider
     * @return bool
     */
	public function isResolved($provider)
	{
		
		$provider = $this->trim($provider);
		return isset($this->resolved[$provider]);

	}


	/**
     * Determine if the given type has been bound.
     *
     * @param  string  $provider
     * @return bool
     */
	public function isBound($provider)
	{

		$provider = $this->trim($provider);
		return isset($this->binds[$provider]);

	}


	/**
     * Determine if the given type has been mapped.
     *
     * @param  string  $name
     * @return bool
     */
	public function isMapped($name)
	{

		/**
		 * Checking if alias or provider 
		 */
		$provider = $this->resolveProvider($this->trim($name)); 

		return isset($this->maps[$provider]);

	}


	/**
     * Register/Bind a provider to service class. (alias)
     *
     * @param  mixed  $provider
     * @param  string $content
     * @param  bool   $shared
     * @return void
     */
	public function bind($provider, $content = null, $singleton = true)
	{
		return $this->register($provider, $content, $singleton);
	}


	/**
     * Determine if the given type has been aliased.
     *
     * @param  string  $provider
     * @return bool
     */
	public function isAlias($alias)
	{

		$alias = $this->trim($alias);
		return isset($this->aliases[$alias]);

	}


	/**
     * Get the alias assigned to a provider.
     *
     * @param  string  $provider
     * @return string|array
     */
	public function getAlias($provider)
	{

		if(!in_array($provider, $this->aliases))
			return $provider;

		$output = array_keys($this->aliases, $provider);

		if (count($output) == 1) {
			return $output[0];
		}

		sort($output);

		return $output;

	}


	/**
     * Gets the provider for given name
     *
     * @param  string  $name
     * @return string
     */
	protected function resolveProvider($name)
	{

		if (!$this->isAlias($name))
			return $name;

		
		return $this->resolveProvider($this->aliases[$name]);
	}


	/**
     * Assign alias to a type provider.
     *
     * @param  string  $alias
     * @param  string  $provider
     * @return void
     */
	public function alias($alias, $provider)
	{

		$provider = $this->trim($provider);

		$this->aliases[$alias] = $provider;
		

	}


	/**
     * Trims the trailing slashes in class names.
     *
     * @param  string  $name
     * @return string
     */
	protected function trim($name)
	{
		return is_string($name) ? ltrim($name, "\\") : $name;
	}


	/**
     * Register/Bind a provider to service class.
     *
     * @param  mixed  $provider
     * @param  string $content
     * @param  bool   $shared
     * @return void
     */
	public function register($provider, $content = null, $singleton = true)
	{
		
		if (!is_array($provider)) {
			$provider = $this->trim($provider);
		}

		if (!is_null($content)) {
			$content = $this->trim($content);
		}

		/**
		* When provider is array, it is assumed that alias is given.
		* [ alias => provider ];
		*/
		if (is_array($provider)) {

			list($alias, $provider) = [key($provider) , current($provider)];

			$this->alias($alias, $this->trim($provider));

		}

		$this->maps[$provider] = null;

		if (is_null($content)) {
			$content = $provider;
		}

		$this->binds[$this->trim($provider)] = ['class' => $content, 'singleton' => $singleton];

	}


	/**
	 * Unregister the registered provider
	 *
	 * @param mixed
	 * @return void
	 */
	public function unregister($provider)
	{
		$provider = $this->trim($provider);

		$this->binds[$provider] = null;
		$this->resolved[$provider] = null;

	}


    /**
     * Register an existing instance
     *
     * @param  string  $abstract
     * @param  mixed   $instance
     * @return void
     */
	public function map($provider, $instance)
	{
		
		$provider = $this->trim($provider);


		/**
		* When provider is array, it is assumed that alias is given.
		* [ alias => provider ];
		*/
		if (is_array($provider)) {

			list($alias, $provider) = [key($provider) , current($provider)];

			$this->alias($alias, $provider);

		}

		$this->maps[$provider] = &$instance;

	}


	/**
     * Register a provider to service class.
     *
     * @param  mixed  $provider
     * @return bool
     */
	public function isSingleton($provider)
	{

		if ( isset($this->maps[$provider]) ) {
			return true;
		}

		if ( !isset($this->binds[$provider]['singleton']) ) {
			return false;
		}

		return $this->binds[$provider]['singleton'] === true;
	}



	/**
     * Resolve the type provider.
     *
     * @param  string $name
     * @param  array  $parameters
     * @return object
     */
	public function resolve($name, $parameters = [])
	{
		
		/**
		 * Checking if alias or provider 
		 */
		$provider = $this->resolveProvider($this->trim($name)); 


		// If Already exists, return that.
		if (isset($this->maps[$provider]) && !is_null($this->maps[$provider])) {
			return $this->maps[$provider];
		}


		$class = $this->getClass($provider);


		//Object Generation
		if (class_exists($class)) {
			$reflection = new ReflectionClass($class);
		}else{
			throw new Exception("Provider for '$name' as '$class' not found", 1);
		}

		
		if (!$reflection->isInstantiable()) {	
			throw new Exception("Target is not instantiable.", 1);
		}


		$construct = $reflection->getConstructor();

		if ($construct) {

			# Fetching Dependencies
			$params = $construct->getParameters();
			$args = $this->prepareParams($params, $parameters);

			$object = $reflection->newInstanceArgs($args);

		}else{

			$object = $reflection->newInstance();
		}
		
		
		$this->resolved[$provider] = true;

		if ($this->isSingleton($provider)) {
			$this->maps[$provider] = &$object;
		}

		return $object;
	}


	/**
     * Prepare dependencies to inject.
     *
     * @param  array  $dependencies
     * @param  array  $parameters
     * @return array
     */
	protected function prepareParams($dependencies = [], $parameters)
	{
		$args = [];

		foreach ($dependencies as $dependency) {
			
			if (array_key_exists($dependency->name, $parameters)) {
				$args[] = $parameters[$dependency->name];
			}elseif (!is_null($dependency->getClass())) {
				
				try {
					$args[] = $this->resolve($dependency->getClass()->name);
				}
				catch (Exception $e) {
					if ($dependency->isOptional()) {
						$args[] = $dependency->getDefaultValue();
					}else{
						throw $e;
						
					}
				}

			}else{
				throw new Exception("Unresolvable Dependency : $dependency->name", 1);
				
			}

		}

		return $args;
	}



	/**
     * Gets the class for given name
     *
     * @param  string  $provider
     * @return string
     */
	protected function getClass($provider)
	{

		if (!isset($this->binds[$provider])) {
            return $provider;
        }

        return $this->binds[$provider]['class'];

	}



     /**
     * Store self instance
     *
     * @return void
     */
    public static function setInstance($instance)
    {
        return 	static::$instance = $instance;
    }


     /**
     * Returns the self instance
     *
     * @return AxE
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }


}
