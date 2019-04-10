<?php
$ExtraQryStr = 1;
$pData       = $eObj->getMyPost($_SESSION['FUSERID'], $ExtraQryStr, 0, 30);
?>
<div class="social_form">
    <form method="post" id="addpost" action="">
        <input type="text" autocomplete="off" name="post" value="" placeholder="Type your question" />
        <input type="hidden" name="ajax" value="1">
        <input type="hidden" name="SourceForm" value="NQuestion" />
        <button type="submit" class="btn btn_orange">SUBMIT</button>
    </form>
</div>
<div class="social_body_bg">
    <div class="question_wrap">
        <?php
        $sl = 0;
        foreach($pData as $record){
            ?>
            <div class="question_block <?php echo ($sl==0 && $record['commentCount']>0)? 'opened':'';?>">
                <div class="question_head">
                    <figure class="avtar" style="background-image: url(<?php echo $_SESSION['DPURL'];?>);"></figure>
                    
                    <h5 class="qthead"><?php echo $_SESSION['FUSERFULLNAME'];?> 
                        <?php /*<span class="grey">(Rutherford University)</span>*/?>
                    </h5>
                    <div class="ptdt"><?php echo date('M j, Y h:i A', strtotime($record['entryDate']));?></div>
                    
                    <div class="post_mstream">
                        <?php echo $record['post'];?>
                    </div>
                    
                    <div class="like_linkwrap">
                        <span class="like <?php echo ($record['postAct']==1)? 'mact':'';?>">
                            <i class="fa fa-thumbs-up" data-act="1" data-track="<?php echo saltCrypt($record['postId']);?>"></i> 
                            <a class="lc" href="javascript:void(0)"><?php echo ($record['likeCount']>0)? $record['likeCount']:'';?></a> 
                        </span>
                        
                        <span class="unlike <?php echo ($record['postAct']==-1)? 'mact':'';?>">
                            <i class="fa fa-thumbs-down" data-act="0" data-track="<?php echo saltCrypt($record['postId']);?>"></i> 
                            <a class="dc" href="javascript:void(0)"><?php echo ($record['dislikeCount']>0)? $record['dislikeCount']:'';?></a>
                        </span>
                        
                        <a href="javascript:void(0);" class="comment_link"><i class="fa fa-comments"></i> 
                            Comment 
                            <?php echo ($record['commentCount']>0)? '('.$record['commentCount'].')':'';?>
                        </a>
                        
                        <div class="frnd_option">
                            <span>More <i class="fa fa-angle-down"></i></span>
                            <ul>
                                <li><a href="javascript:void(0);" class="edtpst" data-track="<?php echo $record['permalink'];?>" data-page="edit-post"><i class="fa fa-pencil"></i> Edit</a></li>
                                <li><a href="javascript:void(0);" class="delpst" data-track="<?php echo $record['permalink'];?>" data-page="delete-post"><i class="fa fa-trash"></i> Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="question_cont acc_con">
                    <div class="q_inner">
                        
                        <?php
                        $rData = $eObj->getReply($_SESSION['FUSERID'], "tp.parentId=".$record['postId'], 0, 30);
                        foreach($rData as $rd){
                            
                            if($rd['profilePic'] && $MEDIA_FILES_ROOT.'/member/thumb/'.$rd['profilePic'])
                                $fDP = $MEDIA_FILES_SRC.'/member/thumb/'.$rd['profilePic'];
                            else
                                $fDP = $STYLE_FILES_SRC.'/images/'.strtolower($rd['gender']).'.png';
                            
                            ?>
                            <div class="question_reply">
                                <div class="qrp_block clearfix">
                                    <figure class="qrp_avtar" style="background-image: url(<?php echo $fDP;?>);">
                                        <a href="<?php echo $SITE_DASHBOARD_PATH.'/profile/'.$rd['publicId'];?>"></a>
                                    </figure>
                                    <div class="qrp_right">
                                        <div class="qrtop">
                                            <h5 class="qthead">
                                                <a href="<?php echo $SITE_DASHBOARD_PATH.'/profile/'.$rd['publicId'];?>"><?php echo $rd['fullname'];?></a> 
                                            </h5>
                                            
                                            <span class="ptdt"><?php echo date('M j, Y h:i A', strtotime($rd['entryDate']));?></span>
                                            
                                            <div class="post_mstream">
                                                <?php echo $rd['post'];?>
                                            </div>

                                            <div class="like_linkwrap">
                                                <span class="like <?php echo ($rd['postAct']==1)? 'mact':'';?>">
                                                    <i class="fa fa-thumbs-up" data-act="1" data-track="<?php echo saltCrypt($rd['postId']);?>"></i> 
                                                    <a class="lc" href="javascript:void(0)"><?php echo ($rd['likeCount']>0)? $rd['likeCount']:'';?></a> 
                                                </span>

                                                <span class="unlike <?php echo ($rd['postAct']==-1)? 'mact':'';?>">
                                                    <i class="fa fa-thumbs-down" data-act="0" data-track="<?php echo saltCrypt($rd['postId']);?>"></i> 
                                                    <a class="dc" href="javascript:void(0)"><?php echo ($rd['dislikeCount']>0)? $rd['dislikeCount']:'';?></a>
                                                </span>

                                                <a href="javascript:void(0);" class="reply_link"><i class="fa fa-comments"></i> Reply  <?php echo ($rd['commentCount']>0)? '('.$rd['commentCount'].')':'';?></a>
                                                
                                                
                                                <div class="frnd_option">
                                                    <span>More <i class="fa fa-angle-down"></i></span>
                                                    <ul>
                                                        <?php if($rd['publicId'] == $_SESSION['PUBLICID']){?>
                                                        <li><a href="javascript:void(0);" class="edtpst" data-track="<?php echo $rd['permalink'];?>" data-page="edit-post"><i class="fa fa-pencil"></i> Edit</a></li>
                                                        <?php }?>
                                                        
                                                        <li><a href="javascript:void(0);" class="delpst" data-track="<?php echo $rd['permalink'];?>" data-page="delete-post"><i class="fa fa-trash"></i> Delete</a></li>
                                                    </ul>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                        <?php
                                        $rcData = $eObj->getReply($_SESSION['FUSERID'], "tp.parentId=".$rd['postId'], 0, 30);
                                        foreach($rcData as $rc){
                                            if($rc['profilePic'] && $MEDIA_FILES_ROOT.'/member/thumb/'.$rc['profilePic'])
                                                $fcDP = $MEDIA_FILES_SRC.'/member/thumb/'.$rc['profilePic'];
                                            else
                                                $fcDP = $STYLE_FILES_SRC.'/images/'.strtolower($rc['gender']).'.png';
                                            ?>
                                            <div class="qcreply_wrap">
                                                <div class="qcreply clearfix">
                                                    <span class="reply_icon"><i class="fa fa-reply"></i></span>
                                                    
                                                    <figure class="qrp_avtar" style="background-image: url(<?php echo $fcDP;?>);">
                                                        <a href="<?php echo $SITE_DASHBOARD_PATH.'/profile/'.$rc['publicId'];?>"></a>
                                                    </figure>
                                                    
                                                    <div class="qcr_right">
                                                        <div class="qrtop">
                                                            <h5 class="qthead">
                                                                <a href=""><?php echo $rc['fullname'];?></a> 
                                                            </h5>
                                                            
                                                            <span class="ptdt"><?php echo date('M j, Y h:i A', strtotime($rc['entryDate']));?></span>

                                                            <div class="post_mstream">
                                                                <?php echo $rc['post'];?>
                                                            </div>

                                                            <div class="like_linkwrap">
                                                                <span class="like <?php echo ($rc['postAct']==1)? 'mact':'';?>">
                                                                    <i class="fa fa-thumbs-up" data-act="1" data-track="<?php echo saltCrypt($rc['postId']);?>"></i> 
                                                                    <a class="lc" href="javascript:void(0)"><?php echo ($rc['likeCount']>0)? $rc['likeCount']:'';?></a> 
                                                                </span>

                                                                <span class="unlike <?php echo ($rc['postAct']==-1)? 'mact':'';?>">
                                                                    <i class="fa fa-thumbs-down" data-act="0" data-track="<?php echo saltCrypt($rc['postId']);?>"></i> 
                                                                    <a class="dc" href="javascript:void(0)"><?php echo ($rc['dislikeCount']>0)? $rc['dislikeCount']:'';?></a>
                                                                </span>

                                                                <a href="javascript:void(0);" class="reply_link"><i class="fa fa-comments"></i> Reply</a>
                                                                
                                                                <div class="frnd_option">
                                                                    <span>More <i class="fa fa-angle-down"></i></span>
                                                                    <ul>
                                                                        <?php if($rc['publicId'] == $_SESSION['PUBLICID']){?>
                                                                        <li><a href="javascript:void(0);" class="edtpst" data-track="<?php echo $rc['permalink'];?>" data-page="edit-post"><i class="fa fa-pencil"></i> Edit</a></li>
                                                                        <?php }?>

                                                                        <li><a href="javascript:void(0);" class="delpst" data-track="<?php echo $rc['permalink'];?>" data-page="delete-post"><i class="fa fa-trash"></i> Delete</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>	
                                            <?php 
                                        }?>
                                        
                                        
                                        <div class="reply_block comment_reply">
                                            <div class="clearfix">
                                                
                                                <figure class="profilePic" style="background-image: url(<?php echo $_SESSION['DPURL'];?>);"></figure>
                                                
                                                <div class="profile_right">
                                                    <form class="rplfrm" action="" method="post">
                                                        <textarea class="emojiable-option" name="post" placeholder="Write a reply..."></textarea>
                                                        <input type="hidden" name="ajax" value="1">
                                                        <input type="hidden" name="pid" value="<?php echo saltCrypt($rd['postId']);?>">
                                                        <input type="hidden" name="SourceForm" value="NRpl" />
                                                        
                                                        <button type="submit"><i class="fa fa-paper-plane"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="reply_block">
                            <div class="profile_top clearfix">
                                <figure class="profilePic" style="background-image: url(<?php echo $_SESSION['DPURL'];?>);"></figure>
                                
                                <div class="profile_right">
                                    <form class="cmtfrm" action="" method="post">
                                        <textarea class="emojiable-option" name="post" placeholder="Write a comment..."></textarea>
                                        <input type="hidden" name="ajax" value="1">
                                        <input type="hidden" name="pid" value="<?php echo saltCrypt($record['postId']);?>">
                                        <input type="hidden" name="SourceForm" value="NCmt" />
                                        
                                        <button type="submit"><i class="fa fa-paper-plane"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $sl++;
        }
        ?>
    </div>
</div>