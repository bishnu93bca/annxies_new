<div class="fav_details myProfile">
    <div class="social_media">
        <?php include("navigation_study-material.php");?>
        <div class="study-material">
            <?php 
            if($_SESSION['STUDY_TAB'])
                include("ajxload/".$_SESSION['STUDY_TAB'].".php");
            else
                include("ajxload/approved_docs.php");?>
        </div>
    </div>  
</div>





