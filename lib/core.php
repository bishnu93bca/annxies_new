<?php
/*------------------------------------------------------------------
Including necessary library files----------------------------------*/
include("includes/session.php");
include("class/site.class.php");
include("class/file.class.php");
include("class/nocsrf.php");
include("includes/system.php");
include("includes/email_template.php");
include("includes/functions.php");
include("class/module.class.php");
include("class/genl.class.php");
//include ("includes/twilio/TwilioMessage.php" );
//include($ROOT_PATH."/lib/class/geoplugin.class.php");
/*------------------------------------------------------------------
GeoLocation API Start----------------------------------------------*/
/*$geoplugin = new geoPlugin();
$geoplugin->locate($_SERVER['REMOTE_ADDR']);
$visitedFrom_Ip = $geoplugin->ip;
$visitedFrom_City = $geoplugin->city;
$visitedFrom_Place = $geoplugin->place;
$visitedFrom_Region = $geoplugin->region;
$visitedFrom_Country = $geoplugin->countryName;
$visitedFrom_Longitude = $geoplugin->longitude;
$visitedFrom_Latitude = $geoplugin->latitude;
/*echo "Geolocation results for {$geoplugin->ip}: <br />\n".
"City: {$geoplugin->city} <br />\n".
"Region: {$geoplugin->region} <br />\n".
"Area Code: {$geoplugin->areaCode} <br />\n".
"DMA Code: {$geoplugin->dmaCode} <br />\n".
"Country Name: {$geoplugin->countryName} <br />\n".
"Country Code: {$geoplugin->countryCode} <br />\n".
"Longitude: {$geoplugin->longitude} <br />\n".
"Latitude: {$geoplugin->latitude} <br />\n";
/*"Currency Code: {$geoplugin->currencyCode} <br />\n".
"Currency Symbol: {$geoplugin->currencySymbol} <br />\n".
"Exchange Rate: {$geoplugin->currencyConverter} <br />\n";*/
/*$places = $geoplugin->nearby(20,10);
echo '<pre>';
print_r($places);
echo '</pre>';*/
//$query = array();
//parse_str($parts["query"], $query);
/*------------------------------------------------------------------
GeoLocation API End------------------------------------------------*/
?>