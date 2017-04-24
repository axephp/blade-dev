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


if (!function_exists('clean_dump')) {

	function clean_dump()
	{
		foreach (func_get_args() as $value) {
			var_dump($value);
		}
		die(1);
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


if (!function_exists('filter')) {

	function filter() {
		$val = call_user_func_array("filter_var", func_get_args());
	    if($val === false || $val != func_get_args()[0]){
	        return false;
	    }
	    else{
	        return true;
	    }
	}

}

if (!function_exists('match_date')) {

	function match_date($date, $format) {
		preg_match('/^([YMD])\1{0,3}(.?)([YMD])\3{0,3}(.?)([YMD])\5{0,3}$/', $format, $matches, PREG_OFFSET_CAPTURE);
		$sep = ($matches[2][0] == $matches[4][0]) ? $matches[2][0] : false;
		if (!$sep) {
			throw new Exception("Invalid Format specified!", 1);
		}else{
			preg_match('/^([0-9]{1,4})'.$sep.'([0-9]{1,4})'.$sep.'([0-9]{1,4})$/', $date, $catches, PREG_OFFSET_CAPTURE);
			if (empty($catches)) {
				return (false);
			}else{
				$ret = true;
				$checks = [];
				foreach (explode($sep, $format) as $key => $value) {
					//(str_repeat("0", strlen($value) - strlen($catches[$key+1][0])).$catches[$key+1][0]);
					if (strlen($value) == 1) {
						$ret = true;
					}else{
						$ret = (strlen($value) != strlen($catches[$key+1][0])) ? false : true;
					}
					
					$checks[substr($value, 0, 1)] = strlen($catches[$key+1][0]);				
				}
				$greg = checkdate($checks['M'], $checks['D'], $checks['Y']);
				dump($ret, $greg)
				return ($greg);
			}
		}
	}

}


if (!function_exists('redirect')) {

	function redirect($url, $statusCode = 303)
	{
	   header('Location: /' . $url, true, $statusCode);
	   die();
	}

}

if (!function_exists('back')) {

	function back()
	{
	   header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

}


if (!function_exists('string_contains')) {

	function string_contains($container, $data)
	{
	   return strpos($container, $data) !== false;
	}

}


if (!function_exists('error')) {

	function error($msg)
	{
	   return "<h1>$msg</h1>";
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


if (!function_exists('axe')) {

	function &axe(){

		return \Blade\AxE\AxE::getInstance();
	
	}

}