<?php

namespace Blade\Config;

use Exception;
use ArrayAccess;

use Blade\Interfaces\AxE\IAxE as AxE;
use Blade\Routing\Processor\Path;

class Config implements ArrayAccess // implements ICore
{

	protected $container = [];

	protected $axe;

	function __construct(AxE $axe)
	{
		$this->axe = $axe;
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

    public function __get($offset)
    {
    		return $this->get($offset);
    }


    public function loadConf($file)
    {
    		$fullFile = Path::process($this->axe->configPath(), $file);
    		if (file_exists($fullFile)) {
    			$data = file_get_contents($fullFile);

    			try {
    				$array = json_decode($data);
    				$this->container[strtoupper(pathinfo($file)['filename'])] = $array;
    			} catch (Exception $e) {
    				throw new Exception("Invalid config file detected.", 1);
    			}
    		}else{
    			throw new Exception("Config file '$file' not found.", 1);
    			
    		}
    }


    public function __debugInfo() {
        return $this->container;
    }


}