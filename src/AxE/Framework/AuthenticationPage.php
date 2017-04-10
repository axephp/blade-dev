<?php

namespace Blade\AxE\Framework;


trait AuthenticationPage{

	// Peaceful in here

	/**
	 *  Gets called on POST request to auth page
	 */
	public function index_post($post_args, $query_code, $arg, $file_file1, $args)
	{

		dump(func_get_args());

	}

}