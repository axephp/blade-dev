<?php

namespace Blade\Auth;

use ReflectionClass;
use Exception;

class SessionDriver
{

	/**
	 * Name of session driver.
	 *
	 * @var string
	 */
	protected $name;


	/**
	 * last attempt of the Authenticating
	 *
	 * @var Authenticatable
	 */
	protected $lastAttempted;


	/**
	 * from Remember
	 *
	 * @var bool
	 */
	protected $fromRemember = false;


	/**
	 * Sesssion Information
	 *
	 * @var Session
	 */
	protected $session;


	/**
	 * Request of current route
	 *
	 * @var Request
	 */
	protected $request;


	/**
	 * User logged or not
	 *
	 * @var bool
	 */
	protected $logged;


	/**
	 * New SessionDriver Instance
	 *
	 * @param string
	 * @param Authenticatable
	 * @param Session
	 * @param Request
	 * @return void
	 */
	public function __construct($name, $provider, $session, $request)
	{
		$this->name = $name;
		$this->provider = $provider;
		$this->session = $session;
		$this->request = $request;
	}


	/**
	 * Set name for the Session Driver
	 *
	 * @param string
	 * @return void
	 */
	public function setName($name)
	{
		$this->name = $name;
	}


	/**
	 * Set Authenticatable
	 *
	 * @param Authenticatable
	 * @return void
	 */
	public function setLastAttempted($lastAttempted)
	{
		$this->lastAttempted = $lastAttempted;
	}


	/**
	 * Set from remember
	 *
	 * @param bool
	 * @return void
	 */
	public function setFromRemember($fromRemember = true);
	{
		$this->fromRemember = $fromRemember;
	}


	/**
	 * Set Session Driver
	 *
	 * @param Session
	 * @return void
	 */
	public function setSession($session)
	{
		$this->session = $session;
	}


	/**
	 * Set Request
	 *
	 * @param Request
	 * @return void
	 */
	public function setRequest($request)
	{
		$this->request = $request;
	}

	/**
	 * logged or not
	 *
	 * @param bool
	 * @return void
	 */
	public function setLogged($logged)
	{
		$this->logged = $logged;
	}


	/**
	 * Return name for the Session Driver
	 *
	 * @param null
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * Return last attempted Authenticatable
	 *
	 * @param null
	 * @return Authenticable
	 */
	public function getLastAttempted()
	{
		return $this->lastAttempted;
	}


	/**
	 * Return form remember or not
	 *
	 * @param null
	 * @return bool
	 */
	public function getFromRemember()
	{
		return $this->fromRemember;
	}


	/**
	 * Return Session
	 *
	 * @param null
	 * @return Session
	 */
	public function getSession()
	{
		return $this->session;
	}


	/**
	 * Return Request
	 *
	 * @param null
	 * @return Request
	 */
	public function getRequest()
	{
		return $this->request;
	}


	/**
	 * Return if is logged
	 *
	 * @param null
	 * @return bool
	 */
	public function getLogged()
	{
		return $this->logged;
	}


	/**
	 * user()
	 *
	 * @param
	 * @return
	 */
	public function user()
	{

	}


	/**
	 * id()
	 *
	 * @param
	 * @return
	 */
	public function id()
	{

	}


	/**
	 * validate()
	 *
	 * @param array
	 * @return
	 */
	public function validate($credentials = [])
	{

	}


	/**
	 * user()
	 *
	 * @param mixed
	 * @param array
	 * @return
	 */
	public function isValid($user, $credentials)
	{

	}


	/**
	 * authenticate()
	 *
	 * @param array
	 * @param bool
	 * @param bool
	 * @return
	 */
	public function authenticate($credentials, $remember = false, login = false)
	{

	}


	/**
	 * login()
	 *
	 * @param Authenticatable
	 * @param bool
	 * @return
	 */
	public function login($user, $remember = false)
	{

	}


	/**
	 * loginWithId()
	 *
	 * @param string
	 * @param bool
	 * @return
	 */
	public function loginWithId($id, $remember = false)
	{

	}


	/**
	 * loginWithIdOnce()
	 *
	 * @param string
	 * @return
	 */
	public function loginWithIdOnce($id)
	{

	}


	/**
	 * logout()
	 *
	 * @param null
	 * @return void
	 */
	public function logout()
	{

	}

}