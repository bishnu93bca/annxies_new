<div class="fav_details myProfile">
    <div class="social_media">
        <?php include("navigation_my-favourites.php");?>
        <div class="study-material">
            <?php 
            if($_SESSION['FAVOURITE_TAB'])
                include("ajxload/".$_SESSION['FAVOURITE_TAB'].".php");
            else
                include("ajxload/institute.php");?>
        </div>
    </div>
</div>