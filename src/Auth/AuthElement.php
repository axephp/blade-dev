<?php

namespace Blade\Auth;

use ReflectionClass;
use Exception;

class AuthElement
{

	/**
	 * driver for authentication
	 *
	 * @var DriverProvider
	 */
	protected $driver;


	/**
	 * user for authentication
	 *
	 * @var UserProvider
	 */
	protected $user;


	/**
	 * password for authentication 
	 *
	 * @var PasswordProvider
	 */
	protected $password;

	/**
	 * login page
	 *
	 * @var string
	 */
	protected $loginPage;


	/**
	 * post login page
	 *
	 * @var string
	 */
	protected $postLoginPage;


	/**
	 * user route
	 *
	 * @var string
	 */
	protected $userRoute;


	/**
	 * New AuthElement Instance
	 *
	 * @param DriverProvider
	 * @param UserProvider
	 * @param PasswordProvider
	 * @param string
	 * @param string
	 * @param string
	 */
	public function __construct($driver, $loginPage, $postLoginPage, $userRoute)
	{
		$this->driver 			= $driver;
		$this->loginPage 		= $loginPage;
		$this->postLoginPage 	= $postLoginPage;
		$this->userRoute 		= $userRoute;
	}


	/**
	 * Return driver of Authentication Element
	 *
	 * @param null
	 * @return DriverProvider
	 */
	public function getDriver()
	{
		return $this->driver;
	}


	/**
	 * Return user of Authentication Element
	 *
	 * @param null
	 * @return UserProvider
	 */
	public function getUser()
	{
		return $this->user;
	}


	/**
	 * Return login page of Authentication Element
	 *
	 * @param null
	 * @return string
	 */
	public function getLoginPage()
	{
		return $this->loginPage;
	}


	/**
	 * Return post login page of Authentication Element
	 *
	 * @param null
	 * @return string
	 */
	public function getPostLoginPage()
	{
		return $this->postLoginPage;
	}


	/**
	 * Return user route of Authentication Element
	 *
	 * @param null
	 * @return string
	 */
	public function getuserRote()
	{
		return $this->userRoute;
	}


	/**
	 * prepare()
	 *
	 * @param 
	 * @return
	 */
	public function prepare()
	{

		//

	}

}