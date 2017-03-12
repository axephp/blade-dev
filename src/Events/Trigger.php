<?php

namespace Blade\Events;

use Blade\AxE\Manager;
use Blade\Interfaces\AxE\IAxE as AxE;
use Blade\Interfaces\AxE\IManager;
use Blade\Routing\Processor\Path;

class Trigger
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

	protected function log(EventItem $event)
	{
		$data = serialize($event);

		$old = $this->old();

		$new[] = $event;

		if ($old) {
			$all = array_merge($old, $new);
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
        	$item->datetime = date();
        	$item->action = $action;
        	$item->sender = $sender;

        	return $item;
	}
}


class EventLogItem
{
	
	public $datetime;
	public $action;
	public $sender;

}