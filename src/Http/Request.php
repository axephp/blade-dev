<?php

namespace Blade\Http;

use Exception;
use Blade\Interfaces\Http\IRequest;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request extends SymfonyRequest implements IRequest
{
	
	static function request()
	{
		return static::createFromGlobals();
	}

	public function uri($value='')
	{
		return parent::getUri();
	}

	public function requests()
	{
		$patt = explode("?", parent::getRequestUri())[0];

		return explode("/", $patt);
	}

	public function scheme()
	{
		return parent:: getScheme();  //http | https
	}

	public function query()
	{
		parent::getQueryString();  // after ?
	}

}