<?php
//date_default_timezone_set('America/Los_Angeles');
substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')? ob_start("ob_gzhandler"): ob_start(); 
//error_reporting(0); 
//ini_set('display_errors',1); error_reporting(E_ALL);
//------------------------------------------------------------------
$BASE           = "http://";      // For Local Server  |  // For Live Server $BASE = "http://www."
$DOMAIN         = "local.bishnu.com/annxies/";             // For Local Server |  // For Live Server $DOMAIN = "domainname.com"
$SITE_LOC_PATH  = $BASE.$DOMAIN;                        // For Local Server  |  // For Live Server $SITE_LOC_PATH = 'http://www.domainname.com';
$ROOT_PATH      = '/Users/bishnuray/workspace/project_1/annxies';    // For Local server  |  // For Live server $ROOT_PATH =$_SERVER['DOCUMENT_ROOT'];    
//------------------------------------------------------------------      
//Base Path For Media Files-----------------------------------------
$MEDIA_FILES_SRC    = $SITE_LOC_PATH.'/uploadedfiles';
$MEDIA_FILES_ROOT   = $ROOT_PATH.'/uploadedfiles';
$STYLE_FILES_SRC    = $SITE_LOC_PATH.'/templates';

$SITE_DASHBOARD_PATH = $SITE_LOC_PATH.'/dashboard';

//$annexisDirDomain     = '/home/users/web/b1080/ipg.after5callcentercom/annexisdirectory';
$annexisDirDomain ='/Users/bishnuray/workspace/project_1/annxies';
$annexisDirUpld       = 'http://local.bishnu.com//annxies';
$MEDIA_FILES_SRC_AD   = $annexisDirUpld.'/uploadedfiles';
$MEDIA_FILES_ROOT_AD  = $annexisDirDomain.'/uploadedfiles';
/*------------------------------------------------------------------
db connecting variables--------------------------------------------*/
define("DB_HOST", "localhost");
//define("DB_USER", "annexis_user");
//define("DB_PASS", "Anne1234@");
//define("DB_NAME", "annexis_db");
define("DB_USER", "root");
define("DB_PASS", "B9shnu!@#");
define("DB_NAME", "sidi");
/*------------------------------------------------------------------
-------------------------------------------------------------------*/
include($ROOT_PATH."/lib/core.php");
include($ROOT_PATH."/ckeditor/ckeditor.php");
include($ROOT_PATH."/ckfinder/ckfinder.php");
?>