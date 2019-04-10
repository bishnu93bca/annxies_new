<?php
$eduData = $eObj->getMemberEducation($_SESSION['FUSERID'], 0, 10);
?>

<div class="fav_details myProfile">
    <div class="profile_setting">
        <ul class="clearfix">
            <li>
                <div class="subheading">Name:</div>
                <div class="setting_info">
                    <div class="updt_wrap">
                        <span><?php echo $_SESSION['FUSERFULLNAME'];?></span>
                        <input type="text" required value="<?php echo $_SESSION['FUSERFULLNAME'];?>" class="setting_input">
                    </div>
                    <div class="setting_action">
                        <a href="javascript:void(0);" class="edit_setting"><i class="fa fa-pencil"></i> Edit</a>
                        <a href="javascript:void(0);" data-update="fullname" class="btn btn_small save_setting">Save</a>
                        <a href="javascript:void(0);" class="btn btn_small btn_action cancel_setting">Cancel</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="subheading">Email:</div>
                <div class="setting_info">
                    <div class="updt_wrap">
                        <span><?php echo $_SESSION['FUSEREMAIL'];?></span>
                    </div>
                    
                </div>
            </li>
            <li>
                <div class="subheading">Gender:</div>
                <div class="setting_info">
                    <div class="updt_wrap">
                        <span><?php echo $_SESSION['GENDER'];?></span>
                        <select class="setting_input">
                            <option value="">I am</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="setting_action">
                        <a href="javascript:void(0);" class="edit_setting"><i class="fa fa-pencil"></i> Edit</a>
                        <a href="javascript:void(0);" data-update="gender" class="btn btn_small save_setting">Save</a>
                        <a href="javascript:void(0);" class="btn btn_small btn_action cancel_setting">Cancel</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="subheading">Phone:</div>
                
                <div class="setting_info">
                    <div class="updt_wrap">
                        <span><?php echo $_SESSION['FUSERPHONE'];?></span>
                        <input type="text" required value="<?php echo $_SESSION['FUSERPHONE'];?>" class="setting_input">
                    </div>
                    <div class="setting_action">
                        <a href="javascript:void(0);" class="edit_setting"><i class="fa fa-pencil"></i> Edit</a>
                        <a href="javascript:void(0);" data-update="phone" class="btn btn_small save_setting">Save</a>
                        <a href="javascript:void(0);" class="btn btn_small btn_action cancel_setting">Cancel</a>
                    </div>
                </div>
            </li>
            
            <li>
                <div class="subheading">City:</div>
                <div class="setting_info">
                    <div class="updt_wrap">
                        <span><?php echo $_SESSION['FUSERCITY'];?></span>
                    </div>
                    <div class="setting_action">
                        <a href="javascript:void(0)" data-page="my-location" class="eloc"><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="subheading">State:</div>
                <div class="setting_info">
                    <div class="updt_wrap">
                        <span><?php echo $_SESSION['FUSERSTATE'];?></span>
                    </div>
                    <div class="setting_action">
                        <a href="javascript:void(0)" data-page="my-location" class="eloc"><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="subheading">Country:</div>
                <div class="setting_info">
                    <div class="updt_wrap">
                        <span><?php echo $_SESSION['FUSERCOUNTRY'];?></span>
                    </div>
                    
                    <div class="setting_action">
                        <a href="javascript:void(0)" data-page="my-location" class="eloc"><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="subheading">About Me:</div>
                
                <div class="setting_info">
                    <div class="updt_wrap">
                        <span><?php echo nl2br($_SESSION['FUSERABOUT']);?></span>
                        <textarea required class="setting_input"></textarea>
                    </div>
                    <div class="setting_action">
                        <a href="javascript:void(0);" class="edit_setting"><i class="fa fa-pencil"></i> Edit</a>
                        <a href="javascript:void(0);" data-update="aboutMe" class="btn btn_small save_setting">Save</a>
                        <a href="javascript:void(0);" class="btn btn_small btn_action cancel_setting">Cancel</a>
                    </div>
                </div>
            </li>
            
            <li>
                <div class="subheading">Education:</div>
                <div class="setting_info">
                    <div class="nedu"><span data-page="add-education" class="btn btn_small addedu">Add Education</span></div>
                </div>
                
                <?php
                if($eduData){
                    foreach($eduData as $edu){
                        ?>
                        <div class="setting_info edu_setting">
                            <?php
                            if($edu['photo'] && file_exists($MEDIA_FILES_ROOT.'/institutions/thumb/'.$edu['photo']))
                                $eduPhoto = $MEDIA_FILES_SRC.'/institutions/thumb/'.$edu['photo'];
                            else
                                $eduPhoto = $STYLE_FILES_SRC.'/images/noimage.png';
                            ?>
                            
                            <div class="friend_block"><figure class="profilePic"><a target="_blank" href="<?php echo $SITE_LOC_PATH.'/institution/'.$edu['permalink'].'/';?>" style="background-image: url(<?php echo $eduPhoto;?>)"></a></figure><div class="friend_text"><h3 class="subheading"><a target="_blank" href="<?php echo $SITE_LOC_PATH.'/institution/'.$edu['permalink'].'/';?>"><?php echo $edu['instituteName'];?></a></h3><span><?php echo $edu['education'].' ('.$edu['fromYear'].' ~ '.$edu['toYear'].')';?></span></div><div class="clear"></div></div>
                            
                            
                            <div class="setting_action">
                                <a href="#" class="eedu" data-page="edit" data-edu="<?php echo $edu['educationId'];?>"><i class="fa fa-pencil"></i> Edit</a>
                                <a href="#" class="dedu" data-page="delete" data-edu="<?php echo $edu['educationId'];?>"><i class="fa fa-trash"></i> Delete</a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                

            </li>
        </ul>
    </div>
    
</div>