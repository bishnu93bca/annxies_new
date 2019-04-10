<?php
if($pageType=='office-locations')
    include('office-locations.php');
elseif($pageType=='membership-packages')
    include('membership-packages.php');
elseif($dtls=='signpdf'){
    include('contractsign_pdf.php');
}
elseif($dtls=='signsamplepdf'){
    include('contractsign_pdf.php');
}
elseif($_SESSION['FUSERLOGIN']!='ok' && ($pageType=='login' || $pageType=='register' || $pageType=='forgot-password')){ 
   include($pageType.".php");
}
elseif($_SESSION['FUSERLOGIN']=='ok'){
    $eObj = new MemberView();	
    include("router.php");
}
elseif($pageType=='request' && $ajx==1)
    echo 'error>Please login.';    
else
     include("login.php");
?>
