<?php
/**
* @package Bidi Recycle Program
*/
namespace Includes\Base;
use \Includes\Base\BaseController;

class Shortcode extends BaseController{
	function register() {
		add_shortcode( 'Bidi_Recycle', array( $this , 'template' ) );
	}

	function template(){
		// require admin template
		if ( is_user_logged_in() ) {
		   require_once $this->plugin_path . 'templates/page.template.php';	
		} else {
		   echo "<h3>Thank you for participating in the BIDI&#8482; CARES Movement</h3>";
		  echo "<p>The Bidi Cares program is where you can return your used and empty Bidi Sticks for recycling and get a FREE coupon code for your FREE Bidi Stick on your next purchase. We require you to log-in for us to verify your age.</p></br></br>";
		}		
	}
}