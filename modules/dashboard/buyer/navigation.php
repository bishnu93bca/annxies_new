<div class="left_menu">
    <div class="theiaStickySidebar"><!--theiaStickySidebar-->
        <!--<span class="side_nav_icon"><i class="fa fa-arrow-circle-right"></i></span>-->
        <div class="side_nav_wrap">
            <div class="side_nav">
                <ul class="clearfix">
                    
                    <li <?php echo (!$dtaction || $dtls=='social-media'|| $dtaction=='social-media' || $dtls=='profile' || $dtls=='message' || $dtls=='post')? 'class="active"':'';?>>
                        <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/';?>">
                            <div class="menu_icon">
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_social.png" alt="" class="original" />
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_social_w.png" alt="" class="hovered" />
                            </div>
                            <span>Social Media</span>
                        </a>
                    </li>
                    <li <?php echo ($dtls=='study-material' || $dtaction=='study-material')? 'class="active"':'';?>>
                        <a href="<?php echo $SITE_DASHBOARD_PATH.'/study-material/';?>">
                            <div class="menu_icon">
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_study.png" alt="" class="original" />
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_study_w.png" alt="" class="hovered" />
                            </div>
                            <span>Study Material</span>
                        </a>
                    </li>
                    
                    
                    <li <?php echo ($dtls=='my-favourites' || $dtaction=='my-favourites')? 'class="active"':'';?>>
                        <a href="<?php echo $SITE_DASHBOARD_PATH.'/my-favourites/';?>">
                            <div class="menu_icon">
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_fav.png" alt="" class="original" />
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_fav_w.png" alt="" class="hovered" />
                            </div>
                            <span>My Favourites</span>
                        </a>
                    </li>
                    <li <?php echo ($dtaction=='score-card')? 'class="active"':'';?>>
                        <a href="<?php echo $SITE_DASHBOARD_PATH.'/score-card/';?>">
                            <div class="menu_icon">
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_score.png" alt="" class="original" />
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_score_w.png" alt="" class="hovered" />
                            </div>
                            <span>Score Card</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="menu_icon">
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_tution.png" alt="" class="original" />
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_tution_w.png" alt="" class="hovered" />
                            </div>
                            <span>Online Tution</span>
                        </a>
                    </li>
                    
                    <li <?php echo ($dtaction=='applied-jobs')? 'class="active"':'';?>>
                        <a href="<?php echo $SITE_DASHBOARD_PATH.'/applied-jobs/';?>">
                            <div class="menu_icon">
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_job.png" alt="" class="original" />
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_job_w.png" alt="" class="hovered" />
                            </div>
                            <span>Applied Jobs</span>
                        </a>
                    </li>
                    <li <?php echo ($dtaction=='my-profile')? 'class="active"':'';?>>
                        <a href="<?php echo $SITE_DASHBOARD_PATH.'/my-profile/';?>">
                            <div class="menu_icon">
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_profile.png" alt="" class="original" />
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_profile_w.png" alt="" class="hovered" />
                            </div>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li <?php echo ($dtaction=='change-password')? 'class="active"':'';?>>
                        <a href="<?php echo $SITE_DASHBOARD_PATH.'/change-password/';?>">
                            <div class="menu_icon">
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_password.png" alt="" class="original" />
                                <img src="<?php echo $STYLE_FILES_SRC;?>/images/icon_password_w.png" alt="" class="hovered" />
                            </div>
                            <span class="pt0">Change Password</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div><!-- left_menu ends -->    