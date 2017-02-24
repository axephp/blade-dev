<?php

namespace Blade\Interfaces\Routing\Processor;


interface IProcessor
{
	

	public function compile($route);

	public function inside($namespace, $request);

}