<?php

namespace Blade\AxE;

use Exception;
use Throwable;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class AxE_Error extends Exception implements Throwable
{
	
	static function render($axe, $request, $ex)
	{

		$error_type = $ex->getCode();
		$error_title = $ex->getMessage();
		$error_file =  str_replace($axe->basePath(), strtoupper("AXE").":/", str_replace("\\", "/", $ex->getFile()));
		$error_line  = $ex->getLine();

		$backtrace = '';
		$array = $ex->getTrace();

		foreach ($array as $key=>$item) {
			$backtrace .= '<a href="#">
							<div class="backtrace-item">
								<h3><span class="backtrace-count">'.(count($array) - $key).'</span> '.$item['class'].'</h3>
								<p>'.str_replace($axe->basePath(), strtoupper("AXE").":/", str_replace("\\", "/", ($item['file'] ?? $error_file))).' <span class="backtrace-line"><strong> - Line '. ($item['line'] ?? error_line) .'</strong></span></p>
							</div>
						</a>';
		}

		$base_url = $request->uri();
		/*$lines = file($ex->getFile());
		$errored_code = '';
		for ($i=$error_line - 5; $i <= $error_line + 3; $i++) { 
			$errored_code .= $lines[$i];
		}*/
		
		ob_start();
		static::highlight_file_with_line_numbers($ex->getFile(), $error_line - 5, $error_line + 4);
		$coded = ob_get_contents();
		ob_end_clean();

		$errored_code = $coded;

$output = 
<<<EOT
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Error : $error_type</title>
		<link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
		<style>
			body{
				margin: 0px;
				min-width: 880px;
			}

			.container{
				font-family: 'Titillium Web', sans-serif;
			}

			.header{
				background: #558B2F;
				border-top: 5px solid #FF3333;
				height: 120px;
				color: #FFFFFF;
				font-family: 'Poiret One', cursive;
				font-weight: normal;
			}

			.header h4, .header p{
				text-align: center;
			}

			.header p{
				margin-top: 0px;
				font-size: 250%;
				line-height: 0.5em;
				color: #FFFF33;
			}

			.primary{
				height: 380px;
				background: #eeeeee;
				overflow-y: scroll;				
				font-family: 'Titillium Web', sans-serif;				
				font-size: 12px;
				line-height: 30px;
			}

			.code{
				width: 55%;
				margin: auto;
				margin-top: -30px;
				margin-bottom: -30px;
				color: #FFFFFF;
			}

			.line{
				background: #555555;
				border-right: 7px solid #222222;
				float: left;
				text-align: right;
				color: #222222;
				margin-top: 9px; /* use to adjust sync of line and code */
			}

			.content{
				margin-left: 80px;
				color: #CCCCCC;
			}

			.highlight, .highlight-line{
				background: #FF3333;
				color: #FFFF33;
			}

			.highlight{
				margin-left: -70px;
				padding-left: 170px; /* use to sync highlighted code with other code indentation */ 
			}

			.secondary{
				height: 402px;
			}

			.secondary ul{
				padding: none;
				margin: none;
			}

			.secondary li{
				list-style: none;
				text-align: left;
				padding: none;
			}

			.secondary p, h3, h4{
				text-align: left;
			}

			.stats{
				width: 40%;
				height: 100%;
				border-top: 5px solid #558B2F;
				float: left;
				overflow-y: scroll;
				font-size: 18px;
			}

			.stats h3{
				width: 100%;
				padding-bottom: 15px;
				border-bottom: 1px solid #DDDDDD;
				text-align: center;
				color: #558B2F;
			}

			.stats-item{
				width: 90%;
				margin: auto;
				text-align: right
			}

			.title{
				width: 50%;
				float: left;
				font-weight: bold;
			}

			.value{
				width: 50%;
				float: right;
				text-align: left;
				color: #FF3333;
			}

			.backtrace{
				width: 60%;
				height: 100%;
				background: #EEEEEE;
				border-top: 5px solid #FF3333;
				float: right;
				overflow-y: scroll;
			}

			.backtrace-list a{
				text-decoration: none;
				color: #000000;
			}

			.backtrace-item{				
				padding: 5px;
				border-bottom: 1px solid #DDDDDD;
			}

			.backtrace-item:hover{
				text-decoration: none;
				background: #CCCCCC;
				color: #000000;
			}

			.backtrace-item h3, .backtrace-item p{
				padding: 5px 10px 5px 10px;
			}

			.backtrace-count{
				background: #FFFFFF;
				border: 2px solid #FF3333;
				border-radius: 15px;
				padding: 0px 8px;
				width: 10px;
				color: #777777;
			}

			.backtrace-line{
				color: #AAAAAA;
			}

			.current{
				background: #558B2F;
				color: #FFF;
				padding: 5px;
			}

			.current:hover{
				background: #558B2F;
				color: #FFF;
				padding: 5px;
			}

			.footer{
				width: 100%;
				background: #558B2F;
				margin: 5px 0px;
				padding: 1px 10px;
				color: #EEEEEE;
				bottom: 0;
				position: fixed;
			}
		</style>
	</head>

	<body>
		<div class="container">
			<div class="header">
				<h4>$error_file</h4>
				<p>$error_title</p>
			</div>

			<div class="primary">
				<div class="code">
					<div class="content">
						<pre>
						$errored_code
						</pre>
					</div>

				</div>
			</div>

			<div class="secondary">

				<div class="stats">

					<h3>Request Statistics</h3>
					<div class="stats-item">
						<div class="title">Request Type &nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;</div>
						<div class="value">HTTP Request</div>
					</div>
				</div>
				<div class="backtrace">
					<div class="backtrace-list">
						$backtrace
					</div>
				</div>

			</div>

			<div class="footer">
			<p>&copy; Copyright 2017 AxE PHP</p>
			</div>
			
		</div>
	</body>
</html>
EOT;

		$response = new SymfonyResponse();

		$response->setContent($output);

		$response->headers->set('Content-Type', "text/html");

		return $response;
	}

	 public static function highlight_file_with_line_numbers($file, $from, $to) {
          //Strip code and first span
        $code = substr(highlight_file($file, true), 36, -15);
        //Split lines
        $lines = explode('<br />', $code);
        //Count
        $lineCount = count($lines);
        //Calc pad length
        $padLength = strlen($lineCount);
       
        //Re-Print the code and span again
        echo "<code><span style=\"color: #000000\">";
       
        $from = ($from  < 0) ? 0 : $from ;
        $to = ($to >= $lineCount) ? $lineCount - 1 : $to ;

        $colors = ['#AAA', '#DDD'];

        //Loop lines
        for ($i=$from; $i < $to ; $i++) { 
        	 //Create line number
        	$line = $lines[$i];
            $lineNumber = str_pad($i + 1,  $padLength, '0', STR_PAD_LEFT);
            //Print line
            echo sprintf('<br><span style="color: #999999">%s | </span>%s', $lineNumber, $line);

        }
       
        //Close span
        echo "</span></code>";
    }

}