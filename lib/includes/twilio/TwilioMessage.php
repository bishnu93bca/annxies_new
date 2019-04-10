<?php require "Services/Twilio.php";
class TwilioMessage {
	
	private $accountSid = '';
	private $authToken = '';

	function TwilioMessage ($accountSid, $authToken) {
		$this->accountSid 	= $accountSid;
		$this->authToken 	= $authToken;
	}
	
	function sendText ( $to, $from, $message ) {
	
		$client = new Services_Twilio($this->accountSid, $this->authToken);
		
		try {
			$smsInfo = $client->account->messages->sendMessage( $from, $to, $message );
		    /*$smsInfo = $client->account->messages->create(array(
		        "From" 	=> $from, // From a valid Twilio number
		        "To" 	=> $to, // Text this number
		        "Body" 	=> $message,
		    ));*/
		} catch (Services_Twilio_RestException $e) {
		    $smsInfo = $e->getMessage();
		}
		
		return $smsInfo;
	
	}

}
