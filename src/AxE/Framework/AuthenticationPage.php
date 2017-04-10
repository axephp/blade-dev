<?php

namespace Blade\AxE\Framework;


trait AuthenticationPage{

	// Peaceful in here

	/**
	 *  Gets called on POST request to auth page
	 */
	public function index_post($post_username, $query_code, $arg, $args)
	{

		dump($post_args);

	}

}