<?php
if($gData['groupPic'] && file_exists($MEDIA_FILES_ROOT.'/member/thumb/'.$gData['groupPic']))
    $gdp = $MEDIA_FILES_SRC.'/member/thumb/'.$gData['groupPic'];
else
    $gdp = $STYLE_FILES_SRC.'/images/noimage.png';
?>
<div class="post_form">
    <?php if($gData['isAdmin']){?>
    <div class="sp_box inq_box clearfix">	
        <div class="subheading">
            <?php echo $gData['groupName'].' <span class="ptdt">created by you on '. date('M j, Y h:i A', strtotime($gData['entryDate'])) .'</span>';?>
        </div>
    </div>
    
    <form id="egpfrm" method="post" action="" enctype="multipart/form-data">
        <ul class="clearfix">
            <li>
                <div class="group_img" style="background-image: url(<?php echo $gdp; ?>);">
                    <a href="javascript:void(0);" class="img_browse"><i class="fa fa-camera"></i></a>
                </div>
                <div class="group_info">
                    <div class="input_field">
                        <span class="plabel">Group</span>
                        <div class="pf_right">
                            <input type="text" autocomplete="off" name="groupName" placeholder="Group Name" value="<?php echo $gData['groupName'];?>">
                        </div>
                    </div>
                    <div class="input_field">
                        <span class="plabel">About Group</span>
                        <div class="pf_right">
                            <textarea placeholder="Describe something about this group..." name="groupDesc"><?php echo $gData['groupDesc'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </li>
            
        </ul>
        <div class="btn_pr">
            <button type="submit" class="btn egp">
                Save
            </button>

            <input type="hidden" name="SourceForm" value="EGrp">
            <input type="hidden" name="ajax" value="1">
            <input type="hidden" name="group" value="<?php echo $gData['publicId'];?>">
        </div>
    </form>
    <?php } else {?>
    <ul class="clearfix">
        <li>
            <div class="group_img" style="background-image: url(<?php echo $STYLE_FILES_SRC.'/images/noimage.png'; ?>);"></div>
            <div class="group_info">
                <div class="input_field border_btm">
                    <div class="subheading"><?php echo $gData['groupName'];?></div>
                    <div class="ptdt">Created by <?php echo '<a href="'.$SITE_DASHBOARD_PATH.'/profile/'.$gData['mpublicId'].'/">'.$gData['fullname']. '</a> on ' .date('M j, Y h:i A', strtotime($gData['entryDate'])); ?></div>
                </div>
                <div class="input_field">
                    <p><?php echo $gData['groupDesc'];?></p>
                    <div><a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/group/'.$gData['publicId'].'/'; ?>" class="btn btn_small btn_action frnd_comment"><i class="fa fa-comments"></i>  Message</a></div>
                </div>
            </div>
            <div class="clear"></div>
        </li>
        
    </ul>
    <?php }?>
</div>