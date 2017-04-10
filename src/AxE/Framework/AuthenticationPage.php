<?php

namespace Blade\AxE\Framework;


trait AuthenticationPage{

	// Peaceful in here

	/**
	 *  Gets called on POST request to auth page
	 */
	public function index_post($post_username, $post_password)
	{

		$credentials = ['username' => $post_password, 'password' => $post_password ];

		$login = ($this->auth->using()->authenticate($credentials));

		if ($login) {
			echo "Success";
		}else{
			$this->message =  "Incorrect login entered!";
		}

		css('login.css');
		
		return view('login', 'login');

	}

}