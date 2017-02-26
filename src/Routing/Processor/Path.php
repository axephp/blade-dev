<?php

namespace Blade\Routing\Processor;

use Exception;

use Blade\Interfaces\Container\IContainer as Container;
use Blade\Interfaces\Routing\Processor\IProcessor;

class Path
{

	public static function process()
	{
		$output = "";

		foreach (func_get_args() as $value) {
			if (is_array($value)) {
				$output .= DIRECTORY_SEPARATOR.self::process($value);
			}else{
				$output .= $value;
			}
		}

		return trim($output, DIRECTORY_SEPARATOR);
	
	}


	public static function controller($dir)
	{
		return $dir.DIRECTORY_SEPARATOR.'index.php';
	
	}

}