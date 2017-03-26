<?php

namespace Blade\Auth;

use ReflectionClass;
use Exception;

class DatabaseProvider
{

	/**
	 * Database Connection
	 *
	 * @var Connection
	 */
	protected $connection;


	/**
	 * Table Requested
	 *
	 * @var Table
	 */
	protected $table;


	/**
	 * Hash
	 *
	 * @var Hasher
	 */
	protected $haser;

	/**
	 * New DatabaseProvider Instance
	 *
	 * @param Connection
	 * @param Table
	 * @param Hasher
	 */
	public function __construct($connection, $table, $hasher)
	{
		$this->connection 	= $connection;
		$this->table 		= $table;
		$this->hasher
	}


	/**
	 * Set Connection
	 *
	 * @param Connection
	 * @return void
	 */
	public function setConnection($connection)
	{
		$this->connection = $connection;
	}


	/**
	 * set Table
	 *
	 * @param Table
	 * @return void
	 */
	public function setTable($table)
	{
		$this->table = $table;
	}


	/**
	 * set Hasher
	 *
	 * @param Hasher
	 * @return void
	 */
	public function setHasher($hasher)
	{
		$this->hasher = $haser;
	}


	/**
	 * Return Connection
	 *
	 * @param null
	 * @return Connection
	 */
	public function getConnection($connection)
	{
		return $this->connection;
	}


	/**
	 * Return Table
	 *
	 * @param null
	 * @return Table
	 */
	public function getTable($table)
	{
		return $this->table;
	}


	/**
	 * Return Hasher
	 *
	 * @param null
	 * @return Hasher
	 */
	public function getHasher($hasher)
	{
		return $this->hasher;
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
	 * Generic User
	 *
	 * @param string
	 * @return
	 */
	public function genericUser($user)
	{

	}

}