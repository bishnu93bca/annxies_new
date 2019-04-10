<?php if($memberData) {
    if($_SESSION['FUSERLOGIN']=='ok')
    {
        $friendShip = $eObj->checkFriendship($_SESSION['FUSERID'], $memberData['id']);
        $publicUrl = $SITE_DASHBOARD_PATH.'/profile/'.$memberData['publicId'];

        if(!$friendShip){
            $blockedMember = $eObj->isBlocked($_SESSION['FUSERID'], $memberData['id']);
        }
    }
    else{
        $publicUrl = $SITE_LOC_PATH.'/'.$memberData['publicId'];
        echo '<div class="left_col float_center">';
    }    
    
    if($memberData['profilePic'] && file_exists($MEDIA_FILES_ROOT.'/member/thumb/'.$memberData['profilePic']))
        $dp = $MEDIA_FILES_SRC.'/member/thumb/'.$memberData['profilePic'];
    else{
        if($memberData['gender']=='Female')
            $dp = $STYLE_FILES_SRC.'/images/female.png';
        else
            $dp = $STYLE_FILES_SRC.'/images/male.png';
    }
    ?>
    <div class="">
        <div class="scroll_effect" data-effect="fadeInUp">
            <div class="fav_details myProfile "> <!--otherProfile-->
                <div class="profile_top clearfix">
                    <figure class="profilePic" style="background-image: url(<?php echo $dp;?>)"></figure>
                    
                    <div class="profile_right parent">
                        <?php 
                        if($friendShip['requestStatus']=='Accepted'){
                            $myStMsg = $eObj->getFStMsg($_SESSION['FUSERID'], $memberData['id']); 
                        ?>
                        
                        <div class="profile_post">
                            <h4 class="subheading proftitle"><?php echo $memberData['fullname'];?></h4>
                            
                            <div class="post_text mCustomScrollbar">
                                <?php echo $myStMsg['post'];?>
                            </div>
                            
                            <?php if($myStMsg) {?>
                            <div class="like_linkwrap">
                                <span class="like <?php echo ($myStMsg['postAct']==1)? 'mact':'';?>">
                                    <i class="fa fa-thumbs-up" data-act="1" data-track="<?php echo saltCrypt($myStMsg['postId']);?>"></i> 
                                    <a class="lc" href="javascript:void(0)"><?php echo ($myStMsg['likeCount']>0)? $myStMsg['likeCount']:'';?></a> 
                                </span>

                                <span class="unlike <?php echo ($myStMsg['postAct']==-1)? 'mact':'';?>">
                                    <i class="fa fa-thumbs-down" data-act="0" data-track="<?php echo saltCrypt($myStMsg['postId']);?>"></i> 
                                    <a class="dc" href="javascript:void(0)"><?php echo ($myStMsg['dislikeCount']>0)? $myStMsg['dislikeCount']:'';?></a>
                                </span>

                                <a href="javascript:void(0);" class="comment_link"><i class="fa fa-comments"></i> Comment <?php echo ($myStMsg['commentCount']>0)? '('.$myStMsg['commentCount'].')':'' ?></a>
                            </div>
                            <?php }?>

                            <div class="friend_btm">
                                <a href="<?php echo $publicUrl;?>" class="btn btn_small btn_action unfrnd" data-action="RemoveFriend" data-publicid="<?php echo $memberData['publicId'];?>"><i class="fa fa-user-times"></i> Unfriend</a>

                                <a href="<?php echo $publicUrl;?>" class="btn btn_small btn_action"><i class="fa fa-pencil"></i> Report</a>
                                <a href="<?php echo $SITE_DASHBOARD_PATH.'/social-media/message/'.$memberData['publicId'];?>/" class="btn btn_small btn_action frnd_comment"><i class="fa fa-comments"></i>  Message</a>
                            </div>

                        </div>

                        <div class="comment_block">
                            
                            <?php 
                            if($myStMsg) {
                                $rData = $eObj->getFReply($_SESSION['FUSERID'], "tp.parentId=".$myStMsg['postId'], 0, 30);
                                foreach($rData as $record){

                                    if($record['profilePic'] && $MEDIA_FILES_ROOT.'/member/thumb/'.$record['profilePic'])
                                        $fDP = $MEDIA_FILES_SRC.'/member/thumb/'.$record['profilePic'];
                                    else
                                        $fDP = $STYLE_FILES_SRC.'/images/'.strtolower($record['gender']).'.png';
                                    ?>
                                    <div class="cmtlist <?php echo ($record['blockedId'] || $record['memberId'] || $record['blockedBy'] || $record['me'])? 'blkdmem':'';?>">
                                        <div class="profile_top clearfix">
                                            <figure class="profilePic">
                                                <img src="<?php echo $fDP;?>" alt="<?php echo $record['fullname'];?>">
                                            </figure>
                                            <div class="profile_right child">
                                                <div class="profile_post">
                                                    <h5 class="subheading proftitle qthead">
                                                        <?php 
                                                        if($record['blockedId'] || $record['memberId'] || $record['blockedBy'] || $record['me'])
                                                            echo $record['fullname'];
                                                        else
                                                            echo '<a href="'.$SITE_DASHBOARD_PATH.'/profile/'.$record['publicId'].'">'.$record['fullname'].'</a>';
                                                        ?>
                                                    </h5>
                                                    
                                                    <span class="ptdt"><?php echo date('jS F, Y h:i A', strtotime($record['entryDate']));?></span>
                                                    
                                                    <div class="post_text">
                                                        <?php echo $record['post'];?>
                                                    </div>
                                                    
                                                    <?php if(!$record['blockedId'] && !$record['memberId'] && !$record['blockedBy'] && !$record['me']) {?>
                                                    <div class="like_linkwrap">
                                                        <span class="like <?php echo ($record['postAct']==1)? 'mact':'';?>">
                                                            <i class="fa fa-thumbs-up" data-act="1" data-track="<?php echo saltCrypt($record['postId']);?>"></i> 
                                                            <a class="lc" href="javascript:void(0)"><?php echo ($record['likeCount']>0)? $record['likeCount']:'';?></a> 
                                                        </span>

                                                        <span class="unlike <?php echo ($record['postAct']==-1)? 'mact':'';?>">
                                                            <i class="fa fa-thumbs-down" data-act="0" data-track="<?php echo saltCrypt($record['postId']);?>"></i> 
                                                            <a class="dc" href="javascript:void(0)"><?php echo ($record['dislikeCount']>0)? $record['dislikeCount']:'';?></a>
                                                        </span>

                                                        <a href="javascript:void(0);" class="reply_link"><i class="fa fa-comments"></i> Reply</a>

                                                        <?php if($record['publicId'] == $_SESSION['PUBLICID']){?>
                                                        <div class="frnd_option">
                                                            <span>More <i class="fa fa-angle-down"></i></span>
                                                            <ul>

                                                                <li><a href="javascript:void(0);" class="edtpst" data-track="<?php echo $record['permalink'];?>" data-page="edit-post"><i class="fa fa-pencil"></i> Edit</a></li>

                                                                <li><a href="javascript:void(0);" class="delpst" data-track="<?php echo $record['permalink'];?>" data-page="delete-post"><i class="fa fa-trash"></i> Delete</a></li>
                                                            </ul>
                                                        </div>
                                                        <?php }?>
                                                    </div>
                                                    <?php }?>
                                                </div>

                                                <?php
                                                $rcData = $eObj->getFReply($_SESSION['FUSERID'], "tp.parentId=".$record['postId'], 0, 30);
                                                foreach($rcData as $rc) {
                                                    if($rc['profilePic'] && $MEDIA_FILES_ROOT.'/member/thumb/'.$rc['profilePic'])
                                                        $fcDP = $MEDIA_FILES_SRC.'/member/thumb/'.$rc['profilePic'];
                                                    else
                                                        $fcDP = $STYLE_FILES_SRC.'/images/'.strtolower($rc['gender']).'.png';
                                                    ?>

                                                    <div class="qcreply_wrap <?php echo ($rc['blockedId'] || $rc['memberId'] || $rc['blockedBy'] || $rc['me'])? 'blkdmem':'';?>">
                                                        <div class="qcreply clearfix">
                                                            <span class="reply_icon"><i class="fa fa-reply"></i></span>
                                                            <figure class="qrp_avtar">
                                                                <img src="<?php echo $fcDP;?>" alt="<?php echo $rc['fullname'];?>">
                                                            </figure>
                                                            <div class="qcr_right">
                                                                <div class="qrtop">
                                                                    <h5 class="qthead">
                                                                        <?php 
                                                                        if($rc['blockedId'] || $rc['memberId'] || $rc['blockedBy'] || $rc['me'])
                                                                            echo $rc['fullname'];
                                                                        else
                                                                            echo '<a href="'.$SITE_DASHBOARD_PATH.'/profile/'.$rc['publicId'].'">'.$rc['fullname'].'</a>';
                                                                        ?>
                                                                    </h5>
                                                                    
                                                                    <span class="ptdt"><?php echo date('jS F, Y h:i A', strtotime($rc['entryDate']));?></span>

                                                                    <div class="post_mstream">
                                                                        <?php echo $rc['post'];?>
                                                                    </div>
                                                                    
                                                                    <?php if(!$record['blockedId'] && !$record['memberId'] && !$record['blockedBy'] && !$record['me']) {?>

                                                                    <div class="like_linkwrap">
                                                                        <span class="like  <?php echo ($rc['postAct']==1)? 'mact':'';?>">
                                                                            <i class="fa fa-thumbs-up" data-act="1" data-track="<?php echo saltCrypt($rc['postId']);?>"></i> 
                                                                            <a class="lc" href="javascript:void(0)"><?php echo ($rc['likeCount']>0)? $rc['likeCount']:'';?></a> 
                                                                        </span>

                                                                        <span class="unlike <?php echo ($rc['postAct']==-1)? 'mact':'';?>">
                                                                            <i class="fa fa-thumbs-down" data-act="0" data-track="<?php echo saltCrypt($rc['postId']);?>"></i> 
                                                                            <a class="dc" href="javascript:void(0)"><?php echo ($rc['dislikeCount']>0)? $rc['dislikeCount']:'';?></a>
                                                                        </span>

                                                                        <a href="javascript:void(0);" class="reply_link"><i class="fa fa-comments"></i> Reply</a>

                                                                        <?php if($rc['publicId'] == $_SESSION['PUBLICID']){?>
                                                                        <div class="frnd_option">
                                                                            <span>More <i class="fa fa-angle-down"></i></span>
                                                                            <ul>

                                                                                <li><a href="javascript:void(0);" class="edtpst" data-track="<?php echo $rc['permalink'];?>" data-page="edit-post"><i class="fa fa-pencil"></i> Edit</a></li>

                                                                                <li><a href="javascript:void(0);" class="delpst" data-track="<?php echo $rc['permalink'];?>" data-page="delete-post"><i class="fa fa-trash"></i> Delete</a></li>
                                                                            </ul>
                                                                        </div>
                                                                        <?php }?>
                                                                    </div>
                                                                    
                                                                    <?php }?>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <div class="reply_block comment_reply">
                                                    <div class="profile_top clearfix">
                                                        <figure class="profilePic">
                                                            <img src="<?php echo $_SESSION['DPURL'];?>" alt="<?php echo $_SESSION['FUSERFULLNAME'];?>">
                                                        </figure>
                                                        <div class="profile_right">
                                                            <form class="rplfrmstm" method="post" action="">
                                                                <input type="text" name="post" placeholder="Write your reply..." autocomplete="off">
                                                                <div class="common_option">
                                                                    <a href="#"><i class="fa fa-smile-o"></i></a>
                                                                </div>
                                                                <button type="submit"><i class="fa fa-paper-plane"></i></button>

                                                                <input type="hidden" name="ajax" value="1">
                                                                <input type="hidden" name="pid" value="<?php echo saltCrypt($record['postId']);?>">
                                                                <input type="hidden" name="SourceForm" value="NRplStm" />

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }

                            }?>
                            
                            
                            
                            
                                    
                            
                            <div class="reply_block">
                                <div class="profile_top clearfix">
                                    <figure class="profilePic">
                                        <img src="<?php echo $_SESSION['DPURL'];?>" alt="<?php echo $_SESSION['FUSERFULLNAME'];?>">
                                    </figure>
                                    <div class="profile_right">
                                        <form class="cmtfrmstm" method="post" action="">
                                            <input autocomplete="off" type="text" name="post" placeholder="Write a comment...">

                                            <div class="common_option">
                                                <a href="#"><i class="fa fa-smile-o"></i></a>
                                            </div>
                                            
                                            <button type="submit"><i class="fa fa-paper-plane"></i></button>

                                            <input type="hidden" name="ajax" value="1">
                                            <input type="hidden" name="pid" value="<?php echo saltCrypt($myStMsg['postId']);?>">
                                            <input type="hidden" name="SourceForm" value="NCmtStm">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php } else {?>
                        
                        <div class="profile_post">
                            <h4 class="subheading proftitle"><?php echo $memberData['fullname'];?></h4>
                            <div class="post_text">
                                <p class="loc"><i class="fa fa-map-marker"></i> Location</p>
                            </div>
                            
                            <?php if($_SESSION['FUSERID']!=$memberData['id']){?>
                            
                            <div class="friend_btm">
                                <?php 
                                if($_SESSION['FUSERLOGIN']=='ok'){
                                    if($_SESSION['FUSERTYPE']=='Student'){
                                        
                                        if($friendShip['requestStatus']=='Pending') {
                                            if($friendShip['memberId'] == $_SESSION['FUSERID']){
                                                ?>
                                                <a href="javascript:void(0)" class="btn btn_small btn_action">
                                                    <i class="fa fa-hourglass-start"></i> Waiting for Acceptance
                                                </a>
                                                <?php
                                            }
                                            else{
                                                ?>

                                                <a href="javascript:void(0)" class="btn btn_small btn_action acptfrnd" data-publicid="<?php echo $memberData['publicId'];?>" data-sf="FriendRequest" data-action="accept">
                                                    <i class="fa fa-check"></i> Accept Request
                                                </a>

                                                <a href="javascript:void(0)" class="btn btn_small btn_action dlreq" data-publicid="<?php echo $memberData['publicId'];?>" data-sf="FriendRequest" data-action="delete">
                                                    <i class="fa fa-trash-o"></i> Delete Request
                                                </a>
                                                <?php
                                            }
                                            ?>

                                            <a href="<?php echo $publicUrl;?>" class="btn btn_small btn_action blkfrnd" data-publicid="<?php echo $memberData['publicId'];?>" data-action="BlockMember">
                                                <i class="fa fa-user-times"></i> Block
                                            </a>
                                            <?php 
                                        } else {
                                            if($blockedMember){

                                                if($blockedMember['memberId']==$_SESSION['FUSERID']){
                                                    ?>
                                                    <a href="<?php echo $publicUrl;?>" class="btn btn_small btn_action unblkfrnd" data-publicid="<?php echo $memberData['publicId'];?>" data-action="UnblockMember">
                                                        <i class="fa fa-user-times"></i> Unblock
                                                    </a>
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <span class="btn btn_small btn_action"><i class="fa fa-ban"></i> Blocked Member</span>
                                                    <?php
                                                }
                                            }
                                            else{
                                                ?>
                                                <a href="<?php echo $publicUrl;?>" class="btn btn_small btn_action addfrnd" data-publicid="<?php echo $memberData['publicId'];?>" data-action="SendRequest">
                                                    <i class="fa fa-user-plus"></i> Add Friend
                                                </a>

                                                <a href="<?php echo $publicUrl;?>" class="btn btn_small btn_action blkfrnd" data-publicid="<?php echo $memberData['publicId'];?>" data-action="BlockMember">
                                                    <i class="fa fa-user-times"></i> Block
                                                </a>
                                                <?php
                                            }
                                        }                                        
                                    }
                                    ?>
                                    <a href="<?php echo $publicUrl;?>" class="btn btn_small btn_action rptfrnd" data-publicid="<?php echo $memberData['publicId'];?>" data-action="ReportMember">
                                        <i class="fa fa-pencil"></i> Report
                                    </a>
                                
                                    <?php 
                                } else {?>
                                    <a href="<?php echo $publicUrl;?>" class="btn btn_small btn_action">
                                        <i class="fa fa-user-plus"></i> Add Friend
                                    </a>
                                    <a href="<?php echo $publicUrl;?>" class="btn btn_small btn_action">
                                        <i class="fa fa-user-times"></i> Block
                                    </a>
                                    <a href="<?php echo $publicUrl;?>" class="btn btn_small btn_action">
                                        <i class="fa fa-pencil"></i> Report
                                    </a>
                                    <?php
                                }?>
                            </div>
                            <?php }?>
                        </div> 
                        
                        <?php }?>
                    </div>
                </div>
                

                <div class="friend_info">
                    <div class="subheading border_subhead grey">About</div>
                    <?php echo ($memberData['aboutMe'])? '<p>'.$memberData['aboutMe'].'</p>':'...';?>
                    
                    <div class="fdetails clearfix">
                        <?php if($friendShip['requestStatus']=='Accepted'){?>
                        <ul class="contact_info">
                            <?php if($memberData['phone']) {?>
                            <li>
                                <i class="fa fa-phone"></i>
                                <p><span><?php echo $memberData['phone'];?></span></p>
                            </li>
                            <?php } if($memberData['email']) {?>
                            <li>
                                <i class="fa fa-envelope-o"></i>
                                <p><a href="mailto:<?php echo $memberData['email'];?>"><?php echo $memberData['email'];?></a></p>
                            </li>
                            <?php }?>
                        </ul>
                        <?php }
                        
                        $edu = $eObj->getMemberEducation($memberData['id'], 0, 1);
                        if($edu){
                        ?>
                        <div class="fd_loc">
                            <div class="pc_loc">
                                <?php
                                if($edu[0]['photo'] && file_exists($MEDIA_FILES_ROOT.'/institutions/thumb/'.$edu[0]['photo']))
                                    $eduPhoto = $MEDIA_FILES_SRC.'/institutions/thumb/'.$edu[0]['photo'];
                                else
                                    $eduPhoto = $STYLE_FILES_SRC.'/images/noimage.png';
                                ?>
                                <img src="<?php echo $eduPhoto;?>" alt="<?php echo $edu[0]['instituteName'];?>">
                                <span><?php echo $edu[0]['instituteName'];?></span>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if($_SESSION['FUSERLOGIN']!='ok')
        echo '</div>';
    ?>

<div class="spacer"></div>
<?php } else $siteObj->redirectTo404($SITE_LOC_PATH);?>