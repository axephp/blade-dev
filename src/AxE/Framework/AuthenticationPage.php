<?php

namespace Blade\AxE\Framework;


trait AuthenticationPage{

	// Peaceful in here

	/**
	 *  Gets called on POST request to auth page
	 */
	public function index_post($post_username, $post_password)
	{

		$credentials = ['username' => $post_username, 'password' => $post_password ];

		$login = ($this->auth->using($this->authentication)->authenticate($credentials, false, true));

		if ($login) {
			
			redirect($this->auth->getAuth($this->authenticaion)->post_login_page);

		}else{
			$this->message =  "Incorrect login entered!";
		}

		css('login.css');

		return view('login', 'login');

	}

}