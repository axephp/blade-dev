<?php

namespace Blade\Config;

use Exception;
use Blade\Interfaces\AxE\IAxE as AxE;

class Config implements ArrayAccess// implements ICore
{

	protected $container;

	function __construct($data)
	{
		$this->container = $data;
	}

	public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[strtoupper($offset)] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->container[strtoupper($offset)]);
    }

    public function offsetUnset($offset) {
        unset($this->container[strtoupper($offset)]);
    }

    public function offsetGet($offset) {
        return isset($this->container[strtoupper($offset)]) ? $this->container[strtoupper($offset)] : null;
    }

    public function get($offset)
    {
    		return $this[$offset];
    }



}