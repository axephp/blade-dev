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

	

}