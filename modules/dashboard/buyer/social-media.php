<div class="fav_details myProfile">

    <?php 
    if($dtls == 'post'){
        ?>
        <div class="social_media">
            <div class="social_body social-media">
                <div class="social_body_bg">
                    <div class="question_wrap">
                        <?php include("ajxload/post.php");?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    else{
        include($ROOT_PATH.'/'.MODULE_PATH.'/dashboard/header.php');?>
        <div class="social_media">
            <?php
            include("navigation_social-media.php");?>
            <div class="social_body social-media">
                <?php 
                if($_SESSION['SOCIAL_TAB'])
                    include("ajxload/".$_SESSION['SOCIAL_TAB'].".php");
                else
                    include("ajxload/my_timeline.php");?>
            </div>
        </div>
        <?php
    }
    ?> 
</div>