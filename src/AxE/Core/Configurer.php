<?php

namespace Blade\AxE\Core;

use Exception;
use Blade\Interfaces\AxE\AxE;

use Blade\Config\Config;

class Configurer
{

	protected $confs = [
		'site.conf',
		'database.conf',
		'auth.conf'
	];

	public function run(AxE $axe)
	{
		$config = New Config($axe);
		$axe->map('config', $config);
		
		$axeConfig = require_once($axe->configFile());

		foreach ($axeConfig['aliases'] as $alias => $provider) {
			$axe->alias($alias, $provider);
		}

		foreach ($this->confs as $file) {
			$config->loadConf($file);
		}

		$axe->addManager($axeConfig['managers']);
		
	}

}