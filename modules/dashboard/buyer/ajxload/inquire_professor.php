<?php 
$pfObj      = new ProfessorsView;  
$professor  = $pfObj->getProfessorsInfoBypermalink($_SESSION['FUSERID'], $track);
if($professor){
    ?>
    <div class="post_form">
        <div class="sp_box inq_box clearfix">										
            
            <figure class="sj_pic">  
                <a href="<?php echo $SITE_LOC_PATH.'/professors/'.$professor['publicKey'];?>">
                <?php
                if($professor['photo'] && file_exists($MEDIA_FILES_ROOT.'/professors/large/'.$professor['photo']))
                    echo '<img src="'.$MEDIA_FILES_SRC.'/professors/large/'.$professor['photo'].'"  alt="'.$professor['professorName'].'"> ';
                else
                    echo '<img src="'.$STYLE_FILES_SRC.'/images/male.png"  alt="'.$professor['professorName'].'"> ';
                 ?>
                </a>
            </figure>
            
            
            
            <div class="sj_right">
                <?php
                if($_SESSION['FUSERID']==$professor['favouriteBy'] && $professor['favouriteBy'])
                    echo '<span class="wish fav"><i class="fa fa-heart-o"></i></span>';
                else
                    echo '<span class="wish"><i class="fa fa-heart-o"></i></span>';
                ?>

                <div class="subheading">
                    <a href="<?php echo $SITE_LOC_PATH.'/professors/'.$professor['publicKey'];?>">
                    <?php echo $professor['professorName'];?></a>
                </div>
                <strong class="orange"><?php echo $professor['qualification'];?></strong>


                <div><?php echo $professor['collegeName'];?></div>

            </div>
        </div>
        
        
        <form id="prfinqfrm" method="post" action="">
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

                        <input type="hidden" name="SourceForm" value="PrfInq">
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