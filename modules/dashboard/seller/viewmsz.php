<?php
if($page =='viewmsz')
{
 echo $eObj->showmessage($contactID);
}
elseif($page == 'replymsz'){
	
	$msz=  $eObj->replymsz($contactID,$userid,$username,$subject,$seller,$comment);
	echo $msz;
}
elseif($page == 'mszDelete')
{

	$mszId = $eObj->mszDelete($mszId);
	echo $mszId;
}


?>