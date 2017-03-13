<?php

namespace Blade\AxE;

use Exception;
use Throwable;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class AxE_Error extends Exception implements Throwable
{
	
	static function render($axe, $request, $ex)
	{

		// Collecting Information
		$error_type = $ex->getCode();
		$error_file =  str_replace($axe->basePath(), strtoupper("AXE").":/", str_replace("\\", "/", $ex->getFile()));
		$error_line  = $ex->getLine();
		$error_title = $ex->getMessage()." on line - $error_line";
		$error_trace = $ex->getTrace();


		// Rendered
		$error_backtrace = static::prepareBacktrace($error_trace);
		$errored_code = static::extractCode($ex->getFile(), $error_line);
		$request_stats = static::prepareStats($request);

		// Loading Views
		$html = static::makeView($error_backtrace, $errored_code, $request_stats);

		// Response of error
		return static::toResponse($html);
		
	}


    private static function prepareBacktrace($error_trace)
    {
    		$backtrace = '';
		foreach ($error_trace as $key=>$item) {
			$backtrace .= '<a href="#">
							<div class="backtrace-item">
								<h3><span class="backtrace-count">'.(count($array) - $key).'</span> '. ($item['class'] ?? "Class Unavailable") .'</h3>
								<p>'.str_replace($axe->basePath(), strtoupper("AXE").":/", str_replace("\\", "/", ($item['file'] ?? "File Unavailable"))).' <span class="backtrace-line"><strong> - Line '. ($item['line'] ?? "Unavailable") .'</strong></span></p>
							</div>
						</a>';
		}

		return $backtrace;
    }


    private static function extractCode($file, $errorLine)
    {
    		ob_start();
		static::highlight_file_with_line_numbers($ex->getFile(), $error_line - 8, $error_line + 8, $error_line);
		$coded = ob_get_contents();
		ob_end_clean();

		return $coded;
    }


    private static function prepareStats($request)
    {
    		var_dump($request);
    		$stat = '<div class="stats-item">
				<div class="title">Request Type &nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;</div>
				<div class="value">HTTP Request</div>
			</div>';
		return $stat;
    }


    private static function makeView($error_backtrace, $errored_code, $request_stats)
    {	
    		$view = __DIR__.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'error.tpl';
    		ob_start();
		include $view;
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
    }


    private static function toResponse($output)
    {
    		$response = new SymfonyResponse();

		$response->setContent($output);

		$response->headers->set('Content-Type', "text/html");

		return $response;
    }


     private static function highlight_file_with_line_numbers($file, $from, $to, $error_line) {

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
	        for ($i=$from; $i <= $to ; $i++) { 
	        	 //Create line number
	        	$line = $lines[$i];
	            $lineNumber = str_pad($i + 1,  $padLength, '0', STR_PAD_LEFT);
	            //Print line
	            if ($lineNumber == $error_line ) {
	            	echo sprintf('<br><div style="background-color: #ECEC4C;"><span style="color: #999999">%s | </span>%s</div>', $lineNumber, $line);
	            }else{
	            	echo sprintf('%s<span style="color: #999999">%s | </span>%s', ($lineNumber == $error_line + 1) ? '' : '<br>', $lineNumber, $line);
	            }
	        }
	       
	        //Close span
	        echo "</span></code>";
    }

}