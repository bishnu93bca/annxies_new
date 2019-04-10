<?php 
$planData = $eObj->get_general_info($_SESSION['FUSERID']); 
$data = $eObj->get_company_info($_SESSION['FUSERID']);

?>
<div class="container">
    <div class="row">
        <?php 
        if($_SESSION['FUSERTYPE']=='Seller')
            include("navigation.php");
        ?>
        <div class="col-md-9 col-sm-8 bkngrt">
            <div class="content_right home-page">
                <?php    
                if($publicProfile)
                    include("public_profile.php");
                if($dtaction){
                    if(file_exists($ROOT_PATH.'/modules/dashboard/seller/'.$dtaction.'.php'))
                        include($dtaction.'.php');
                    else
                        $siteObj -> redirectTo404($SITE_LOC_PATH); 
                }
                else
                    include("dashboard.php");
                ?>
            </div>
        </div>
        <div class="spacer"></div>
    </div>
</div>