<?php
$ExtraQryStr            = 1;
//$friendData             = $eObj->getFriendList($_SESSION['FUSERID'], $ExtraQryStr, 0, 30);
$friendData             = $eObj->getChatFriendList($_SESSION['FUSERID'], $ExtraQryStr, 0, 30);

if($friendData){
    $listgrid = 'listres_sml';
    
    if($dtls == 'message'){
        $chatingWith = $dtaction;
        $fData      = $eObj -> getMemberByprofileId($dtaction); 
    }
    else{
        $siteObj -> redirectToURL($SITE_DASHBOARD_PATH.'/social-media/'.$dtaction.'/'.$friendData[0]['publicId'].'/');
        exit();
    }
    
    if($fData['profilePic'] && file_exists($MEDIA_FILES_ROOT.'/member/thumb/'.$fData['profilePic']))
        $chatWithDP = $MEDIA_FILES_SRC.'/member/thumb/'.$fData['profilePic'];
    else{
        if($fData['gender']=='Female')
            $chatWithDP = $STYLE_FILES_SRC.'/images/female.png';
        else
            $chatWithDP = $STYLE_FILES_SRC.'/images/male.png';
    }
    
    echo '<div class="msgpane_wrap"><div class="fleft">
            <div class="social_form srch_frm">
                <form name="srch_frm" action="" method="post">
                    <span class="btn"><i class="fa fa-search"></i></span>
                    <input type="text" id="srchmem" autocomplete="off" name="srchtxt" placeholder="Search..." />
                    <input type="hidden" name="ActType" value="SearchFrn">
                </form>
            </div><div class="mCustomScrollbar"><ul class="'.$listgrid.' ul">';
        foreach($friendData as $resource){
            include("resource.php");
        }
    echo '</ul></div></div>';
    
    
    $checkBlock = $eObj -> isBlocked($_SESSION['FUSERID'], $fData['id']);
    
    ?>
    <div class="msgpane">
        <?php if(!$checkBlock){?>
        <div class="friend_block">
            <figure class="profilePic">
                <a href="<?php echo $SITE_DASHBOARD_PATH.'/profile/'.$fData['publicId'];?>/" style="background-image: url(<?php echo $chatWithDP;?>)"></a>
            </figure>
            <div class="friend_text">
                <h3 class="subheading"><a href="<?php echo $SITE_DASHBOARD_PATH.'/profile/'.$fData['publicId'];?>/"><?php echo $fData['fullname'];?></a></h3>
                <div class="">
                    <span><!--Active 2h ago--></span>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        
        <div class="msgarea cw_<?php echo $fData['publicId'];?>">            
            <div class="ctwrap mCustomScrollbar">
                <div class="chtthread">
                    <?php
                    $start = 0;
                    $limit = 30;
                    $chatCount = $eObj -> chatIndividualCount($_SESSION['FUSERID'], $fData['id']);   
                    if($chatCount>30){
                        echo '<div class="lpmsg" data-start="'.$start.'" data-limit="'.$limit.'">see older messages</div>';
                    }
                    ?>
                    
                    <ul class="thread">
                        <?php
                        include("message_item.php");                             
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

                            <button type="submit" class="sndmsg"><i class="fa fa-paper-plane"></i></button>
                            <input name="ajax" value="1" type="hidden">
                            <input name="to" class="to" value="<?php echo $chatingWith;?>" type="hidden">
                            <input name="toDP" class="toDP" value="<?php echo $ctdp;?>" type="hidden">
                            <input name="SourceForm" class="chatType" value="text" type="hidden">
                            <input name="SourceType" class="chatMsgType" value="<?php echo saltCrypt('i');?>" type="hidden">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php }?>
        
        <div class="msgpan_right"></div>
    </div>

    <?php echo '</div>';
}
?>