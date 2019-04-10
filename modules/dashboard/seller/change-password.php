<div class="fav_details myProfile">
    <div class="form_wrap">
        <form action="" method="post" id="change_password_form">
            <div class="information">Password must be at least 8 characters and needs 1 capital, 1 non-capital, 1 digit.</div>
            <ul class="clearfix">
                <li>
                    <label>Current Password <span class="red">*</span></label>
                    <input type="password" required name="currpassword"/>
                </li>
                <li>
                    <label>New Password <span class="red">*</span></label>
                    <input type="password" required name="password"/>
                </li>
                <li>
                    <label>Confirm Password </label>
                    <input type="password" required name="new_password">
                </li>
                
                <li>
                    <div class="form_right">
                        <button type="submit" class="btn btn_orange upldsbmt"><i class="fa fa-floppy-o"></i> Update</button>
                    </div>
                </li>
            </ul>
            <input type="hidden" name="ajax" value="1">
            <input type="hidden" value="ChangePassword" name="SourceForm">
        </form>
    </div>
</div>