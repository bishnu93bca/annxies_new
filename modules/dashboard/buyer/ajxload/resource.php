<?php
if($resource['profilePic'] && file_exists($MEDIA_FILES_ROOT.'/member/thumb/'.$resource['profilePic']))
    $dp = $MEDIA_FILES_SRC.'/member/thumb/'.$resource['profilePic'];
else{
    if($resource['gender']=='Female')
        $dp = $STYLE_FILES_SRC.'/images/female.png';
    else
        $dp = $STYLE_FILES_SRC.'/images/male.png';
}

if($dtaction == 'message' || $dtls == 'message')
    $linkUrl = $SITE_DASHBOARD_PATH.'/social-media/message/'.$resource['publicId'].'/';
else
    $linkUrl = $SITE_DASHBOARD_PATH.'/profile/'.$resource['publicId'].'/';
?>
<li data-track="<?php echo $resource['publicId'];?>" <?php echo ($listgrid=='listres_sml' && $chatingWith == $resource['publicId'])? 'class="chtng_with"':'';?>>
    <div class="friend_block">
        <figure class="profilePic">
            <a href="<?php echo $linkUrl;?>" style="background-image: url(<?php echo $dp;?>)"></a>
        </figure>
        <div class="friend_text">
            <h3 class="subheading">
                <a href="<?php echo $linkUrl;?>">
                    <?php echo $resource['fullname'];?>
                </a>
            </h3>
            <div class="chthd_<?php echo $resource['publicId'];?>">
                <?php 
                if($listgrid=='listres_sml'){
                    if($resource['chatType'] == 'attachment')
                        $chatAtch = 'class="atch ptdt"';
                    else
                        $chatAtch = 'class="ptdt"';
                    
                    if($resource['memberId'] == $_SESSION['FUSERID'])
                        echo '<a href="'.$linkUrl.'"><span '.$chatAtch.'>You: '.$resource['chat'].'</span></a>';
                    else
                        echo '<a href="'.$linkUrl.'"><span '.$chatAtch.'>'.$resource['chat'].'</span></a>';
                }
                else{
                    if($_SESSION['FUSERTYPE']=='Recruiter')
                        echo 'Applied on '.date('M j, Y', strtotime($resource['entryDate']));
                    else{
                        $location = '';
                        if($resource['city'])
                            $location = $resource['city'];
                        
                        if($resource['state']){
                            if($location)
                                $location .= ', '.$resource['state'];
                            else
                                $location = $resource['state'];
                        }
                        
                        if($location)
                            echo '<strong>'.$location.'</strong>';
                    }  
                }
                ?>
            </div>
            <?php if($listgrid != 'listres_sml') {?>
            <div class="friend_btm">
                <?php if($_SESSION['FUSERTYPE']=='Student'){?>
                
                <div class="frnd_links">
                    <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/message/'.$resource['publicId'];?>/" class="btn btn_white"><i class="fa fa-comments"></i> Message</a>
                </div>
                <div class="frnd_option">
                    <span class="btn btn_white"><i class="fa fa-check"></i> Friends</span>
                    <ul class="">
                        <li><a href="#" class="unfrnd" data-action="RemoveFriend" data-publicid="<?php echo $resource['publicId'];?>"><i class="fa fa-user-times"></i> Unfriend</a></li>
                    </ul>
                </div>
                <!--<a href="<?php echo $publicUrl;?>" class="btn btn_white unfrnd" data-action="RemoveFriend" data-publicid="<?php echo $resource['publicId'];?>"><i class="fa fa-check"></i> Friends</a>-->
                
                <!--                
                <a href="javascript:void(0);" class="btn btn_white hover_effect"><i class="fa fa-check"></i> Friends</a>
                -->
                
                <?php } elseif($_SESSION['FUSERTYPE']=='Recruiter'){?>

                <div class="frnd_links">
                    <a href="javascript:void(0);" data-page="view-application" data-track="<?php echo saltCrypt($resource['applyId']);?>" class="btn btn_white vappl" title="Cover Letter"><i class="fa fa-envelope-open"></i>Cover Letter</a>
                </div>
                <a href="javascript:void(0);" data-page="cv-download" data-track="<?php echo saltCrypt($resource['applyId']);?>" class="btn btn_white dload"><i class="fa fa-download"></i>CV</a>
                <?php }?>
            </div>
            <?php }?>
        </div>
        <div class="clear"></div>
    </div>
</li>