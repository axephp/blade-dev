<?php

namespace Blade\Templating;

use Blade\Interfaces\AxE\AxE;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

use Blade\Routing\Processor\Path;

class Compiler
{

	protected $axe;


	function __construct(AxE $axe)
	{
		$this->axe = $axe;
	}


	public function compile($data)
	{

		# [struct, mime, vars]
		
		$response = new SymfonyResponse();


		// THEMING NEEDS TO BE REDONE
		$tplFile = Path::process($this->axe->appPath(), 'Framework', 
		          isset($data['return']['theme']) && $data['return']['theme'] != 'default' ? $data['return']['theme'] : 'Template.tpl');

		if (!file_exists($tplFile) || $this->axe->isConsole() == true || $this->axe->isUnitTests() == true) {
			$response->setContent(serialize($data));
			return $response;
		}
		// END THEMING

		$code = file_get_contents($tplFile);

		if (strpos($code, '@element') !== false) {

			$head = $this->prepareHead($data['dir'], $data['bag']);
			$body = $this->prepareBody($data['dir'], $data['return']['file']);

			  $vars = ['pageTitle'=>$data['title'], 'pageHead'=>$head, 'pageBody'=> $body];
			  $compiled =  preg_replace_callback(
		            '/\B@(@?\w+(?:::\w+)?)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?;/x', function ($match) use($vars, $tplFile) {

		            	$var = $this->runElement($match);

		            	if (isset($vars[$var])) {
		            		return $vars[$var];
		            	}else{
		            		return "<strong>Theming Error: </strong> Element '$var' not found in <strong>$tplFile</strong>. <br>";
		            	}
		                
		            }, $code
		        );
		}else{
			$compiled = $code;
		}

		
		$response->setContent($compiled);

		$response->headers->set('Content-Type', 'text/html');

		return $response;
		
	}


	protected function runElement($match)
	{
		$var = explode("'", $match[4])[1];
		return $var;
	}

	protected function prepareHead($dir, $data)
	{
		$return = "";

		foreach ($data as $key => $value) {
			echo $key;
		}
		return $return;
	}

	protected function prepareHead($dir, $data)
	{
		$return = "";
		return "Tried loading '$data'";
	}
}