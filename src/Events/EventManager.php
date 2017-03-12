<?php

namespace Blade\Events;

use Blade\AxE\Manager;
use Blade\Interfaces\AxE\AxE;
use Blade\Interfaces\AxE\Manager as IManager;

class EventManager extends Manager implements IManager
{

	public $events = [];
	
	function run(AxE $axe)
	{
		
		$events = $axe->resolve('eventManager')->events;

	}
}
