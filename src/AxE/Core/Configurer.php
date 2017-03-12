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

		$axeConfig = require_once($axe->configFile());

		var_dump($axeConfig);
		
		$config = New Config($axe);

		foreach ($this->confs as $file) {
			$config->loadConf($file);
		}

		$axe->map('config', $config);
	}

}