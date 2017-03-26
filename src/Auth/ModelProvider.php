<?php

namespace Blade\Auth;

use ReflectionClass;
use Exception;

class ModelProvider
{

	/**
	 * Model
	 *
	 * @var Model
	 */
	protected $model;


	/**
	 * Hasher
	 *
	 * @var Hasher
	 */
	protected $hasher;

	/**
	 * New ModelProvider Instance
	 *
	 * @param Hasher
	 * @param Model
	 * @return void
	 */
	public function __construct($hasher, $model)
	{
		$this->hasher 	= $hasher;
		$this->model 	= $model; 
	}


	/** 
	 * Set Model
	 *
	 * @param Model
	 * @return void
	 */
	public function setModel($model)
	{
		$this->model = $model;
	}


	/** 
	 * Set Hasher
	 *
	 * @param Hasher
	 * @return void
	 */
	public function setHasher($hasher)
	{
		$this->hasher = $hasher;
	}


	/**
	 * Return Model
	 *
	 * @param null
	 * @return Model
	 */
	public function getModel()
	{
		return $this->model;
	}


	/**
	 * Return Hasher
	 *
	 * @param null
	 * @return Hasher
	 */
	public function getHasher()
	{
		return $this->haser;
	}


	/**
	 * Retrieve by ID
	 *
	 * @param string
	 * @return
	 */
	public function retrieveById($id)
	{

	}


	/**
	 * Retrieve by token
	 *
	 * @param string
	 * @return
	 */
	public function retrieveByToken($id, $token)
	{

	}


	/**
	 * Update token
	 *
	 * @param string
	 * @param string
	 * @return
	 */
	public function updateToken($user, $token)
	{

	}


	/**
	 * Retrieve by Credentials
	 *
	 * @param array
	 * @return
	 */
	public function retrieveByCredentials($credentials)
	{

	}


	/**
	 * Validate Credentials
	 *
	 * @param string
	 * @param array
	 * @return
	 */
	public function retrieveByToken($user, $credentials)
	{

	}


	/**
	 * Create Model
	 *
	 * @param null
	 * @return
	 */
	public function createModel()
	{
		
	}

}