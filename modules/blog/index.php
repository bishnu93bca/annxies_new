<?php
$tbj         = new Post();	
$objComment  = new Comment();
if($dtls)
    include 'blog-details.php';
else
{    
    $ExtraQryStr = "blogType='P'"; 
    $blogData    = $tbj->getPostByLimit($ExtraQryStr, 0, 999);
    ?>
    <div class="tag_line">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="welcome"> 
                         <h2><strong class="colored">ANNEXIS:- </strong> 
                        <strong>Virtual Office</strong> anywhere in America.</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main_content_area annexisbusinessbg">
         <div class="container">
             <div class="row" id="margin-top">
                <div class="span8">
                    <?php 
                    foreach($blogData as $blData)
                    {                    
                        $ExtraQryCm =  "blogType='C' and status='Y' ";
                        $cmtData    =  $objComment->getComment($ExtraQryCm,$blData['blogId']);
                        if(sizeof($cmtData)>1)
                            $cmt='Comments';
                        else 
                            $cmt='Comment';
                        ?>
                        <div class="row" style="margin-bottom:50px;">
                            <!--POST TEXT-->
                            <div class="span8">
                                <div class="blog_item">
                                    
                                    <?php                    
                                    if(file_exists($MEDIA_FILES_ROOT.'/blog/thumb/'.$blData['blogImage']) && $blData['blogImage']){
                                        echo '<div class="blog_img"><a href="'.$SITE_LOC_PATH.'/'.$pageType.'/blog-news/'.$blData['permalink'].'/" title="'.$blData['blogTitle'].'">';
                                            echo '<img src="'.$MEDIA_FILES_SRC.'/blog/thumb/'.$blData['blogImage'].'" alt="'.$blData['blogTitle'].'"/>';
                                        echo '</a></div>';
                                    }
                                    ?>

                                    <div class="blog_post_item_description">
                                        <div class="blog_head blog_inner">
                                            <?php echo '<h4><a href="'.$SITE_LOC_PATH.'/'.$pageType.'/blog-news/'.$blData['permalink'].'/">'.$blData['blogTitle'].'</a></h4>';?>
                                            <div class="meta">
                                                <?php echo '<span><b>By</b> <a href="'.$SITE_LOC_PATH.'/'.$pageType.'/blog-news/'.$blData['permalink'].'/">'.$blData['blogAuthor'].'</a></span>';?>

                                                <?php echo (sizeof($cmtData)>0)? '<span class="last-item"><a href="'.$SITE_LOC_PATH.'/'.$pageType.'/blog-news/'.$blData['permalink'].'/">'.sizeof($cmtData).' '.$cmt.'</a></span>':'';?>
                                            </div>
                                        </div>        
                                        <p><?php echo $blData['shortDescription'];?></p>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <?php
                    }
                    echo '</div>';
                    include TMPL_PATH.'/inc/sidebar.php';
                    ?>
            </div>
         </div>
     </div> 
    <?php
}
?>