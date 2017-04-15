<?php

# CSS Functions #
function css(){ func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::res(); }
function cssFromPublic(){ func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::res(); }


# JS Functions #
function js(){ func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::res(); }
function jsFromPublic(){ func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::res(); }


# IMG Functions #
function img($file, $attribs = []){ return func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::makeImg($file, $attribs); }

# VIEW Functions #
function view($viewName, $theme = 'default'){ 
  return func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::make($viewName, $theme); }

# TO Function
function to($url){ 
  return func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::redirect($url); }


# TO Function
function model($class, $args = []){ 
  return func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::model($class, $args); }


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

		$path = implode('/', \Blade\AxE\AxE::getInstance()->resolve('route')->getRequest());
		$realFile = "/axeasset/$path/$file";

		$tag = "<img src=\"$realFile\" ";
		foreach ($attribs as $key => $value) {
			$tag .= "$key=\"$value\" ";
		}
		$tag .= "/>";
		return $tag;

	}else{
		throw new Exception("Invalid call to function", 1);	
	}
}

static function model($class, $args)
{
	$class_name = debug_backtrace()[2]['class'];

	$check = (strpos($class_name, 'User\\Pages') !== false);

	if ($check) {
		
		if (class_exists($class)) {

			$axe = \Blade\AxE\AxE::getInstance();
			$libs = (array)$axe->resolve('libs');

			$reflection = new ReflectionClass($class);
			$modo = is_array($args) ? $reflection->newInstanceArgs($args) : $reflection->newInstanceArgs(...$args);

			foreach ($libs as $key => $value) {

				if ($axe->isBound($key) || $axe->isMapped($key) || $axe->isAlias($value) || $axe->isMapped($value)) {

					$lib = is_numeric($key) ? $value : $key;
					$obj = $axe->resolve($lib);
								
					$modo->$lib = $obj;

				}
			}

			return $modo;
		}else{
			trigger_error("Model not found");
		}

	}else{
		throw new Exception("Invalid call to function", 1);	
	}
}

}



if (!function_exists('axe')) {

	function axe(){
		$class_name = debug_backtrace()[2]['class'];

		$check = (strpos($class_name, 'User\\') !== false);

		if ($check) {

			return \Blade\AxE\AxE::getInstance();

		}else{

			throw new Exception("Invalid call to function $class_name", 1);	
		}
		
	}

}