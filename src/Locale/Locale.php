<?php

namespace Blade\Locale;

use Exception;

use Blade\Interfaces\AxE\AxE;

class Locale
{
	
	protected $axe;

	protected $default;

	protected $locales;

	protected $current = [];


	public function __construct(AxE $axe)
	{
		$this->axe = $axe;

		$this->default = isset($axe->config('site')->default_locale) ? $axe->config('site')->default_locale : null;

		$this->loadLang()
	}


	public function loadLang()
	{
		if ($this->default) {

			$this->locales = $this->loadFromFiles();
			
		}else{
			throw new Exception("Default Locale not available.", 1);
			
		}
	}


	public function loadFromFiles()
	{
		$dir = $this->axe->langPath();

		foreach(glob($dir) as $langs) 
		{
			echo "filename: $file : filetype: " . filetype($file) . "<br />";
		}

	}
}