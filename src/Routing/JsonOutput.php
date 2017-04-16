<?php

namespace Blade\Routing;

use Exception;

use Blade\Interfaces\Routing\Router as IRouter;
use Blade\Routing\Processor\Path;
use Blade\Interfaces\Routing\CompiledRoute as ICompiledRoute;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class JsonOutput
{

	public function compile($output)
	{	
		$response = new SymfonyResponse();

		$response->setContent($output);
		$response->headers->set('Content-Type', 'application/json');
		$response->send();

	}
}
