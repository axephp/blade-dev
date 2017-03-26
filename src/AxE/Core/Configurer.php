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
		'auth.conf',
		'session.conf'
	];

	public function run(AxE $axe)
	{
		$config = New Config($axe);
		$axe->map('config', $config);
		
		$axeConfig = require_once($axe->configFile());

		foreach ($axeConfig['aliases'] as $alias => $provider) {
			if (!$axe->isAlias($alias)) {
				$axe->alias($alias, $provider);
			}
		}

		foreach ($axeConfig['libs'] as $key => $value) {
			if (!$axe->isBound($value) && !$axe->isMapped($value)) {
				if (!is_numeric($key)) {
					if (!$axe->isAlias($key)) {
						$axe->alias($key, $value);
					}
					if (!$axe->isAlias($value)) {
						$axe->bind($key, $value);
					}	
				}

				if (!$axe->isAlias($value)) {
					$axe->bind($value);
				}
				
			}
		}

		$axe->map('libs', (object) $axeConfig['libs']);

		foreach ($this->confs as $file) {
			$config->loadConf($file);
		}


		$axe->addManager($axeConfig['managers']);
		
	}

}