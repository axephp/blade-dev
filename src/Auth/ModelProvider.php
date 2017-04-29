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
		$model = $this->createModel();
        return $model->newQuery()
            ->where($model->getIdName(), $id)
            ->first();
	}


	/**
	 * Retrieve by token
	 *
	 * @param string
	 * @return
	 */
	public function retrieveByToken($id, $token)
	{
 		$model = $this->createModel();
        return $model->newQuery()
            ->where($model->getAuthIdentifierName(), $id)
            ->where($model->getRememberTokenName(), $token)
            ->first();
	}


	/**
	 * Update token
	 *
	 * @param object
	 * @param string
	 * @return
	 */
	public function updateToken($user, $token)
	{
        $user->setRememberToken($token);
        $timestamps = $user->timestamps;
        $user->timestamps = false;
        $user->save();
        $user->timestamps = $timestamps;
	}


	/**
	 * Retrieve by Credentials
	 *
	 * @param array
	 * @return
	 */
	public function retrieveByCredentials($credentials)
	{
		if (empty($credentials)) {
            return;
        }
        
        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->createModel()->newQuery();
        foreach ($credentials as $key => $value) {
            if (! string_contains($key, 'password')) {
                $query->where($key, $value);
            }
        }
        return $query->first();

	}


	/**
	 * Validate Credentials
	 *
	 * @param string
	 * @param array
	 * @return
	 */
	public function validate($user, $credentials)
	{
		$plain = $credentials['password'];
        return $this->hasher->check($plain, $user->getAuthPassword());
	}


	/**
	 * Create Model
	 *
	 * @param null
	 * @return
	 */
	public function createModel()
	{
		$class = '\\'.ltrim($this->model, '\\');
        return new $class;	}

}