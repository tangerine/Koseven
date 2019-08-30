<?php defined('SYSPATH') OR die('No direct script access.');

/** 
 * Defined in Kohana_Core:
 * Common environment type constants for consistency and convenience.
 * const PRODUCTION  = 10;
 * const STAGING     = 20;
 * const TESTING     = 30;
 * const DEVELOPMENT = 40;
**/	

class HTTP_Exception extends Kohana_HTTP_Exception {
	
	/**
	 * Generate a Response for all Exceptions without a more specific override
	 * 
	 * The user should see a nice error page, however, if we are in development
	 * mode we should show the normal Kohana error page.
	 * 
	 * @return Response
	 */
	public function get_response()
	{
		// Lets log the Exception, Just in case it's important!
		Kohana_Exception::log($this);

		if (Kohana::$environment >= Kohana::DEVELOPMENT)
		{
			// Show the normal Kohana error page.
			return parent::get_response();
		}
		else
		{
			// Generate a nicer looking "Oops" page.
			$view = View::factory('errors/default');

			$response = Response::factory()
				->status($this->getCode())
				->body($view->render());

			return $response;
		}
	}
}