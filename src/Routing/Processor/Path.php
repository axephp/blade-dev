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
		$output = "";

		$looper = function($array) use($looper) {
			$a = [];
			foreach ($array as $value) {
				if (is_array($value)) {
					array_merge($a, $looper($value));
				}else{
					$a[] = $value;
				}
			}
			return $a;
		};

		return implode(DIRECTORY_SEPARATOR, $looper(func_get_args()));
	
	}


	public static function controller($dir)
	{
		return $dir.DIRECTORY_SEPARATOR.'index.php';
	
	}

}