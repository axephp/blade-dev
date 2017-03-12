<?php

namespace Blade\Routing;

use Blade\AxE\Manager;
use Blade\Interfaces\AxE\AxE;
use Blade\Interfaces\AxE\Manager as IManager;

class RouteManager extends Manager implements IManager
{
	
	function run(AxE $axe)
	{
		
		$axe->resolve(\Blade\Interfaces\Routing\Router::class)->setRoutes(new \Blade\Routing\RouteList());
		
	}
}
