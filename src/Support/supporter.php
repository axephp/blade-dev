<?php

if (!function_exists('array_flatten')) {

	function array_flatten($array, $depth = INF) { 

		$objTmp = (object) array('aFlat' => array());

		array_walk_recursive($array, create_function('&$v, $k, &$t', '$t->aFlat[] = $v;'), $objTmp);

		return ($objTmp->aFlat);


	}

}

if (!function_exists('array_random')) {
	
	function array_random($array, $num = 1)
	{
		return $array[array_rand($array, $num)];
	}

}

if (!function_exists('breakpoint')) {

	function breakpoint()
	{
		dump(func_get_args());
		die(1);
	}

}

if (!function_exists('dump')) {

	function dump()
	{
		echo "<pre style='font-size:16px;'>";
		foreach (func_get_args() as $value) {
			var_dump($value);
		}
		echo "</pre>";

	}

}


/*

if (!function_exists('axe')) {

	function axe(){
		return \Blade\AxE\AxE::getInstance();
	}

}

*/
