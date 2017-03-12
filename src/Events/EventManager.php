<?php

namespace Blade\Events;

use Blade\AxE\Manager;
use Blade\Interfaces\AxE\IAxE as AxE;
use Blade\Interfaces\AxE\IManager;

class EventManager extends Manager implements IManager
{
	
	function run(AxE $axe)
	{
		
		$events = $axe->resolve('eventManager')->events;
		
		var_dump($events);
		
	}
}
