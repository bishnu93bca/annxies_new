<?php
if(!$dtaction)
    $siteObj -> redirectToUrl($SITE_DASHBOARD_PATH.'/social-media/');
else{
    ?>
    <div class="myProfile_section">
        <?php 
        if($_SESSION['FUSERTYPE']=='Student')
            include("navigation.php");
        if($_SESSION['FUSERTYPE']=='Recruiter')
            include("./modules/dashboard/recruiter/navigation.php");
        ?>
        <div class="left_col right_panel profilePage">
            <div class="theiaStickySidebar">
                <div class="scroll_effect" data-effect="fadeInUp">
                    <?php
    
                    if($publicProfile)
                        include("public_profile.php");
                    elseif($dtls=='social-media' || $pageTypeArray[1] == 'social-media'){
                        if($pageTypeArray[1] && ($dtls=='message' || $dtls=='group' || $dtls=='post')){
                            $_SESSION['SOCIAL_TAB'] = $dtls;
                            include("social-media.php");
                        }
                        elseif($dtaction=='my-friends' || $dtaction=='add-friend' || $dtaction=='ask-a-question' || $dtaction=='help-a-friend' || $dtaction=='message' || $dtaction=='group' || $dtaction=='blocked') {
                            $_SESSION['SOCIAL_TAB'] = $dtaction;
                            include("social-media.php");
                        }
                    }
                    elseif($dtls=='study-material') {
                        if($dtaction=='uploaded-documents' || $dtaction=='upload-document'){
                            $_SESSION['STUDY_TAB'] = $dtaction;
                            include("study-material.php");
                        }
                    }
                    elseif($dtls=='my-favourites') {
                        if($dtaction=='professors' || $dtaction=='jobs' || $dtaction=='study-materials'){
                            $_SESSION['FAVOURITE_TAB'] = $dtaction;
                            include("my-favourites.php");
                        }
                    }
                    elseif($dtaction=='social-media'){
                        $_SESSION['SOCIAL_TAB'] = '';
                        include("social-media.php");
                    }
                    elseif($dtaction=='study-material'){
                        $_SESSION['STUDY_TAB'] = '';
                        include("study-material.php");
                    }
                    elseif($dtaction=='my-favourites'){
                        $_SESSION['FAVOURITE_TAB'] = '';
                        include("my-favourites.php");
                    }
                    elseif(file_exists($ROOT_PATH.'/modules/dashboard/student/'.$dtaction.'.php'))
                        include($dtaction.'.php');
                    else
                        $siteObj -> redirectTo404($SITE_LOC_PATH); 
                    ?>
                </div>
            </div>
        </div>
        <div class="spacer"></div>
    </div>
    <?php
}
?>