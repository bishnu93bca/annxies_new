<?php
include("../../include.php");
// JQuery File Upload Start--------------------------------------------------------------	
if (!empty($_FILES)) {	
	$fileName          = substr(time(),-4).'-'.rand();
	$extension_array   = pathinfo($_FILES['Filedata']['name']);
    $ext               = strtolower($extension_array['extension']);
	$targetfilepath    = $MEDIA_FILES_ROOT."/photo/gallery/normal/".$fileName.'.'.$ext;
    
    $fObj           = new FileUpload;
    $siteObj        = new Site;
	if($fObj->moveUploadedFile($_FILES['Filedata'], $targetfilepath)){ 
        $params = array();
        $params['sessionId'] = $_SESSION['sesId'];
        $params['imageName'] = $fileName.'.'.$ext;
        $siteObj->insertQuery('tbl_temp_gallery', $params);
    }
}
echo '1';	
// JQuery File Upload End--------------------------------------------------------------
?>