<?php
if($resource['groupPic'] && file_exists($MEDIA_FILES_ROOT.'/member/thumb/'.$resource['groupPic']))
    $dp = $MEDIA_FILES_SRC.'/member/thumb/'.$resource['groupPic'];
else
    $dp = $STYLE_FILES_SRC.'/images/noimage.png';


$linkUrl = $SITE_DASHBOARD_PATH.'/social-media/group/'.$resource['gpublicId'].'/';
?>
<li data-track="<?php echo $resource['publicId'];?>" <?php echo ($listgrid=='listres_sml' && $chatingWith == $resource['gpublicId'])? 'class="chtng_with"':'';?>>
    <div class="friend_block fblnk">
        <a href="<?php echo $linkUrl;?>">
            <figure class="profilePic">
                <span class="grp_dp" style="background-image: url(<?php echo $dp;?>)"></span>
            </figure>
            <div class="friend_text">
                <h3 class="subheading"><?php echo $resource['groupName'];?></h3>
                <div class="chthd_<?php echo $resource['gpublicId'];?>">
                    <?php 
                    if($listgrid=='listres_sml'){
                        if($resource['chatType'] == 'attachment')
                            $chatAtch = 'class="atch ptdt"';
                        else
                            $chatAtch = 'class="ptdt"';

                        if($resource['chat']){
                            if($resource['publicId'] == $_SESSION['PUBLICID'])
                                echo '<span '.$chatAtch.'>You: '.$resource['chat'].'</span>';
                            else
                                echo '<span '.$chatAtch.'>'.$resource['fullname'].': '.$resource['chat'].'</span>';
                        }
                    }
                    ?>
                </div>
            </div>
        
            <div class="clear"></div>
        </a>
    </div>
</li>