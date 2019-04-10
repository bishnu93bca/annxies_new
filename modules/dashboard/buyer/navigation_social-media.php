<?php
$_SESSION['FRIENDCOUNT']= $eObj->friendCount($_SESSION['FUSERID'], 1);
?>
<div class="social_nav">
    <ul class="clearfix">
        <li <?php echo (!$_SESSION['SOCIAL_TAB'] || $_SESSION['SOCIAL_TAB']=='my_timeline')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/';?>" data-page="social-media" data-tab="social-media"><i class="fa fa-bullhorn"></i> Timeline</a>
        </li>
        
        <li <?php echo ($dtaction=='my-friends' || $_SESSION['SOCIAL_TAB']=='my_friends')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/my-friends/';?>" data-page="social-media" data-tab="my-friends"><i class="fa fa-user"></i> My Friends <?php echo ($_SESSION['FRIENDCOUNT']>0)? '<span>'.$_SESSION['FRIENDCOUNT'].'</span>':'';?></a>
        </li>
        <li <?php echo ($dtaction=='add-friend' || $_SESSION['SOCIAL_TAB']=='add_friend')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/add-friend/';?>" data-page="social-media" data-tab="add-friend"><i class="fa fa-user-plus"></i> Add Friend</a>
        </li>
        <li <?php echo ($dtaction=='ask-a-question' || $_SESSION['SOCIAL_TAB']=='ask_a_question')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/ask-a-question/';?>" data-page="social-media" data-tab="ask-a-question"><i class="fa fa-question"></i> Ask a Question</a>
        </li>
        <li <?php echo ($dtaction=='help-a-friend' || $_SESSION['SOCIAL_TAB']=='help_a_friend')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/help-a-friend/';?>" data-page="social-media" data-tab="help-a-friend"><i class="fa fa-info"></i> Help a Friend</a>
        </li>
        <!--<li <?php echo ($dtaction=='notification' || $_SESSION['SOCIAL_TAB']=='notification')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/notification/';?>" data-tab="notification">Notification</a>
        </li>-->
        <li <?php echo ($dtaction=='message' || $_SESSION['SOCIAL_TAB']=='message')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/message/';?>" data-page="social-media" data-tab="message"><i class="fa fa-comments"></i> Message</a>
        </li>
        <li <?php echo ($dtaction=='group' || $_SESSION['SOCIAL_TAB']=='group')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/group/';?>" data-page="social-media" data-tab="group"><i class="fa fa-users"></i> Group</a>
        </li>
        <li <?php echo ($dtaction=='blocked' || $_SESSION['SOCIAL_TAB']=='blocked_members')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/blocked/';?>" data-page="social-media" data-tab="blocked"><i class="fa fa-user-times"></i> Blocked <?php echo ($_SESSION['BLOCKCOUNT']>0)? '<span>'.$_SESSION['BLOCKCOUNT'].'</span>':'';?></a>
        </li>
    </ul>
</div>