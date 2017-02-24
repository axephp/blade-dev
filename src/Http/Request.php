<?php

namespace Blade\Http;

use Exception;
use Blade\Interfaces\Http\IRequest;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request implements IRequest
{
	
	public static function request()
	{
		return SymfonyRequest::createFromGlobals();
	}

}