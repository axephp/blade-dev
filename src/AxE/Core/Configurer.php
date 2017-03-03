<?php

namespace Blade\AxE\Core;

use Exception;
use Blade\Interfaces\AxE\IAxE as AxE;

class Configurer // implements ICore
{

	public function run(AxE $axe)
	{

		$axe->resolve(\Blade\Interfaces\Routing\IRouter::class)->setRoutes(new \Blade\Routing\RouteList());

		//TODO: Load configs
	}

}