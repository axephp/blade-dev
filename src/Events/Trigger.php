<?php

namespace Blade\Events;

use Blade\AxE\Manager;
use Blade\Interfaces\AxE\AxE;
use Blade\Routing\Processor\Path;
use Blade\Interfaces\Events\Trigger as ITrigger;

class Trigger implements ITrigger
{
	
	protected $axe;

	protected $logFile;

	function __construct(AxE $axe)
	{
		$this->axe = $axe;
		$this->logFile = Path::process($axe->storagePath(), 'logs', 'events.log');
	}


	function fire($event, $args = [])
	{

		$event = $this->make($event, $args);

		if ($this->log($event)){
			return true;
		}else{
			return false;
		}
		
	}

	protected function old()
	{
		if (file_exists($this->logFile)) {
			$old = (array)json_decode(file_get_contents($this->logFile));
			return $old;
		}

		return false;
		
	}

	protected function log(EventLogItem $event)
	{
		$data = serialize($event);

		$old = $this->old();

		$new[] = $event;

		if ($old) {
			$all = array_merge($old, $new);
		}else{
			$all = $new;
		}

		return file_put_contents($this->logFile, json_encode($all));
	}

	protected function make($event, $args = [])
	{
		$action = $event;
        	$sender = "";

        	if (strpos($event, '->') !== false) {
            	$action = explode("->", $event)[0];
          	$sender = explode("->", $event)[1];
        	}

        	$item = new EventLogItem();
        	$item->datetime = date("F j, Y, g:i a");
        	$item->action = $action;
        	$item->sender = $sender;

        	return $item;
	}
}