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
	protected $logged = false;


	protected $user;

	protected $provider;


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
	public function setFromRemember($fromRemember = true)
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

		dump($this->logged);


     	if (!$this->logged) {
          	return;
     	}


     	dump($this->user);

     	if (!is_null($this->user)) {
     		return $this->user;
     	}

     	$id = $this->session->get($this->getName());
     	$user = null;

     	if (! is_null($id)) {
          	if ($user = $this->provider->retrieveById($id)) {
               	$this->triggerAuthenticated($user);
          	}
     	}


     	// TODO: Cookie remember 

     	return $this->user = $user;

	}


	/**
	 * Get ID of logged user
	 *
	 * @param none
	 * @return string
	 */
	public function id()
	{
		if (!$this->logged) {
          	return;
        	}
        	if ($this->user()) {
          	return $this->user()->getAuthId();
     	}

     	return $this->session->get($this->getName());
	}


	/**
	 * Validate user's credentials
	 *
	 * @param array
	 * @return bool
	 */
	public function validate($credentials = [])
	{
		return $this->authenticate($credentials, false, false);
	}


	/**
	 * Check to see if user credentials are valid
	 *
	 * @param mixed
	 * @param array
	 * @return bool
	 */
	public function isValid($user, $credentials)
	{
 		return ! is_null($user) && $this->provider->validate($user, $credentials);
	}


	/**
	 * Authenticate the user
	 *
	 * @param array
	 * @param bool
	 * @param bool
	 * @return bool
	 */
	public function authenticate($credentials, $remember = false, $login = false)
	{
		//$this->fireAttemptEvent($credentials, $remember, $login);
        	$this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);

        	if ($this->isValid($user, $credentials)) {
            	if ($login) {
                	$this->login($user, $remember);
            	}
            	return true;
        	}

        	if ($login) {
            	//$this->fireFailedEvent($user, $credentials);
        	}
        	return false;
	}


	/**
	 * Log the user in
	 *
	 * @param Authenticatable
	 * @param bool
	 * @return void
	 */
	public function login($user, $remember = false)
	{
		$this->updateSession($user->getId());

        	if ($remember) {
            	//$this->createRememberTokenIfDoesntExist($user);
            	//$this->queueRecallerCookie($user);
        	}

        	//$this->fireLoginEvent($user, $remember);
        	$this->setUser($user);
	}


    	/**
      * Update the session with the given ID.
      *
      * @param  string  $id
      * @return void
      */
    	protected function updateSession($id)
    	{
        	$this->session->set($this->getName(), $id);
        	$this->session->migrate(true);

    	}


	/**
	 * Login using given ID
	 *
	 * @param string
	 * @param bool
	 * @return
	 */
	public function loginWithId($id, $remember = false)
	{
		$user = $this->provider->retrieveById($id);

        	if (! is_null($user)) {
            	$this->login($user, $remember);
            	return $user;
        	}
        	return false;
	}


	/**
	 * Login without storing sessions
	 *
	 * @param string
	 * @return
	 */
	public function loginWithIdOnce($id)
	{
		$user = $this->provider->retrieveById($id);
        	if (! is_null($user)) {
            	$this->setUser($user);

            	return $user;
        	}
        	return false;
	}


	/**
	 * Log the user out
	 *
	 * @param null
	 * @return void
	 */
	public function logout()
	{
		$user = $this->user();
        	$this->clearUser();

        	if (! is_null($this->user)) {
         	   $this->refreshRememberToken($user);
        	}

        	if (isset($this->events)) {
         	   $this->events->fire(new Events\Logout($user));
        	}

       	$this->user = null;
        	$this->logged = false;
	}

	/**
      * Remove the user data from the session and cookies.
      *
      * @return void
      */
    	protected function clearUser()
    	{
     	$this->session->remove($this->getName());
    	}


    /**
     * Refresh the "remember me" token for the user.
     *
     * @param  Authenticatable  $user
     * @return void
     */
    	protected function refreshRememberToken(Authenticatable $user)
    	{
        	$user->setRememberToken($token = Str::random(60));
        	$this->provider->updateRememberToken($user, $token);
    	}
    

    /**
     * Create a new "remember me" token for the user if one doesn't already exist.
     *
     * @param  Authenticatable  $user
     * @return void
     */
    protected function createRememberTokenIfDoesntExist(Authenticatable $user)
    {
        if (empty($user->getRememberToken())) {
            $this->refreshRememberToken($user);
        }
    }


    /**
     * Set the current user.
     *
     * @param  Authenticatable  $user
     * @return $this
     */
    public function setUser($user)
    {

        $this->user = $user;
        $this->logged = true;

        //$this->fireAuthenticatedEvent($user);
        return $this;
    }

}