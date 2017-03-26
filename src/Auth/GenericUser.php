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
	 * @return void
	 */
	public function getId()
	{

	}


	/**
	 * Return ID Name of Generic User
	 *
	 * @param null
	 * @return void
	 */
	public function getIdName()
	{

	}


	/**
	 * Return Password of Generic User
	 *
	 * @param null
	 * @return void
	 */
	public function getPassword()
	{

	}


	/**
	 * Return ID of Generic User
	 *
	 * @param null
	 * @return void
	 */
	public function getToken()
	{

	}


	/**
	 * Return TokenName
	 *
	 * @param
	 * @return 
	 */
	public function getTokenName()
	{

	}


	/**
	 * Magic Get
	 *
	 * @param null
	 * @return void
	 */
	public function __get()
	{

	}


	/**
	 * Magic SET
	 *
	 * @param null
	 * @return void
	 */
	public function __set()
	{

	}


	/**
	 * Magic Isset
	 *
	 * @param null
	 * @return void
	 */
	public function __isset()
	{

	}


	/**
	 * Magic Unset
	 *
	 * @param null
	 * @return void
	 */
	public function __unset()
	{

	}
}