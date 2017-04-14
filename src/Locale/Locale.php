<?php

namespace Blade\Locale;

use Exception;

use Blade\Interfaces\AxE\AxE;

use Blade\Routing\Processor\Path;

class Locale
{
	
	protected $axe;

	protected $default;

	protected $current;

	protected $components = [];


	public function __construct(AxE $axe)
	{
		$this->axe = $axe;

		$this->default = isset($axe->config('site')->default_locale) ? $axe->config('site')->default_locale : null;

		$this->current = $axe->resolve('session')->get('lang', $this->default);

		$this->loadLang();
		
	}


	protected function loadLang()
	{
		if ($this->default) {

			$this->loadFromFiles($this->current);
			
		}else{
			throw new Exception("Default Locale not available.", 1);
			
		}
	}


	protected function loadFromFiles($lang)
	{
		$dir = $this->axe->langPath();

		if ($this->default && !is_null($lang)) {

				$folder = Path::process($dir, $lang);

				if (is_dir($folder)) {

					foreach (glob($folder.'/*.php') as $file) {

						$content = require $file;
						$this->components[basename($file, '.php')] = $content;
					}
					
				}else{
					throw new Exception("Language pack not found.", 1);
					
				}

		}

	}


	public function set($lang)
	{
		$this->current = $lang;
		$this->axe->resolve('session')->set('lang', $lang);
	}

	
	public function current()
	{
		return $this->current;
	}


	public function default()
	{
		return $this->default;
	}


	public function get($pack, $key)
	{
		return isset($this->components[$pack]) ? 
					(isset($this->components[$pack][$key]) ? return $this->components[$pack][$key] : 
						throw new Exception("Language key '$key' not found in pack '$pack'.", 1)) : 
							throw new Exception("Language pack '$pack' not found.", 1);

	}
}