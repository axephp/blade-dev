<?php

namespace Blade\Templating;

class Compiler
{

	public function compile($output)
	{
		
		$response = new SymfonyResponse();

		$response->setContent($output);

		$response->headers->set('Content-Type', "text/html");

		return $response;
	}
}