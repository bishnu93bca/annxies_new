<?php
/*************************************************************************************************
Word Bound Function*************************************************************************************************/
function word_split($str,$words=15) {
	$arr = preg_split("/[\s]+/", $str,$words+1);
	$arr = array_slice($arr,0,$words);
	return join(' ',$arr);
}
/*************************************************************************************************
Word Bound Function End
*************************************************************************************************/
/*************************************************************************************************
In Array with Multidimention Function 
*************************************************************************************************/
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}

function searchForId($sField, $sValue, $array) {
   foreach ($array as $key => $val) {
       if ($val[$sField] === $sValue) {
           return $key;
       }
   }
   return null;
}
/*************************************************************************************************
In Array with Multidimention Function End
*************************************************************************************************/
/*************************************************************************************************
Permalink Function Start
*************************************************************************************************/
function createPermalink($ENTITY, $permalink, $ExtraQryStr)
{
	$permalink = trim(strtolower($permalink));
	$permalink = preg_replace("/[^a-zA-Z0-9\s]/","", $permalink);
	$permalink = explode(" ",$permalink);
	$permalinkArray = array();
	foreach($permalink as $paVal)
	{
		if($paVal!='')
			$permalinkArray[]=$paVal;
	}
	$permalink = implode("-",$permalinkArray);
    
    $siteObj = new Site;
    $CLAUSE = "permalink='".$permalink."' and ".$ExtraQryStr;
    $fetch_permalink = $siteObj->selectSingle($ENTITY, "*", $CLAUSE);
    
    while($fetch_permalink)
    {
        $extArray = explode('-', $permalink);
        $extArray = array_reverse($extArray);
        $ext = $extArray[0];
        if(is_numeric($ext))
        {
            $ext = $ext+1;
            $extArray[0] = $ext;
            $extArray = array_reverse($extArray);
            $permalink = implode('-',$extArray);
        }
        else
        {
            $ext = 1;
            $extArray = array_reverse($extArray);
            $permalink = implode('-',$extArray).'-'.$ext;
        }
        /*$sel_permalink = mysql_query("select * from ".$ENTITY." where permalink='".$permalink."' and ".$ExtraQryStr);
        $fetch_permalink = mysql_fetch_array($sel_permalink);*/
        
        $CLAUSE = "permalink='".$permalink."' and ".$ExtraQryStr;
        $fetch_permalink = $siteObj->selectSingle($ENTITY, "*", $CLAUSE);
    }

	return $permalink;
}
/*************************************************************************************************
Permalink Function End
*************************************************************************************************/
/*** To send a text message.**/
function sendSms($to, $message){
	/*$from = '17865401799';
	$nexmo_sms = new NexmoMessage(NEXMO_KEY, NEXMO_SECRET);
	return $info = $nexmo_sms->sendText( $to, $from, $message );*/
	
	$from = '+16043301256'; 
	$twilio_sms = new TwilioMessage(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);
	$sms = $twilio_sms -> sendText($to, $from, $message);
	return $sms;
}
/*** Functions for Client charge**/


/*************************************************************************************************
SALTING START
*************************************************************************************************/
function saltCrypt($value){
    return base64_encode(str_replace('**', $value, $_SESSION['SALT']));
}
function saltDecrypt($value){
    $decode     = base64_decode($value);
    $saltArray  = explode('|', $decode);
    
    if($saltArray[0]==$_SESSION['PRESALT'] && $saltArray[2]==$_SESSION['POSTSALT'])
        return $saltArray[1];
    else
        return null;
}
/*************************************************************************************************
SALTING End
*************************************************************************************************/
?>