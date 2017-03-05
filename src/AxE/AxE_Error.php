<?php

namespace Blade\AxE;

use Exception;
use Throwable;

class AxE_Error extends Exception implements Throwable
{
	
	function render($request, $ex)
	{
		var_dump($ex);
	}

/*
$error_type = (!isset($error_type) or empty($error_type)) ? "404" : $error_type ;
$error_title = (!isset($error_title) or empty($error_title)) ? "404 : Page not found!" : $error_title ;
$error_msg = (!isset($error_msg) or empty($error_msg)) ? "Sorry, but the page was not found. You can try going back or keep staring at this page." : $error_msg ;

$error_extra = (!isset($error_extra) or empty($error_extra)) ? "" : $error_extra ;

$base_url = getenv('REQUEST_SCHEME')."://".getenv('HTTP_HOST');

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

      <?=$error_extra?>
  </body>
</html>

PHP
	;
	*/
}