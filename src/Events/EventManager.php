<?php

namespace Blade\Events;

use Blade\AxE\Manager;
use Blade\Interfaces\AxE\IAxE as AxE;
use Blade\Interfaces\AxE\IManager;

class EventManager extends Manager implements IManager
{
	
	function run(AxE $axe)
	{
		
		$axe->register(\Blade\Events\Trigger::class);
		$axe->alias('event', \Blade\Events\Trigger::class);
		
	}
}
