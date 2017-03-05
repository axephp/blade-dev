<?php

namespace Blade\AxE\Core;

use Exception;
use Blade\Interfaces\AxE\IAxE as AxE;

class Shutter // implements ICore
{

	protected $axe;

	public function run(AxE $axe)
	{
		$this->axe = $axe;
		register_shutdown_function(array($this, 'shutTheAxEUp'));
	}

	public function shutTheAxEUp()
	{
		//Things to do when shutting down

		$error = error_get_last();

		$error_file		= str_replace(ABSOLUTE_ROOT_PATH, strtoupper(SITE_NAME)."://", str_replace("\\", "/", $error['file']));
				
		$error_title	= $error['message'];

		if($error['type'] === 1024 || $error['type'] === 256){
			$error_msg 		= "User thrown error.";
		}else{
			$error_msg 		= $error_file. " - [ line ".$error['line']."]";
		}

		$base_url = $this->axe->resolve('route')->uri();


	$output = <<<PHP
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <base href="$base_url" />
    	<title>Error Occured | <?=SITE_NAME?></title>
    	<style type="text/css">
    	*{
		padding: 0px;
		margin: 0px;
		text-align: center;
	}

	body{
		background-color: #ECF0F5;
	}

	h1{
		font-family: Consolas;
		margin-top: 100px;
		margin-bottom: 20px;
		font-size: 52px;
		color: #ff3300;
	}

	h3{
		font-family: Tahoma;
		color: #0099ff;
		margin-bottom: 50px;
	}
    	</style>
  </head>
  <body>
  		<h1>$error_title</h1>
  		<h3>$error_msg</h3>

  </body>
</html>
PHP
	;

		$response = new SymfonyResponse();

		$response->setContent($output);

		$response->headers->set('Content-Type', "text/html");

		$response->send();

	}

}