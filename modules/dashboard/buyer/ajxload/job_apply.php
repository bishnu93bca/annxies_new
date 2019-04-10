<?php 
$jObj = new JobsView();
$job = $jObj->getJobBypublicId($_SESSION['FUSERID'], $jpublicId);
if($job){
    ?>
    <div class="post_form">
        <div class="sp_box clearfix">										
            <figure class="sj_pic">
                <a href="<?php echo $SITE_LOC_PATH.'/jobs/'.$job['publicId'].'/';?>">
                <?php
                if($job['companyLogo'] && file_exists($MEDIA_FILES_ROOT.'/jobs/thumb/'.$job['companyLogo']))
                    echo '<img src="'.$MEDIA_FILES_SRC.'/jobs/thumb/'.$job['companyLogo'].'"  alt="'.$job['companyName'].'"> ';
                else
                    echo '<img src="'.$STYLE_FILES_SRC.'/images/noimage.png" alt="'.$job['companyName'].'"> ';
                ?>
                </a>
            </figure>
            <div class="sj_right">
                <?php
                if($_SESSION['FUSERID']==$job['favouriteBy'] && $job['favouriteBy'])
                    echo '<span class="wish fav"><i class="fa fa-heart-o"></i></span>';
                else
                    echo '<span class="wish"><i class="fa fa-heart-o"></i></span>';
                ?>

                <div class="subheading"><a href="<?php echo $SITE_LOC_PATH.'/jobs/'.$job['publicId'].'/';?>"><?php echo $job['jobTitle'];?></a></div>
                <strong class="orange"><?php echo $job['companyName']; echo ($job['location'])? ', '.$job['location']:'';?></strong>

                <?php if($job['skills']) {?>
                <div><span class="orange">Skills:</span> <?php echo $job['skills'];?></div>
                <?php }?>
            </div>
        </div>
        
        <?php 
        if($job['appliedBy'] == $_SESSION['FUSERID'] )
            echo 'You\'ve already applied for this job on '.date('jS F, Y', strtotime($job['appliedOn'])).'.';
        else{
        ?>

        <form id="aplfrm" method="post" action="" enctype="multipart/form-data">
            <ul>
                <li>
                    <span class="plabel">Your Name</span>
                    <div class="pf_right">
                        <input type="text" autocomplete="off" name="fullname" value="<?php echo $_SESSION['FUSERFULLNAME'];?>">
                    </div>                                      
                </li>

                <li>
                    <span class="plabel">Cover Letter</span>
                    <div class="pf_right">
                        <textarea name="coverLetter"></textarea>
                    </div>                                      
                </li>

                <li>
                    <span class="plabel">Your Resume</span>
                    <div class="pf_right">
                        <div class="file_upload">
                            <label class="inputfile">
                                <em>Choose file</em>
                                <input type="file" class="file" accept=
".doc, .docx, .pdf" name="cvFile" style="display: none;">
                            </label>
                            <input type="text" readonly="" placeholder="No file choosen">
                        </div>
                        <div class="help_text lr mt10">(Your file size should be 2 MB Max. Upload .doc or .docx or .pdf only)</div>
                    </div> 
                    
                </li>

                <li>
                    <div class="btn_pr">
                        <button type="submit" class="btn">
                            <i class="fa fa-file-text-o"></i> Apply
                        </button>

                        <input type="hidden" name="SourceForm" value="JApl">
                        <input type="hidden" name="ajax" value="1">

                        <input type="hidden" name="jpublicId" value="<?php echo $jpublicId;?>">

                    </div>
                </li>
            </ul>
        </form>
        <?php }?>
    </div>
    <?php
}
else
    $siteObj->redirectTo404($SITE_LOC_PATH);
?>