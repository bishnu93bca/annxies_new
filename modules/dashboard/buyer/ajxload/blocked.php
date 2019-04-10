<?php
$ExtraQryStr            = 1;
$friendData             = $eObj->getBlockedMemberList($_SESSION['FUSERID'], $ExtraQryStr, 0, 30);

if($friendData){
    ?>
    <ul class="col3 clearfix">
        <?php 
        foreach($friendData as $friend){
            if($friend['profilePic'] && file_exists($MEDIA_FILES_ROOT.'/member/thumb/'.$friend['profilePic']))
                $dp = $MEDIA_FILES_SRC.'/member/thumb/'.$friend['profilePic'];
            else{
                if($friend['gender']=='Female')
                    $dp = $STYLE_FILES_SRC.'/images/female.png';
                else
                    $dp = $STYLE_FILES_SRC.'/images/male.png';
            }
            ?>
            <li>
                <div class="friend_block">
                    <figure class="profilePic">
                        <a href="<?php echo $SITE_DASHBOARD_PATH.'/profile/'.$friend['publicId'];?>"><img src="<?php echo $dp;?>" alt="<?php echo $friend['publicId'];?>"></a>
                    </figure>
                    <div class="friend_text">
                        <h3 class="subheading"><a href="<?php echo $SITE_DASHBOARD_PATH.'/profile/'.$friend['publicId'];?>"><?php echo $friend['fullname'];?></a></h3>
                        <!--<div class=""><strong>Rutherford University</strong></div>-->
                        <div class="friend_btm">
                            
                            <a href="javascript:void(0);" class="btn btn_white hover_effect unblkfrnd" data-publicid="<?php echo $friend['publicId'];?>" data-action="UnblockMember"><i class="fa fa-user-times"></i> Unblock</a>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </li>
        <?php }?>
    </ul>
    <?php
}
?>