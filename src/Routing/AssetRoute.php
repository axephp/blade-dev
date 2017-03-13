<?php

namespace Blade\Routing;

use Exception;

use Blade\Interfaces\Routing\Router as IRouter;
use Blade\Routing\Processor\Path;
use Blade\Interfaces\Routing\CompiledRoute as ICompiledRoute;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class AssetRoute extends Route
{
	function __construct($request)
	{
		parent::__construct(['GET'], $request);
	}


	public function compile()
	{	
		$response = new SymfonyResponse();

		var_dump($this->requests());

		$response->setContent($html);
		$response->headers->set('Content-Type', 'text/html');
		return $response;

	}
}
