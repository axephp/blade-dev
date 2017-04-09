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


if (!function_exists('escape')) {

	function escape($str)
	{

		$str = strip_tags($str);
          $str = htmlentities($str);
          $str = htmlspecialchars($str, ENT_QUOTES);
          return addslashes($str);

	}

}


if (!function_exists('redirect')) {

	function redirect($url, $statusCode = 303)
	{
	   header('Location: ' . $url, true, $statusCode);
	   die();
	}

}


if (!function_exists('time_elapsed_string')) {
	
	function time_elapsed_string($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
}
	
/*

if (!function_exists('axe')) {

	function axe(){
		return \Blade\AxE\AxE::getInstance();
	}

}

*/