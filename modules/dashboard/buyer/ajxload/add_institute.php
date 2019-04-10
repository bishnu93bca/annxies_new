<?php   
$eduCount    = $eObj->memberEducationCount($_SESSION['FUSERID']);
if($eduCount<20 || ($dtaction == 'edit-education' && $edu) || ($dtaction == 'delete-education' && $edu)) {

    if(($dtaction == 'edit-education' && $edu) || ($dtaction == 'delete-education' && $edu)){
        $eduData        = $eObj->getMemberEducationByeducationId($_SESSION['FUSERID'], $edu);
        $instituteName  = $eduData['instituteName'];
        $fromYear       = $eduData['fromYear'];
        $toYear         = $eduData['toYear'];
        $education      = $eduData['education'];
        $track          = $eduData['permalink'];
        if($dtaction == 'edit-education')
            $subHeading = 'Edit Education';
        else
            $subHeading = 'Edit / Remove Education';
    }
    else
        $subHeading = 'Add Education';
    ?>
    <div class="post_form">
        <div class="sp_box inq_box clearfix">	
            <div class="subheading"><?php echo $subHeading;?></div>
        </div>
        <form id="insfrm" method="post" action="">
            <ul>
                <li>
                    <span class="plabel">Institution</span>
                    <div class="pf_right autosuggest">
                        <input type="text" autocomplete="off" data-act="institution" <?php if($dtaction == 'delete-education') echo 'readonly';?> required class="suggest" name="instituteName" value="<?php echo $instituteName;?>">
                        <div class="autosearch"></div>
                        <input type="hidden" name="track" class="track" value="<?php echo $track;?>">
                    </div>                                      
                </li>

                <li>
                    <span class="plabel">Time Duration</span>
                    <div class="pf_right">
                        <select class="edu_duration" name="fromYear" required>
                            <option value="">Year</option>
                            <?php
                            for($yr = 1950; $yr<(date('Y')+1); $yr++){
                                echo '<option value="'.$yr.'" '.(($fromYear == $yr)? 'selected':'').'>'.$yr.'</option>';
                            }
                            ?>
                        </select>
                        
                        <span class="edu_to">to</span>
                        
                        <select class="edu_duration" name="toYear" required>
                            <option value="">Year</option>
                            <?php
                            for($yr = 1950; $yr<(date('Y')+1); $yr++){
                                echo '<option value="'.$yr.'" '.(($toYear == $yr)? 'selected':'').'>'.$yr.'</option>';
                            }
                            ?>
                        </select>
                    </div>                                      
                </li>
                
                
                <li>
                    <span class="plabel">Degree / Certification</span>
                    <div class="pf_right">
                        <div class="small_radio">
                            <label class="radio">
                                <input name="education" value="Secondary (10th)" <?php echo ($education == 'Secondary (10th)')? 'checked':'';?> type="radio">
                                <em></em>
                                <span>Secondary (10th)</span>
                            </label>
                            <label class="radio">
                                <input name="education" value="Higher Secondary (12th)" <?php echo ($education == 'Higher Secondary (12th)')? 'checked':'';?> type="radio">
                                <em></em>
                                <span>Higher Secondary (12th)</span>
                            </label>
                            <label class="radio">
                                <input name="education" checked value="Graduation" <?php echo ($education == 'Graduation')? 'checked':'';?> type="radio">
                                <em></em>
                                <span>Graduation</span>
                            </label>
                            <label class="radio">
                                <input name="education" value="Post Graduation" <?php echo ($education == 'Post Graduation')? 'checked':'';?> type="radio">
                                <em></em>
                                <span>Post Graduation</span>
                            </label>
                            <label class="radio">
                                <input name="education" value="Doctorate" <?php echo ($education == 'Doctorate')? 'checked':'';?> type="radio">
                                <em></em>
                                <span>Doctorate</span>
                            </label>
                            <?php if($dtaction == 'delete-education') {?>
                            
                            <span class="or left"><em>or</em></span>
                            
                            <label class="radio">
                                <input name="education" value="RM" type="radio">
                                <em></em>
                                <span>Remove <?php echo $instituteName;?> </span>
                            </label>
                            
                            <?php } ?> 
                            
                        </div>	
                    </div>                                      
                </li>

                <li>
                    <div class="btn_pr">
                        <button type="submit" class="btn">
                            Save
                        </button>

                        <input type="hidden" name="SourceForm" value="AEdu">
                        <input type="hidden" name="ajax" value="1">
                        <input type="hidden" name="IdToEdit" value="<?php echo $edu;?>">
                    </div>
                </li>
            </ul>
        </form>
            
    </div>
    <?php
}
else
    echo 'error>Reached maximum limit. Please contact administrator.';
?>