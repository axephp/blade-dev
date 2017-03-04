<?php

namespace Blade\AxE\Core;

use Exception;
use Blade\Interfaces\AxE\IAxE as AxE;

class Configurer // implements ICore
{

	public function run(AxE $axe)
	{

		$data = file_get_contents($axe->configFile());
		var_dump($data);
		//$axe->map('config',);
		//TODO: Load configs
	}

}