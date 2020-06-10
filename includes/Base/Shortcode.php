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
		   echo "<h3>Thank you for joining BIDI&#8482; CARES Movement - Please Log In</h3>";
		   echo "<p>The page requested requires an account login to continue.</p>";
		   echo "<ul>
		   	<li><p>If you are new to the Bidi Vapor website,  please register for a <a href='/my-account/'>full access</a> account.</p></li>
		   	<li><p>If you are an existing <b>full access</b> user, please <a href='/my-account/'>login</a> to gain access to this page.</p></li>
		   </ul>";
		  echo "<p>If you are logged in, have a full access account and still cannot access this page, please <a href='/contact-us/'>contact us</a> for assistance.</p></br></br>";
		}		
	}
}