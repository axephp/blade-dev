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
		$config = New Config($axe);
		$axe->map('config', $config);
		
		$axeConfig = require_once($axe->configFile());
		$axe->addManager($axeConfig['managers']);

		var_dump($axeConfig);

		

		foreach ($this->confs as $file) {
			$config->loadConf($file);
		}

		
	}

}