<?php

namespace Blade\Routing\Processor;

use Exception;

use Blade\Interfaces\Container\IContainer as Container;
use Blade\Interfaces\Routing\Processor\IProcessor;

class Path
{

	public static function process()
	{
		$array = [];
		foreach (func_get_args() as $value) {
			if (is_array($value)) {
				static::process($value);
			}else{
				$array[] = $value;
			}
		}
		return implode(DIRECTORY_SEPARATOR, $array);
	
	}


	public static function controller($dir)
	{
		return $dir.DIRECTORY_SEPARATOR.'index.php';
	
	}

}