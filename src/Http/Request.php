<?php

namespace Blade\Http;

use Exception;
use Blade\Interfaces\Http\Request as IRequest;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request extends SymfonyRequest implements IRequest
{
	
	static function request()
	{
		return static::createFromGlobals();
	}


	/**
	 * URI
	 *
	 * @param string
	 * @return string
	 */
	public function uri($value='')
	{
		return parent::getUri();
	}


	/**
	 * URI breakdown for requests
	 *
	 * @param null
	 * @return array
	 */
	public function requests()
	{
		$patt = trim(explode("?", parent::getRequestUri())[0], '/');

		return explode("/", $patt);
	}


	/**
	 * Identify Scheme : HTTP or HTTPS
	 *
	 * @param null
	 * @return string
	 */
	public function scheme()
	{
		return parent:: getScheme();
	}

	public function query()
	{
		parent::getQueryString();  // after ?
	}

	public function method()
	{
		return parent::getMethod();
	}

	public function ip()
	{
		parent::getClientIP();
	}


	public function posts()
	{
		return ($this->request->all());
	}


	public function queries()
	{
		return ($this->query->all());
	}

		public function cookies()
	{
		return ($this->cookies->all());

	}


	public function files()
	{
		return ($this->files->all());

	}


	public function server()
	{
		return ($this->server->all());

	}


	public function headers()
	{
		return ($this->headers->all());

	}

	/**
     * Determine if AJAX
     *
     * @return bool
     */
    public function isAjax()
    {
        return $this->isXmlHttpRequest();
    }
	
}