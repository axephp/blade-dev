<?php

namespace Blade\Templating;

use Blade\Interfaces\AxE\AxE;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

use Blade\Routing\Processor\Path;

class Templater
{

	protected $axe;


	function __construct(AxE $axe)
	{
		$this->axe = $axe;
	}


	public function template($data)
	{

		$response = new SymfonyResponse();

		$struct = $this->theme($data['action']['theme']);
		$html = $this->struct($struct, $data);

		$response->setContent($html);
		$response->headers->set('Content-Type', 'text/html');
		return $response;
		
	}


	protected function theme($theme = 'default')
	{
		$file = Path::process($this->axe->themesPath(), $theme, 'theme.php');
		$struct = Path::process($this->axe->appPath(), 'Framework', 'Template.tpl');

		if (file_exists($file)) {
			
			$tmp = require $file;
			if (!array_key_exists('template', $tmp)) {
				throw new Exception("Invalid theme file.", 902);
			}

			$struct = (isset($tmp['structure']) && !empty($tmp['structure'])) ?
			 Path::process($this->axe->themesPath(), $theme, $tmp['structure']) : $struct;

			if (!file_exists($struct) || $this->axe->isConsole() == true || $this->axe->isUnitTests() == true) {
				return false;
			}

			$tpl = Path::process($this->axe->themesPath(), $theme, $tmp['template']);

			//file_put_contents(Path::process($this->axe->storagePath(), "cache/theme-$theme.php"), $tplCompiled);

			$tplContent = $this->buffered($tpl, $tmp['elements']);
			
			// First, we need to templify(:P) the tpl first.
			$tplCompiled = $this->varer($tplContent, $tmp['elements']);


			$structContent = file_get_contents($struct);
			$structCompiled = $this->varer($structContent, ['pageBody'=>$tplCompiled]);
			
		}else{
			
			if (!file_exists($struct) || $this->axe->isConsole() == true || $this->axe->isUnitTests() == true) {
				return false;
			}

			$structCompiled = file_get_contents($struct);

		}
		return $structCompiled;
		
	}


	protected function struct($struct, $data)
	{
		$head = $this->prepareHead($data['dir'], $data['bag']);
		$body = $this->prepareBody($data['dir'], $data['action']['file'], $data['vars']);

		$dump = (!empty($data['content'])) ? '<pre>'.$data['content'].'</pre>' : '';
		$vars = ['pageTitle'=>$data['title'], 'pageHead'=>$head, 'pageBody'=> $dump.$body];
		$structCompiled = $this->varer($struct, $vars);

		return $structCompiled;
	}


	protected function runElement($match)
	{
		$var = explode("'", $match[4])[1];
		return $var;
	}


	protected function buffered($file, $vars = [])
	{
		ob_start();
		extract($vars);
		include $file;
		$code = ob_get_contents();
		ob_end_clean();
		
		return $code;
	}


	protected function varer($code, $vars)
	{
		if (strpos($code, '@element') !== false) {
			  $compiled =  preg_replace_callback(
		            '/\B@(@?\w+(?:::\w+)?)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?;/x', function ($match) use($vars) {
		            	$var = $this->runElement($match);

		            	if (isset($vars[$var])) {
		            		return $vars[$var];
		            	}else{
		            		return $match[0];
		            	}
		                
		            }, $code
		        );
		}else{
			$compiled = $code;
		}

		return $compiled;
	}


	protected function prepareHead($dir, $data)
	{
		$return = "";

		foreach ($data as $key => $value) {
			$info = $this->getHead($key);
			$files = array_flatten($value);

			foreach ($files as $rawFile) {

				if ($info['inside']) {

					$page = Path::process($this->axe->resolve('route')->getRequest(), $rawFile);
					$file = "axeasset/".$page;
					//TODO : WORK LEFT

				}else{
					$file = $rawFile;
				}

				if ($info['type'] == "css") {
					$return .= "<link rel=\"stylesheet\" href=\"/$file\" type=\"text/css\" />";
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
		$viewFile = Path::process($dir, $data.'.tpl');

		if (file_exists($viewFile)) {

			//$code = file_get_contents($viewFile);
			//COMPILING TEMPLATE SCRIPT LEFT


			#TEMPORARY SOLUTION
			ob_start();
			extract($vars);
			include $viewFile;
			$code = ob_get_contents();
			ob_end_clean();
			
			return $code;
		}
		
		if(!empty($data) && !is_null($data)) {
			return "<strong>View</strong> not found.";
		}
		
		//throw new Exception("View '$data' not found.", 129);
		
	}


}