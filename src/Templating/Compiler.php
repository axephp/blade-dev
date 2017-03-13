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
			$body = $this->prepareBody($data['dir'], $data['return']['file'], $data['vars']);

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
			$info = $this->getHead($key);
			$files = $this->array_flatten($value);

			foreach ($files as $rawFile) {

				if ($info['inside']) {

					$file = "/axeasset/kaambaaki.file";
					//TODO : WORK LEFT

				}else{
					$file = $rawFile;
				}

				if ($info['type'] == "css") {
					$return .= "<link rel=\"stylesheet\" href=\"$file\" type=\"text/css\" />";
				}else{
					$return .= "<script type=\"text/javascript\" src=\"$file\"></script>";
				}
			}
		}
		return $return;
	}

	protected function getHead($key)
	{
		$type = [];
		switch ($key) {
			case 'css':
			case 'js':
				$type['inside'] = true;
				$type['type'] = $key;
				break;

			case 'jsFromPublic':
			case 'cssFromPublic':
				$type['inside'] = false;
				$type['type'] = str_replace("FromPublic", "", $key);
				break;
			default:
				$type['inside'] = true;
				break;
		}

		return $type;
	}

	protected function prepareBody($dir, $data, $vars)
	{
		$return = "";

		$viewFile = Path::process($dir, $data.'.tpl');

		$code = file_get_contents($viewFile);

		//$this->compile COMPILING TEMPLATE SCRIPT LEFT

		return $code;
	}



	function array_flatten($array) { 
  if (!is_array($array)) { 
    return FALSE; 
  } 
  $result = array(); 
  foreach ($array as $key => $value) { 
    if (is_array($value)) { 
      $result = array_merge($result, array_flatten($value)); 
    } 
    else { 
      $result[$key] = $value; 
    } 
  } 
  return $result; 
} 

}