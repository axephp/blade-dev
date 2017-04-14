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


	public function loadLang()
	{
		if ($this->default) {

			$this->loadFromFiles($this->current);
			
		}else{
			throw new Exception("Default Locale not available.", 1);
			
		}
	}


	public function loadFromFiles($lang)
	{
		$dir = $this->axe->langPath();

		if ($this->default && !is_null($lang)) {

				$folder = Path::process($dir, $lang);

				if (is_dir($folder)) {

					foreach (glob($folder.'/*') as $file) {

						$content = require $file;
						$this->components[$lang] = $content;
					}
					
				}else{
					throw new Exception("Language pack not found.", 1);
					
				}

		}

	}

	
	public function current()
	{
		return $this->current;
	}


	public function default()
	{
		return $this->default;
	}


	public function get($key, $default = "", $lang = null)
	{
		$lang = !is_null($lang) ? $lang : $this->current;
		return $this->components[$lang][$key];
	}
}