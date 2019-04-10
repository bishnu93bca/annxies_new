

<div class="h-box-100">
    <div class="h-heading">Account settings</div>

    <div id="succ"></div> 
    
    <div class="col-md-12">  
        <div class="row">
            <form id="user_form" enctype="multipart/form-data"  method="post">
            
                <div class="col-md-6">
                    <div class="form-group name">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" required="" value="<?php echo $planData['name'];?>">
                    </div>
                    <div class="form-group surname">
                        <label for="exampleInputEmail1">Profile Image</label>
                        <div style="width: 101px;height: 101px;border-style: solid;" class="profileDiv">
                       
                        <img alt="your image" src="http://www.annexis.net/uploadedfiles/member/thumb/<?php echo $planData['profilePic']?>" class= "profilePreview" style="width: 100px; height: 100px;padding-bottom: 5px;
    padding-right: 5px;">
                         </div>
                        <input type="file" name="profilePic"  class="profilePicUpload" id="profilePic" value="<?php echo $planData['profilePic']?>">
                      
                        </div>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Company</label>
                        <input type="text" name="company" id="company" class="form-control" placeholder="Company" required="" value="<?php echo $data['companyname'];?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Company Address</label>
                        <input type="text" name="companyAddress" id="companyAddress" class="form-control" placeholder="Company Address" required="" value="<?php echo $data['company_address'];?>">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">State of origin</label>
                        <select name="country" id="country" class="form-control">
                            <?php echo $eObj->readcountry($planData['country']);?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">State</label>
                        <input type="text" name="state" id="state" class="form-control" placeholder="State" required="" value="<?php echo $planData['state'];?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">City</label>
                        <input type="text" name="city" id="city" class="form-control" placeholder="City" required="" value="<?php echo $planData['city'];?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Pin Code</label>
                        <input type="text" name="zip" id="zip" class="form-control" placeholder="Pin Code" required="" value="<?php echo $planData['zip'];?>">
                    </div>
                     
                    <div class="form-group ">
                        <label for="exampleInputPassword1">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" required="" value="<?php echo $planData['phone'];?>">
                    </div>
                    <div class="form-group ">
                        <label for="exampleInputPassword1">2nd Phone</label>
                        <input type="text" name="new_phone" id="phone2" class="form-control" placeholder="2nd Phone"  value="<?php echo $planData['new_phone'];?>">
                    </div>
                </div><!-- end col-md-6 -->
                <hr style="margin: 0 0;">
                  <div class="h-heading">Email Section </div>
                     <div class="col-md-12">

                    <div class="form-group email">
                        <label for="exampleInputEmail1">Email <span class="email_check text-danger"></span></label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required="" value="<?php echo $planData['email'];?>" >
                    </div>
                    <div class="form-group email">
                        <label for="exampleInputEmail1">Email 2<span class="email_check text-danger"></span></label>
                        <input type="new_email" name="new_email" id="new_email" class="form-control" placeholder="Email"  value="<?php echo $planData['new_email'];?>" >
                    </div>
                    <div class="form-group email">
                        <label for="exampleInputEmail1">Website Address <span class="email_check text-danger"></span></label>
                        <input type="website" name="website" id="website" class="form-control" placeholder="Website"  value="<?php echo $data['url'];?>">
                    </div>
                    </div>
                    <hr style="margin: 0 0;">
                    <div class="h-heading">Password Section </div>
                    <div class="col-md-12">
                        
                    <div class="form-group password">
                        <label for="exampleInputPassword1">Old password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" >
                    </div><!-- end col-md-6 -->
                    <div class="form-group password">
                        <label for="exampleInputPassword2">New password</label>
                        <input type="password" name="newpassword" id="newpassword" class="form-control" placeholder="Password" >
                    </div><!-- end col-md-6 -->      
                    <div class="form-group password">
                        <label for="exampleInputPassword3">Retype password</label>
                        <input type="password" name="retypepassword" id="retypenewpassword" class="form-control" placeholder="Password" >
                    </div>
                    </div><!-- end col-md-6 --> 
               
                <div class="col-md-12 mb25">
                    <div class="">
                        <button type="submit" class="btn btn-primary btn-lg UpPrf" value="<?php echo $_SESSION['FUSERID'];?>">Save</button>     
                        <!--<button type="button" class="btn btn-primary btn-lg UpPrf" onclick="saveuser_acc(<?php echo $_SESSION['FUSERID'];?>)">Save</button>   -->  
                        <input type="hidden" name="uid" value="<?php echo $_SESSION['FUSERID'];?>">
                        <input type="hidden" name="ajax" value="1">
                        <input type="hidden" name="SourceForm" value="updateAccount">
                        <a href="http://www.annexis.net/dashboard/company/" class="btn btn-primary btn-lg" role="button">Next</a>     
                    </div>          
                    <div class="errMsg"></div>  
                </div>	
            </form>
        </div>
    </div>
</div>