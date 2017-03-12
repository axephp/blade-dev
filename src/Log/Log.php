<?php

namespace Blade\Log;

use Exception;
use Throwable;

use Blade\Interfaces\AxE\AxE;
use Blade\AxE\AxE_Error;

use Blade\AxE\Core\Shutter;
use Blade\AxE\Core\Logger;

use Blade\Interfaces\Log\Log as ILog;

class Log implements ILog
{
	
	protected $axe;

	protected $logFile;

	protected $data = [];

	function __construct(AxE $axe)
	{
		$this->axe = $axe;
		$this->logFile = Path::process($axe->storagePath(), 'logs', 'logs.log');

	}


	protected function old()
	{
		if (file_exists($this->logFile)) {
			$old = (array)json_decode(file_get_contents($this->logFile));
			return $old;
		}

		return [];
	}

	protected function log(LogItem $log)
	{
		$data = serialize($log);

		$this->data[] = $data;
	}

	public function save($request)
	{
		$logItem = new LogItem();
		$logItem->datetime = date("F j, Y, g:i a");
		$logItem->uri = $request->uri();
		$logItem->method = $request->method();
		$logItem->content = $request->query();
		$logItem->ip = $request->ip();
		$logItem->browser = "";
		$logItem->os = "";

		return file_put_contents($this->logFile, json_encode($this->data));
	}

	protected function make($log, $args = [])
	{


	}

}


class LogItem
{
	
	public $datetime;
	public $uri;
	public $method;
	public $content;
	public $ip;
	public $browser;
	public $os;

}