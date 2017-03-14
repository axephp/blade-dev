<?php

namespace Blade\Routing;

use Exception;

use Blade\Interfaces\Routing\Router as IRouter;
use Blade\Routing\Processor\Path;
use Blade\Interfaces\Routing\CompiledRoute as ICompiledRoute;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class AssetRoute extends Route
{
	function __construct($request)
	{
		parent::__construct(['GET'], $request);
	}


	public function compile($file)
	{	
		$response = new SymfonyResponse();

		$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
    		$mime = finfo_file($finfo, $file);
		finfo_close($finfo);

		if (strpos($mime, 'php')) {
			throw new Exception("File not found", 165);
		}

		$vmime = mime_content_type($file);

		ob_start();
			include $file;
		$data = ob_get_contents();
		ob_end_clean();

		$response->setContent($vmime.$data);
		$response->headers->set('Content-Type', $vmime);
		return $response;

	}
}
