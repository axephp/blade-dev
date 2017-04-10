<?php

namespace Blade\Auth;

use ReflectionClass;
use Exception;

class DatabaseProvider
{

	/**
	 * Database Connection
	 *
	 * @var ConnectionInterface
	 */
	protected $connection;


	/**
	 * Table Requested
	 *
	 * @var string
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
		$this->hasher 		= $hasher;
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
	 * @param string
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
	 * @return ConnectionInterface
	 */
	public function getConnection()
	{
		return $this->connection;
	}


	/**
	 * Return Table
	 *
	 * @param null
	 * @return Table
	 */
	public function getTable()
	{
		return $this->table;
	}


	/**
	 * Return Hasher
	 *
	 * @param null
	 * @return Hasher
	 */
	public function getHasher()
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
		$user = $this->connection->table($this->table)->find($identifier);
        	return $this->getGenericUser($user);
	}


	/**
	 * Retrieve by token
	 *
	 * @param string
	 * @return
	 */
	public function retrieveByToken($id, $token)
	{
        	$user = $this->connection->table($this->table)
            	->where('id', $identifier)
            	->where('remember_token', $token)
            	->first();
        	return $this->getGenericUser($user);
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
        $this->connection->table($this->table)
                ->where('id', $user->getAuthIdentifier())
                ->update(['remember_token' => $token]);
	}


	/**
	 * Retrieve by Credentials
	 *
	 * @param array
	 * @return
	 */
	public function retrieveByCredentials($credentials)
	{

        	$query = $this->connection->table($this->table);
        	foreach ($credentials as $key => $value) {
            	if (! string_contains($key, 'password')) {
                	$query->where($key, $value);
            	}
        	}

        $user = $query->first();

        dump($user);
        
        return $this->genericUser($user);
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
	 * Generic User
	 *
	 * @param string
	 * @return
	 */
	public function genericUser($user)
	{
 		if (! is_null($user)) {
            	return new GenericUser((array) $user);
        	}
	}

}