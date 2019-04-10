<?php 
$instObj      = new InstitutionView;  
$institute    = $instObj->getInstitutionsInfoBypermalink($_SESSION['FUSERID'], $track);
if($institute){
    ?>
    <div class="post_form">
        <div class="sp_box inq_box clearfix">										
            
            <figure class="sj_pic">  
                <a href="<?php echo $SITE_LOC_PATH.'/institution/'.$institute['permalink'];?>">
                <?php
                if($institute['photo'] && file_exists($MEDIA_FILES_ROOT.'/institutions/thumb/'.$institute['photo']))
                    echo '<img src="'.$MEDIA_FILES_SRC.'/institutions/thumb/'.$institute['photo'].'"  alt="'.$institute['instituteName'].'"> ';
                else
                    echo '<img src="'.$STYLE_FILES_SRC.'/images/noimage.png"  alt="'.$institute['instituteName'].'"> ';
                 ?>
                </a>
            </figure>
            
            
            
            <div class="sj_right">
                <?php
                if($_SESSION['FUSERID']==$institute['favouriteBy'] && $institute['favouriteBy'])
                    echo '<span class="wish fav"><i class="fa fa-heart-o"></i></span>';
                else
                    echo '<span class="wish"><i class="fa fa-heart-o"></i></span>';
                ?>

                <div class="subheading">
                    <a href="<?php echo $SITE_LOC_PATH.'/institutions/'.$institute['permalink'];?>">
                    <?php echo $institute['instituteName'];?></a>
                </div>
                <strong class="orange"><?php echo $institute['specialization'];?></strong>


                <div><?php echo $institute['address'];?></div>

            </div>
        </div>
        
        
        <form id="instinqfrm" method="post" action="">
            <ul>
                <li>
                    <span class="plabel">Your Name</span>
                    <div class="pf_right">
                        <input type="text" autocomplete="off" name="fullname" value="<?php echo $_SESSION['FUSERFULLNAME'];?>">
                    </div>                                      
                </li>

                <li>
                    <span class="plabel">Your Enquiry</span>
                    <div class="pf_right">
                        <textarea name="enquiry"></textarea>
                    </div>                                      
                </li>

                <li>
                    <div class="btn_pr">
                        <button type="submit" class="btn">
                            <i class=" fa fa-question-circle-o"></i> Submit
                        </button>

                        <input type="hidden" name="SourceForm" value="InstInq">
                        <input type="hidden" name="ajax" value="1">

                        <input type="hidden" name="track" value="<?php echo $track;?>">

                    </div>
                </li>
            </ul>
        </form>
            
    </div>
    <?php
}
else
    $siteObj->redirectTo404($SITE_LOC_PATH);
?>