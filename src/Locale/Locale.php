<?php

namespace Blade\Locale;

use Exception;

use Blade\Interfaces\AxE\AxE;

use Blade\Routing\Processor\Path;

class Locale
{
	
	protected $axe;

	protected $default;

	protected $locales;

	protected $current;


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

			$this->locales = $this->loadFromFiles($this->current);
			
		}else{
			throw new Exception("Default Locale not available.", 1);
			
		}
	}


	public function loadFromFiles($lang)
	{
		$dir = $this->axe->langPath();

		if ($this->default) {

			if ($this->current) {
				
				$folder = Path::process($dir, $lang);

				if (is_dir($folder)) {

					foreach (glob($folder.'/*') as $files) {
						echo $file;
					}
					
					
				}else{
					throw new Exception("Language pack not found.", 1);
					
				}
			}

		}

	}
}