<?php

namespace Blade\AxE\Core;

use Exception;
use Blade\Interfaces\AxE\IAxE as AxE;

use Blade\Config\Config;

class Configurer // implements ICore
{

	public function run(AxE $axe) //FileSystem $files)
	{
		$axe->resolve(\Blade\Interfaces\Routing\IRouter::class)->setRoutes(new \Blade\Routing\RouteList());
		

		$data = file_get_contents($axe->configFile());
		$json = (array)json_decode($data);

		$config = New Config($json);

		$config['DATABASE'] = include $axe->configPath().DIRECTORY_SEPARATOR.'database.php';

		var_dump($config);

		$axe->map('config', $config);
		
	}

}