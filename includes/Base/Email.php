<?php
/**
* @package Bidi Recycle Program
*/
namespace Includes\Base;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email{
	function register() {
			
	}

	function senderEmailSetting(){
		$mail = new PHPMailer(true);	
		var_dump(PHPMailer::ENCRYPTION_SMTPS);
		/**
		*	VPS Server settings
		**/
			$senderEmail 		= 'support@bidicares.com';
			$senderPassword 	= '#BidiC123';
			$receiverEmail 		= 'support@bidicares.com';

			$SMTPDebug 		= SMTP::DEBUG_SERVER;
			$Host       		= 'mail.vps49089.mylogin.co';
			$SMTPAuth   		= true;
			$SMTPSecure 		= false;
			$Port       		= 25;

		/**
		*	GMAIL Testing Account Server settings
		**/
		   // $senderEmail 	 	 = 'quickfillKim@gmail.com';
		   // $senderPassword	 = 'kim123!@#';
		   // $receiverEmail	 = 'murdoc21daddie@gmail.com';
		   // $SMTPDebug  		 = SMTP::DEBUG_SERVER;
		   // $Host        		 = 'smtp.gmail.com';
		   // $SMTPAuth   		 = true;
		   // $SMTPSecure 		 = PHPMailer::ENCRYPTION_SMTPS;
		   // $Port       		 = 465;

		/**
		*	QUICKFILL RX SERVER TESTING EMAIL SERVER
		**/
// 			$senderEmail 	 = 'kim@quikfillrx.org';
// 			$senderPassword 	 = 'kim123!@#';			
// 			$receiverEmail 	 = 'support@bidicares.com';

// 			$SMTPDebug 		 = SMTP::DEBUG_SERVER;
// 			$Host       		 = 'mail.quikfillrx.org';
// 			$SMTPAuth   		 = true;
// 			$SMTPSecure 		 = 'tls';
// 			$Port       		 = 587;

	    $result = array(
	    	'senderEmail' => $senderEmail,
	    	'senderPassword' => $senderPassword,
	    	'receiverEmail' => $receiverEmail,
	    	'SMTPDebug' => $SMTPDebug,
	    	'Host' => $Host,
	    	'SMTPAuth' => $SMTPAuth,
	    	'SMTPSecure' => $SMTPSecure,
	    	'Port' => $Port
	    );

	    return $result;
	}	
}