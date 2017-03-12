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
		$axeConfig = require_once($axe->configFile());

		foreach ($axeConfig['providers'] as $provider => $content) {
			$axe->register($provider, $content);
		}

		foreach ($axeConfig['aliases'] as $alias => $provider) {
			$axe->alias($alias, $provider);
		}

		foreach ($this->confs as $file) {
			$config->loadConf($file);
		}

		$axe->map('config', $config);

		$axe->addManager($axeConfig['managers']);
		
	}

}