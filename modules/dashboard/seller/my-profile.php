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
        </ul>
    </div>
</div>