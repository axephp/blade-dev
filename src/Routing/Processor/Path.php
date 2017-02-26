<?php

namespace Blade\Routing\Processor;

use Exception;

use Blade\Interfaces\Container\IContainer as Container;
use Blade\Interfaces\Routing\Processor\IProcessor;

class Path
{

	public static function process()
	{
		return implode(DIRECTORY_SEPARATOR, array_map(function($data) {
			if (!is_array($data)) {
				return $data;
			}else{
				return implode(DIRECTORY_SEPARATOR, $data);
			}
		}, func_get_args()));	
	}


	public static function controller($dir)
	{
		return $dir.DIRECTORY_SEPARATOR.'index.php';
	
	}

}