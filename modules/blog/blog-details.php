<?php
$ExtraQrySt =  "blogType='P' and status='Y'";
$selData    =  $tbj -> blogByPermalinkandExtraQryStr($dtaction,$ExtraQrySt);
$ExtraQryCm =  "blogType='C' and status='Y' ";
$cmtData    =  $objComment->getComment($ExtraQryCm,$selData['blogId']);
if(sizeof($cmtData)>1)
    $cmt='Comments';
else 
    $cmt='Comment';
?>
<div class="main_content_area annexisbusinessbg">
     <div class="container">
         <div class="row" id="margin-top">
             <div class="span8">
                <div class="row" style="margin-bottom:50px;">
                    <div class="span8">
                        <div class="blog_item blog_details">
                            <?php                    
                            if(file_exists($MEDIA_FILES_ROOT.'/blog/large/'.$selData['blogImage']) && $selData['blogImage']){
                                echo '<div class="blog_img">';
                                    echo '<img src="'.$MEDIA_FILES_SRC.'/blog/large/'.$selData['blogImage'].'" alt="'.$selData['blogTitle'].'"/>';

                                echo '</div>';
                            }
                            ?>
                             
                            <div class="blog_post_item_description">
                                <div class="blog_head blog_inner">
                                    <h4><?php echo $selData['blogTitle'];?></h4>
                                    <div class="meta">
                                        <span><b>By</b> <?php echo $selData['blogAuthor'];?></span>
                                        <?php echo (sizeof($cmtData)>0)? '<span class="last-item">'.sizeof($cmtData).' '.$cmt.'</span>':'';?>
                                    </div>
                                </div>        
                                <?php echo $selData['blogContent'];?>
                            </div>
                        </div>  
                    </div>
                    <div class="span8">                                
                        <div class="share">
                            <span style="float:left; margin-right:10px;">Share this Story:</span>
                            <div style="float:left">
                            <!-- AddThis Button BEGIN -->
                            <div class="addthis_toolbox addthis_default_style ">
                            <a class="addthis_counter addthis_pill_style"></a>
                            </div>
                            <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
                            <script type="text/javascript" src="../../s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f88195d6026781e"></script>
                            <!-- AddThis Button END -->
                            </div>
                        </div>
                    </div>
                   
                    <div class="span8">
                        <div class="comments_div"> 
                            <?php if(sizeof($cmtData)>0) { ?>
                                <h3 style="font-weight: 600 !important; text-transform: uppercase !important;"><?php echo sizeof($cmtData).' '.$cmt;?></h3>
                                <ul class="unstyled commentsul">
                                    <?php
                                    foreach($cmtData as $cm)
                                    {
                                        $cd= date('d M Y',strtotime($cm['blogDate']));
                                        ?>
                                        <li class="comment even thread-even depth-1">
                                            <div class="seppp">
                                                <div>
                                                    <div class="blog_item_comments_description">
                                                        <!--<div class="hidden-phone" style="float: left; margin-right: 0px;">
                                                            <img alt="" src="<?php echo $STYLE_FILES_SRC;?>/images/gallery/avatar-2.png" class="avatar img-polaroid avatar-70 photo avatar-default" height="70" width="70"/>
                                                        </div>-->
                                                        <h6 style="margin-bottom: 4px;">By <span class="colored"></span>
                                                        <?php echo $cd;?>
                                                        </h6>

                                                        <hr style="margin-top: 0px; margin-bottom: 10px;"/>

                                                        <div style="font-style: italic;">
                                                            <?php echo $cm['blogContent'];?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php 
                                    }
                                    ?>
                                </ul>
                            <?php }?>
                            <div id="respond" style="padding-top:40px;">
                                <h4 style="font-weight:600 !important; margin-bottom:12px;">Leave a Reply</h4>
                                <form class="form" method="post" id="blogcomment">
                                <input type="text" class="span4" style="margin-right:25px;" placeholder="Name" name="author" value="" />
                                <br>
                                <input  class="span4" type="text" placeholder="E-mail" name="email" value="" />
                                <textarea type="text" placeholder="Message" id="comment" name="blogContent" rows="5" style="width:98%"></textarea><br>
                                <button name="submit" id="submit_form" type="submit"  class="btn btn-small">Post comment</button>
                                    
                                <input type="hidden" name="SourceForm" value="BlogComment">
                                <input type="hidden" name="ajax" value="1">
                                <!--<input type="hidden" name="goto" value="<?php echo $SITE_LOC_PATH.'/'.$pageType.'/thank-you/';?>">-->
                                <input type="hidden" value="<?php echo $selData['blogId'];?>" class="buttons" name="blogId" />
                                <input type="hidden" value="<?php echo $selData['categoryId'];?>" class="buttons" name="categoryId" />
                                <input type="hidden" value="<?php echo $selData['blogTitle'];?>" class="buttons" name="blogTitle" />    
                                    
                                <div class="errMsg clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
            <?php include TMPL_PATH.'/inc/sidebar.php';?>            
        </div>
     </div>
 </div> 

