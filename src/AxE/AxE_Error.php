<?php

namespace Blade\AxE;

use Exception;
use Throwable;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class AxE_Error extends Exception implements Throwable
{
	
	function render($request, $ex)
	{


		$error_type = $ex->code;
		$error_title = $ex->message;
		$error_msg  = $ex->file. " - [ line ".$ex->line."]";

		$base_url = $request->uri();

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

		return $response;
	}
}