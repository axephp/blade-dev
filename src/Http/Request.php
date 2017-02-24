<?php

namespace Blade\Http;

use Exception;
use Blade\Interfaces\Http\IRequest;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request extends SymfonyRequest implements IRequest
{
	
	public static function request()
	{
		return parent::createFromGlobals();
	}

}