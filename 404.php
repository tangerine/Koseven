<?php defined('SYSPATH') OR die('No direct script access.');

class HTTP_Exception_404 extends Kohana_HTTP_Exception_404 {
 
	/**
	 * Generate a Response for the 404 Exception.
	 *
	 * The user of the Production site should be shown a nice 404 page.
	 * 
	 * @return Response
	 */
	public function get_response()
	{
		// Log the Exception.
		Kohana_Exception::log($this);
    		
        if (Kohana :: $environment >= Kohana :: DEVELOPMENT) {
            // We're in development mode - show the normal Kohana error page.
            return parent::get_response() ;             
		} else {
 		    $logo = View::factory( 'logo' ) ;
 		    $view = View::factory('errors/404')->bind( 'logo', $logo ) ;
            
		    // Remembering that `$this` is an instance of HTTP_Exception_404
		    $view->message = $this->getMessage();
            
		    $response = Response::factory()
		    	->status(404)
		    	->body($view->render());
            
		    return $response;
    	}
	}
} // class HTTP_Exception_404 extends Kohana_HTTP_Exception_404
 