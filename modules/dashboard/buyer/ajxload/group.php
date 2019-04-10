<?php
$ExtraQryStr            = "res.isPrivate = '0'";
$friendData             = $eObj->getMyChatGroups($ExtraQryStr, $_SESSION['FUSERID'], 0, 30);

$listgrid = 'listres_sml';

if($dtls == 'group'){
    
    if($dtaction == 'create-group'){
        include("group_create.php");
    }
    else{
        $chatingWith    = $dtaction;
        if($pageTypeArray[2] == 'view'){
            $gData          = $eObj ->getGroupBypermalink($chatingWith, $_SESSION['FUSERID']);
            include('group_view.php');
        }
        else{
            
            $fData          = $eObj ->getGroupBypermalink($chatingWith, $_SESSION['FUSERID']);
        }
    }
}
else{
    if($friendData[0]['gpublicId']){
        $siteObj -> redirectToURL($SITE_DASHBOARD_PATH.'/social-media/'.$dtaction.'/'.$friendData[0]['gpublicId'].'/');
        exit();
    }
}

if($fData) {    
    $grpMembers     = $eObj ->chatGroupMembers($fData['groupId'], 0, 30);
    
    $grpMemberCount = $eObj ->chatGroupMemberCount($fData['groupId']);
    
    if($fData['groupPic'] && file_exists($MEDIA_FILES_ROOT.'/member/thumb/'.$fData['groupPic']))
        $chatWithDP = $MEDIA_FILES_SRC.'/member/thumb/'.$fData['groupPic'];
    else
        $chatWithDP = $STYLE_FILES_SRC.'/images/noimage.png';

    //class="cgp" data-page="create-group" data-group="" data-member=""
    echo '<div class="msgpane_wrap"><div class="fleft">
    
            <div class="ngrp">
                <a href="'.$SITE_DASHBOARD_PATH.'/social-media/group/create-group/">
                    <i class="fa fa-plus"></i> Create New Group
                </a>
            </div>
    
            <div class="social_form srch_frm">
                <form name="srch_frm" action="" method="post">
                    <span class="btn"><i class="fa fa-search"></i></span>
                    <input type="text" id="srchmem" autocomplete="off" name="srchtxt" placeholder="Search..." />
                    <input type="hidden" name="ActType" value="SearchGrp">
                </form>
            </div><div class="mCustomScrollbar"><ul class="'.$listgrid.' ul">';
        foreach($friendData as $resource){
            include("resource_group.php");
        }
    echo '</ul></div></div>';

    //$checkBlock = $eObj -> isBlocked($_SESSION['FUSERID'], $fData['id']);
    ?>
    <div class="msgpane">
        <?php if(!$checkBlock){?>
        <div class="friend_block">
            <figure class="profilePic">
                <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/view/group/'.$fData['publicId'];?>/" style="background-image: url(<?php echo $chatWithDP;?>)"></a>
            </figure>
            <div class="friend_text">
                <h3 class="subheading">
                    <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/view/group/'.$fData['publicId'];?>/">
                    <?php echo $fData['groupName'];?>
                    </a>
                </h3>
                <div class="ptdt">
                    <span>
                        <?php  
                        if($grpMemberCount<4){
                            $grpMemArr = array();
                            foreach($grpMembers as $grpMem){
                                $grpMemArr[] = $grpMem['fullname'];
                            }
                            echo implode(', ', $grpMemArr);
                        }
                        else {
                            echo $grpMembers[0]['fullname'].', '.$grpMembers[1]['fullname'].', '.$grpMembers[2]['fullname'].' and ';
                            $restMem = $grpMemberCount - 3;
                            
                            if($restMem>1)
                                echo $restMem.' others';
                            else
                                echo $restMem.' other';
                        }
                        ?>
                    </span>
                </div>
            </div>
            
            <?php if($fData['isAdmin']) {?>
            <div class="frnd_option">
                <span class="msg_settings"><i class="fa fa-cog"></i></span>
                <ul class="">
                    <li><a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/view/group/'.$fData['publicId'];?>/"><i class="fa fa-pencil"></i> Edit Group</a></li>
                    <li><a href="javascript:void(0)" class="dgrp" data-page="delete-group" data-group="<?php echo $fData['publicId'];?>" data-member=""><i class="fa fa-trash"></i> Delete Group</a></li>
                </ul>
            </div>
            <?php }?>
            
            <div class="clear"></div>
        </div>

        <div class="msgarea cw_<?php echo $fData['publicId'];?>">
            <div class="ctwrap mCustomScrollbar">
                <div class="chtthread">
                    <?php
                    $start = 0;
                    $limit = 30;
                    $chatCount = $eObj -> chatMessagesCount($_SESSION['FUSERID'], $fData['groupId'], 1);   
                    if($chatCount>30){
                        echo '<div class="lpmsg" data-start="'.$start.'" data-limit="'.$limit.'">see older messages</div>';
                    }
                    ?>
                    <ul class="thread">
                        <?php
                        include("message_gitem.php");                             
                        ?>
                    </ul>
                </div>
            </div>

            <form id="chtfrm" method="post" action="" enctype="multipart/form-data">
                <div id="dropzone">
                    <div class="anicnt">
                        <em class="up_s">
                            <i class="fa fa-cloud-upload"></i>
                        </em>
                        <p class="conMsg">Drop file here</p>
                    </div>
                    <input id="sndfl" type="file" name="sndFile">
                </div>
                <div class="reply_block">
                    <div class="typing"></div>
                    <div class="clearfix">
                        <figure class="profilePic" style="background-image: url(<?php echo $_SESSION['DPURL'];?>);"></figure>
                        <div class="profile_right">
                            <textarea class="emojiable-option" name="post" placeholder="Say something..." style="width: 277px;"></textarea>
                            <div class="common_option">
                                <a href="javascript:void();" class="paperclip"><i class="fa fa-paperclip"></i></a>
                            </div>
                            <button type="submit" class="sndmsg"><i class="fa fa-paper-plane"></i></button>
                            <input name="ajax" value="1" type="hidden">
                            <input name="to" class="to" value="<?php echo $chatingWith;?>" type="hidden">
                            <input name="toDP" class="toDP" value="<?php echo $ctdp;?>" type="hidden">
                            <input name="SourceForm" class="chatType" value="text" type="hidden">
                            <input name="SourceType" class="chatMsgType" value="<?php echo saltCrypt('g');?>" type="hidden">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php }?>

        <div class="msgpan_right">
            <?php if($fData['isAdmin']) {?>
            <div class="ngrp">
                <a href="javascript:void(0)" class="agm" data-member="" data-group="<?php echo $fData['publicId'];?>" data-page="add-group-member"><i class="fa fa-plus"></i> Add Member</a>
            </div>
            <?php }?>
            <div class="gmlist mCustomScrollbar">
                <ul class="ul grpmem">
                <?php    
                foreach($grpMembers as $grpMem){

                    if($grpMem['profilePic'] && file_exists($MEDIA_FILES_ROOT.'/member/thumb/'.$grpMem['profilePic']))
                        $memDP = $MEDIA_FILES_SRC.'/member/thumb/'.$grpMem['profilePic'];
                    else{
                        $memDP = $STYLE_FILES_SRC.'/images/'.strtolower($grpMem['gender']).'.png';
                    }
                    ?>
                    <li>
                        <div class="friend_block">
                            <figure class="profilePic">
                                <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/message/'.$grpMem['publicId'].'/';?>" style="background-image: url(<?php echo $memDP;?>)"></a>
                            </figure>
                            <div class="friend_text">
                                <h3 class="subheading">
                                    <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/message/'.$grpMem['publicId'].'/';?>">
                                        <?php echo $grpMem['fullname'];?>
                                    </a>
                                </h3>                            
                            </div>
                            <div class="clear"></div>
                            <?php if(!$grpMem['isAdmin'] && $fData['isAdmin']){?>
                            <div class="frnd_option">
                                <span class="msg_settings"><i class="ion-android-more-vertical"></i></span>
                                <ul class="">
                                    <li><a href="javascript:void(0)" class="dgm" data-member="<?php echo $grpMem['publicId'];?>" data-group="<?php echo $fData['publicId'];?>" data-page="delete-group-member">
                                        <i class="fa fa-trash"></i> Delete from Group</a>
                                    </li>
                                </ul>
                            </div>
                            <?php } else if($grpMem['isAdmin']) echo '<span class="admin">admin</span>';?>
                        </div>
                    </li>
                    <?php
                }
                ?>
                </ul>
            </div>
            <?php if(!$fData['isAdmin']) {?>
            <div class="ngrp">
                <a href="javascript:void(0)" class="xgrp" data-group="<?php echo $fData['publicId'];?>" data-member="" data-page="exit-from-group"><i class="fa fa-minus"></i> Quit From Group</a>
            </div>
            <?php }?>
        </div>
    </div>
    <?php echo '</div>';
}
?>