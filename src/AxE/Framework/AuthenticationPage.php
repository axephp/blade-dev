<?php

namespace Blade\AxE\Framework;


trait AuthenticationPage{

	// Peaceful in here

	/**
	 *  Gets called on POST request to auth page
	 */
	public function index_post($args)
	{

		dump($_POST);

	}

}