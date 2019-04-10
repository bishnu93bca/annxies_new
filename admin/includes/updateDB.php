<?php
include('../../ext_include.php');
$action = htmlspecialchars($_POST['action']); 
$updateRecordsArray= $_POST['recordsArray'];
$siteObj = new Site;
//...............................................................
if ($action == "proSwap"){	
	$listingCounter = 1;
    $obj = new adminProductClass;
	foreach ($updateRecordsArray as $recordIDValue) {
        $params = array();
        $params['swapNo'] = $listingCounter;
        $obj->productUpdateByproductId($params, $recordIDValue);
		$listingCounter = $listingCounter + 1;	
	}
    $siteObj->redirectToURL($SITE_LOC_PATH.'/admin/index.php?pageType=productmanagement&dtls=product&type=Product&moduleId=192');
}
//...............................................................
if ($action == "siteswap"){ 
	$listingCounter = 1;
    $obj = new MenuCategory;
	foreach ($updateRecordsArray as $recordIDValue) {
        $params = array();
        $params['swapNo'] = $listingCounter;
        $obj->categoryUpdateBycategoryId($params, $recordIDValue);
		$listingCounter = $listingCounter + 1;	
	}
    ?>
    <script type="text/javascript">
		window.location='<?php echo $SITE_LOC_PATH;?>/admin/index.php?pageType=sitepage&dtls=&moduleId=101';
	</script>
    <?php
}
//...............................................................
if ($action == "contentswap"){
	$listingCounter = 1;
    $obj = new GalleryClass;
	foreach ($updateRecordsArray as $recordIDValue) {
        $params = array();
        $params['swapno'] = $listingCounter;
        $obj->galleryUpdateByid($params, $recordIDValue);
		$listingCounter = $listingCounter + 1;	
	}
    $siteObj->redirectToURL($SITE_LOC_PATH.'/admin/index.php?pageType=content&editid='.$editid);
}
//...............................................................
if ($action == "sitesubswap"){
	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {
		mysql_query("update tbl_menu_category set swapNo='".$listingCounter."' where categoryId = $recordIDValue")or die(mysql_error());
		$listingCounter = $listingCounter + 1;	
	}
    $siteObj->redirectToURL($SITE_LOC_PATH.'/admin/index.php?pageType=sitepage&dtls=&parentId=4&moduleId=101');
}
//...............................................................
if ($action == "photogallery"){
	$listingCounter = 1;
    $cObj = new PhotogalleryClass;
	foreach ($updateRecordsArray as $recordIDValue) {
        $params = array();
        $params['swapNo'] = $listingCounter;
        $cObj->photogalleryUpdateByphotogalleryId($params, $recordIDValue);
		$listingCounter = $listingCounter + 1;
	}
	?>
    <script type="text/javascript">
		window.location='<?php echo $SITE_LOC_PATH;?>/admin/index.php?pageType=photogallery&dtls=photogallerylist&type=gallery-list&moduleId=244';
	</script>
    <?php
    //$siteObj->redirectToURL($SITE_LOC_PATH.'/admin/index.php?pageType=service&dtls=servicelist&type=service-list&moduleId=192');
}
//...............................................................
if ($action == "service"){
	$listingCounter = 1;
    $obj = new ServiceClass;
	foreach ($updateRecordsArray as $recordIDValue) {
        $params = array();
        $params['swapNo'] = $listingCounter;
        $obj->serviceUpdateByserviceId($params, $recordIDValue);
		$listingCounter = $listingCounter + 1;	
	}
	?>
    <script type="text/javascript">
		window.location='<?php echo $SITE_LOC_PATH;?>/admin/index.php?pageType=service&dtls=servicelist&type=service-list&moduleId=252';
	</script>
    <?php
}
//...............................................................
if ($action == "testimonial"){
	$listingCounter = 1;
    $obj = new AdminTestimonial;
	foreach ($updateRecordsArray as $recordIDValue) {
        $params = array();
        $params['swapNo'] = $listingCounter;
        $obj->testimonialUpdateBytestimonialId($params, $recordIDValue);
		$listingCounter = $listingCounter + 1;	
	}
	?>
    <script type="text/javascript">
		window.location='<?php echo $SITE_LOC_PATH;?>/admin/index.php?pageType=testimonial&dtls=testimonials&type=testimonials&moduleId=254';
	</script>
    <?php
}
//...............................................................
if ($action == "project"){
	$listingCounter = 1;
	$obj = new ProjectClass;
	foreach ($updateRecordsArray as $recordIDValue) {
		$params = array();
		$params['swapNo'] = $listingCounter;
		$obj->projectUpdateByprojectId($params, $recordIDValue);
		$listingCounter = $listingCounter + 1;
	}
	?>
    <script type="text/javascript">
		window.location='<?php echo $SITE_LOC_PATH;?>/admin/index.php?pageType=project&dtls=projectlist&type=project-list&moduleId=256';
	</script>
    <?php
   //$siteObj->redirectToURL($SITE_LOC_PATH.'/admin/index.php?pageType=flag&dtls=flaglist&type=flag-list&moduleId=231');
}
//...............................................................
if ($action == "photo"){
	$listingCounter = 1;
    $obj = new GalleryClass;
	foreach ($updateRecordsArray as $recordIDValue) {
        $params = array();
        $params['swapno'] = $listingCounter;
        $obj->galleryUpdateByid($params, $recordIDValue);
		$listingCounter = $listingCounter + 1;	
	}
    $siteObj->redirectToURL($SITE_LOC_PATH.'/admin/index.php?pageType=photomanagement&dtls=homeheader&type=home-header&moduleId=118');
}
//...............................................................
?>