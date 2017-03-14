<?php

namespace Blade\Routing\Processor;

use Exception;

use Blade\Interfaces\Routing\Processor\Processor as IProcessor;

class Path
{
	/**
	 * Process request path
	 *
	 * @param null
	 * @return string
	 */
	public static function process()
	{
		return implode(DIRECTORY_SEPARATOR, static::array_flatten(func_get_args()));
	}


	public static function controller($dir)
	{
		return $dir.DIRECTORY_SEPARATOR.'index.php';
	
	}


	private static function array_flatten($array) { 
		  if (!is_array($array)) { 
		    return FALSE; 
		  } 
		  $result = array(); 
		  foreach ($array as $key => $value) { 
		    if (is_array($value)) { 
		      $result = array_merge($result, self::array_flatten($value)); 
		    } 
		    else { 
		      $result[$key] = $value; 
		    } 
		  } 
		  return $result; 
	} 

}