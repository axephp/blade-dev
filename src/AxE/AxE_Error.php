<?php

namespace Blade\AxE;

use Exception;
use Throwable;

class AxE_Error extends Exception implements Throwable
{
	
	function render($request, $ex)
	{


$error_type = $ex->code;
$error_title = $ex->message;
$error_msg  = $ex->file. " - [ line ".$ex->line."]";

$base_url = $request->url();

protected $output = <<<PHP

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <base href="<?=$base_url?>" />
    	<title>Error Occured | <?=SITE_NAME?></title>
    	<link rel="stylesheet" type="text/css" href="css/error.css">
  </head>
  <body>
  		<h1><?=$error_title?></h1>
  		<h3><?=$error_msg?></h3>

  </body>
</html>

PHP
	;
	}
}