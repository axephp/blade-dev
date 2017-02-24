<?php


namespace Blade\Interfaces\Container;


interface IContainer
{
	

	/**
     * Determine if the given type has been resolved.
     *
     * @param  string  $provider
     * @return bool
     */
	public function isResolved(string $provider);



	/**
     * Determine if the given type has been bound.
     *
     * @param  string  $provider
     * @return bool
     */
	public function isBound(string $provider);



	/**
     * Determine if the given type has been aliased.
     *
     * @param  string  $provider
     * @return bool
     */
	public function isAlias(string $alias);



	/**
     * Get the alias assigned to a provider.
     *
     * @param  string  $provider
     * @return string
     */
	public function getAlias(string $provider);



	/**
     * Assign alias to a type provider.
     *
     * @param  string  $alias
     * @param  string  $provider
     * @return void
     */
	public function alias(string $alias, string $provider);



	/**
     * Register a provider to service class.
     *
     * @param  mixed  $provider
     * @param  string $content
     * @param  bool   $shared
     * @return void
     */
	public function register($provider, string $content = null, bool $singleton = true);



	/**
     * Register a provider to service class.
     *
     * @param  mixed  $provider
     * @return bool
     */
	public function isSingleton($provider);



	/**
     * Resolve the type provider.
     *
     * @param  string $name
     * @param  array  $parameters
     * @return object
     */
	public function resolve(string $name, $parameters = []);


}
