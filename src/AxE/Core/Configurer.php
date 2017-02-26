<?php

namespace Blade\AxE\Core;

use Exception;


class Configurer // implements ICore
{

	public function run(AxE $axe)
	{
		$axe->router->setRoutes(new Blade\Routing\RouteList());
	}

}