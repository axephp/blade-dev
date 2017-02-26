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
		$request = parent::getRequestUri();

		var_dump($request);
		
		if (strpos($request, '?') !== false) {
			$request = substr($request, 0, strrpos($request, '?'));
		}

		return explode("/", $request);
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