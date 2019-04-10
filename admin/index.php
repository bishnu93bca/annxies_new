<?php
while(list($key,$val)=each($_REQUEST))
	$$key = trim(stripslashes($val)); 
include("../include.php");
include("includes/action.php");
if($_SESSION['LOGIN']=='YES')
{
	include("includes/header.php");
	include("home.php");
	include("includes/footer.php");
}
else{
    $token = NoCSRF::generate('csrf_token');
    include("login.php");
}
?>