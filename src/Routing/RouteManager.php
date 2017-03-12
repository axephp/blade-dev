<?php

namespace Blade\Routing;

use Blade\AxE\Manager;
use Blade\Interfaces\AxE\IAxE as AxE;
use Blade\Interfaces\AxE\IManager;

class RouteManager extends Manager implements IManager
{
	
	function run(AxE $axe)
	{
		
		$axe->resolve(\Blade\Interfaces\Routing\IRouter::class)->setRoutes(new \Blade\Routing\RouteList());
		
	}
}
