<?php

if (!function_exists('array_flatten')) {

	function array_flatten($array) { 

		if (!is_array($array)) { 
			return false; 
		} 
		$result = []; 
		foreach ($array as $key => $value) { 
			if (is_array($value)) { 
		     	$result = array_merge($result, array_flatten($value)); 
			} 
			else { 
		     	$result[$key] = $value; 
			} 
		} 
		return $result; 

	}

}

if (!function_exists('array_random')) {
	
	function array_random($array, $num = 1)
	{
		return $array[array_rand($array, $num)];
	}

}

if (!function_exists('breakpoint')) {
	
	function breakpoint(...$args)
	{
		die(1);
		var_dump($args);
	}

}


/*

if (!function_exists('axe')) {

	function axe(){
		return \Blade\AxE\AxE::getInstance();
	}

}

*/
