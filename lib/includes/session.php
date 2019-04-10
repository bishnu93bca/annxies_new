<?php
session_start();
$currentCookieParams = session_get_cookie_params();  
$_SESSION['sesId']=session_id(); 
if(!isset($_SESSION['SALT'])){
    $_SESSION['PRESALT']    = $_SESSION['sesId'];
    $_SESSION['POSTSALT']   = time();
    
    $_SESSION['SALT']       = $_SESSION['PRESALT'].'|**|'.$_SESSION['POSTSALT'];
}
/*setcookie(  
    'PHPSESSID',//name  
    $_SESSION['sesId'],//value  
    0,//expires at end of session  
    $currentCookieParams['path'],//path  
    $currentCookieParams['domain'],//domain  
    true, //httpOnly
    true //secure  
);  */
?>