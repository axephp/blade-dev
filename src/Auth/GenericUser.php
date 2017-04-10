<?php

namespace Blade\Auth;

use ReflectionClass;
use Exception;

class GenericUser
{
	/**
	 * Attributes Array of Generic User
	 *
	 * @var array
	 */
	protected $attributes = [];


	/**
	 * New GenericUser Instance
	 *
	 * @param array
	 * @return void
	 */
	public function __construct($attributes)
	{
		$this->attributes = $attributes;
	}


	/**
	 * Return ID of Generic User
	 *
	 * @param null
	 * @return string
	 */
	public function getId()
	{
		return 'id';
	}


	/**
	 * Return ID Name of Generic User
	 *
	 * @param null
	 * @return mixed
	 */
	public function getIdName()
	{
		$name = $this->getAuthIdentifierName();
        	return $this->attributes[$name];
	}


	/**
	 * Return Password of Generic User
	 *
	 * @param null
	 * @return string
	 */
	public function getPassword()
	{
		return $this->attributes['password'];
	}


	/**
	 * Return ID of Generic User
	 *
	 * @param null
	 * @return string
	 */
	public function getToken()
	{
		return $this->attributes[$this->getRememberTokenName()];
	}


	/**
     * Set the "remember me" token value.
     *
     * @param  string  $value
     * @return void
     */
    	public function setRememberToken($value)
    	{
        	$this->attributes[$this->getRememberTokenName()] = $value;
    	}


	/**
	 * Return TokenName
	 *
	 * @param
	 * @return 
	 */
	public function getTokenName()
	{
		return 'remember_token';
	}


	/**
	 * Magic Get
	 *
	 * @param string
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->attributes[$key];
	}


	/**
	 * Magic SET
	 *
	 * @param string
	 * @param mixed
	 * @return void
	 */
	public function __set($key, $value)
	{
		$this->attributes[$key] = $value;
	}


	/**
	 * Magic Isset
	 *
	 * @param null
	 * @return void
	 */
	public function __isset($key)
	{
		return isset($this->attributes[$key]);
	}


	/**
	 * Magic Unset
	 *
	 * @param null
	 * @return void
	 */
	public function __unset($key)
	{
		unset($this->attributes[$key]);
	}
}