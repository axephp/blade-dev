<?php

namespace Blade\AxE\Core;

use Exception;
use Blade\Interfaces\AxE\IAxE as AxE;

use Blade\Config\Config;

class Configurer // implements ICore
{

	protected $confs = [
		'site.conf',
		'database.conf',
		'auth.conf'
	];

	public function run(AxE $axe)
	{
		$axe->resolve(\Blade\Interfaces\Routing\IRouter::class)->setRoutes(new \Blade\Routing\RouteList());
		//$axe->register('config', Config::class, true);

		$config = New Config($axe);

		foreach ($this->confs as $file) {
			$config->loadConf($file);
		}

		$axe->map('config', $config);
		var_dump($axe == $axe->resolve(Axe::class));
	}

}