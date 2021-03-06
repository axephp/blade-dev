<?php

namespace Blade\Session;

use Blade\Interfaces\AxE\AxE;

use Symfony\Component\HttpFoundation\Session\Session as SymfonySession;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;

class PhpSessionManager extends SymfonySession
{

	
	protected $axe;

	protected $prefix;

	protected $encrypt;


	function __construct(AxE $axe)
	{
		$storage = new NativeSessionStorage(array(), new NativeFileSessionHandler());
		parent::__construct($storage);

		$this->prefix = $axe->config('site')->site_prefix;

		# set session name
		$sessionName = $this->prefix.'_'.$axe->config('session')->cookie;
		$this->setName($sessionName);
		$this->start();



		$this->axe = $axe;
		$this->request = \Blade\Http\Request::request();
		$this->request->cookies->set($this->getName(), 1); 

		$this->sanitize();

	}


	public function encrypt($value = false)
	{
		$this->encrypt = $value;
	}


	protected function sanitize()
	{

		$request = $this->request;

		// Check to see if the session is new or a hijacking attempt
		if(!$this->preventHijacking())
		{
			// Reset session data and regenerate id
			$this->clear();
			$this->invalidate();
			
			$this->regenerateNewSession();


			parent::set('ipAddress', $request->server->get('REMOTE_ADDR'));
			parent::set('userAgent', $request->server->get('HTTP_USER_AGENT'));	

		}

	}

	protected function preventHijacking()
	{
		if(parent::get('ipAddress') == null || parent::get('userAgent') == null)
			return false;

		$request = $this->request;

		if (parent::get('ipAddress') != $request->server->get('REMOTE_ADDR'))
			return false;

		if (parent::get('userAgent') != $request->server->get('HTTP_USER_AGENT'))
			return false;

		return true;
	}


	protected function regenerateNewSession()
	{


		//Create new session without destroying the old one
		$this->migrate(false);
		
		// Grab current session ID and close both sessions to allow other scripts to use them
		$newSession = $this->getId();

		$this->save();
		session_write_close();

		// Set session ID to the new one, and start it back up again
		$this->setId($newSession);
		$this->start();

	}


	public function checkForExpiry($maxIdleTime)
	{
		if (time() - $this->getMetadataBag()->getLastUsed() > $maxIdleTime) {
		    $this->invalidate();
		    return true;
		}else{
			return false;
		}
	}

	public function get($key, $default = NULL)
	{
		$name = $this->prefix.'_'.$key;
		return parent::get($this->encrypt ? $this->decryptV($name) : $name, $this->encrypt ? $this->decryptV($default) : $default);
	}


	public function set($key, $value)
	{	
		$name = $this->prefix.'_'.$key;
		return parent::set($this->encrypt ? $this->encryptV($name) : $name, $this->encrypt ? $this->encryptV($value) : $value);
	}

	public function remove($key)
	{
		$name = $this->prefix.'_'.$key;
		return parent::remove($this->encrypt ? $this->decryptV($name) : $name);
	}


	protected function encryptV($value='')
	{
		return base64_encode($value);
	}

	protected function decryptV($value='')
	{
		return base64_decode($value);
	}

}