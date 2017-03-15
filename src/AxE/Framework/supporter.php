<?php

# CSS Functions #
function css(){ func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::res(); }
function cssFromPublic(){ func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::res(); }


# JS Functions #
function js(){ func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::res(); }


# IMG Functions #
function img($file, $attribs = []){ return func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::makeImg($file, $attribs); }

# VIEW Functions #
function view($viewName, $theme = 'default'){ 
  return func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::make($viewName, $theme); }

# TO Function
function to($url){ 
  return func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::redirect($to); }

class func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg{
static function res(){
	$class_name = debug_backtrace()[2]['class'];
	$method_name = debug_backtrace()[1]['function'];
	$args = debug_backtrace()[1]['args'];

	$check = (strpos($class_name, 'User\\Pages') !== false);

	if ($check) {

		$object = debug_backtrace()[2]['object'];
		$loadBag = (new ReflectionObject($object))->getProperty('loadBag');
		$loadBag->setAccessible(true);
		$old = $loadBag->getValue($object);

		$new[$method_name] = $args;
		$final = array_merge_recursive($old, $new);

		$loadBag->setValue($object, $final);
		$loadBag->setAccessible(false);

	}else{
		throw new Exception("Invalid call to function", 1);	
	}
}

static function make($name, $theme)
{
	$class_name = debug_backtrace()[2]['class'];

	$check = (strpos($class_name, 'User\\Pages') !== false);

	if ($check) {
		return ['type'=>'view', 'file'=>$name, 'theme'=>$theme];
	}else{
		throw new Exception("Invalid call to function", 1);	
	}
}

static function redirect($path)
{
	$class_name = debug_backtrace()[2]['class'];

	$check = (strpos($class_name, 'User\\Pages') !== false);

	if ($check) {
		return ['type'=>'route', 'path'=>$path];
	}else{
		throw new Exception("Invalid call to function", 1);	
	}
}

static function makeImg($file, $attribs)
{
	$class_name = debug_backtrace()[2]['class'];
	$method_name = debug_backtrace()[1]['function'];

	$check = (strpos($class_name, 'User\\Pages') !== false);

	if ($check) {

		$path = implode('/', axe()->resolve('route')->getRequest());
		$realFile = "/axeasset/$path/$file";

		$tag = "<img src=\"$realFile\" ";
		foreach ($attribs as $key => $value) {
			$tag .= "$key=\"$class\" ";
		}
		$tag .= "/>";
		return $tag;

	}else{
		throw new Exception("Invalid call to function", 1);	
	}
}

}


function array_flatten($array) { 
	  if (!is_array($array)) { 
	    return FALSE; 
	  } 
	  $result = array(); 
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


function axe(){
	return \Blade\AxE\AxE::getInstance();
}