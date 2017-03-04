<?php

namespace Blade\AxE\Core;

use Exception;
use Blade\Interfaces\AxE\IAxE as AxE;

use Blade\Config\Config;

class Configurer // implements ICore
{

	public function run(AxE $axe, FileSystem $files)
	{

		$data = file_get_contents($axe->configFile());
		$json = (array)json_decode($data);

		$config = New Config($json);
		$axe->map('config', $config);
		
	}

}