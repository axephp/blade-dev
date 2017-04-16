<?php

namespace User\Pages{

# CSS Functions #
function css(){ func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::res(func_get_args()); }
function cssFromPublic(){ func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::res(func_get_args()); }


# JS Functions #
function js(){ func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::res(func_get_args()); }
function jsFromPublic(){ func80ef1db23134260821dc4893bf3b28c2ZnVuY3Rpb25lcg::res(func_get_args()); }


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

	$arr = explode('\\', debug_backtrace()[1]['function']);
	$method_name = array_pop($arr);
	$args = func_get_args();

	$object = debug_backtrace()[2]['object'];

	$loadBag = (new \ReflectionObject($object))->getProperty('loadBag');
	$loadBag->setAccessible(true);
	$old = $loadBag->getValue($object);

	$new[$method_name] = $args;
	$final = array_merge_recursive($old, $new);

	$loadBag->setValue($object, $final);
	$loadBag->setAccessible(false);

}

static function make($name, $theme)
{

	return ['type'=>'view', 'file'=>$name, 'theme'=>$theme];

}

static function redirect($path)
{

	return ['type'=>'route', 'path'=>$path];

}

static function makeImg($file, $attribs)
{

		$path = implode('/', \Blade\AxE\AxE::getInstance()->resolve('route')->getRequest());
		$realFile = "/axeasset/$path/$file";

		$tag = "<img src=\"$realFile\" ";
		foreach ($attribs as $key => $value) {
			$tag .= "$key=\"$value\" ";
		}
		$tag .= "/>";
		return $tag;

}

static function model($class, $args)
{

		if (class_exists($class)) {

			$axe = \Blade\AxE\AxE::getInstance();
			$libs = (array)$axe->resolve('libs');

			$reflection = new \ReflectionClass($class);
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
}

}


if (!function_exists('error')) {

	function error($msg)
	{
	   return ['type'=>'data', 'data'=>$msg];
	}

}


if (!function_exists('json')) {

	function json($data)
	{
		if (!is_array($data)) {
			return error('Invalid Array sent or JSON output.');
		}
	   return ['type'=>'json', 'data'=>json_encode($data)];
	}

}


}

namespace Blade\AxE\Framework{

	if (!function_exists('axe')) {

		function axe(){

			return \Blade\AxE\AxE::getInstance();
		
		}

	}

}
