<div class="social_nav">
    <ul class="clearfix">
        <li <?php echo (!$_SESSION['FAVOURITE_TAB'] || $_SESSION['FAVOURITE_TAB']=='institute')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/my-favourites/';?>" data-page="my-favourites" data-tab="my-favourites"><i class="fa fa-university"></i> Favourite School / Collage / University</a>
        </li>
        
        <li <?php echo ($dtaction=='professors' || $_SESSION['FAVOURITE_TAB']=='professors')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/my-favourites/professors/';?>" data-page="my-favourites" data-tab="professors"><i class="fa fa-address-book-o"></i> Favourite Professors</a>
        </li>
        <li <?php echo ($dtaction=='jobs' || $_SESSION['FAVOURITE_TAB']=='jobs')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/my-favourites/jobs';?>" data-page="my-favourites" data-tab="jobs"><i class="fa fa-briefcase"></i> Favourite Jobs</a>
        </li>
        <li <?php echo ($dtaction=='study-materials' || $_SESSION['FAVOURITE_TAB']=='study-materials')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/my-favourites/study-materials';?>" data-page="my-favourites" data-tab="study-materials"><i class="fa fa-book"></i> Favourite Study Materials</a>
        </li>
    </ul>
</div>
