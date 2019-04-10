<?php   
$member = $eObj -> getMemberById($_SESSION['FUSERID']);
if($member) {
    
    $countryData = $eObj -> getCountries();
    
    $subHeading = 'My Location';
    ?>
    <div class="post_form">
        <div class="sp_box inq_box clearfix">	
            <div class="subheading"><?php echo $subHeading;?></div>
        </div>
        <form id="insfrm" method="post" action="">
            <ul class="csc">
                <li>
                    <span class="plabel">Country</span>
                    <div class="pf_right">
                        <select id="country" name="country" required>
                            <option value="">--Select--</option>
                            <?php
                            foreach($countryData as $country) {
                                echo '<option value="'.$country['id'].'" '.(($_SESSION['FUSERCOUNTRY'] == $country['name'])? 'selected':'').'>'.$country['name'].'</option>';
                            }
                            ?>
                        </select>                        
                    </div>                                      
                </li>
                
                <li>
                    <span class="plabel">State</span>
                    <div class="pf_right">
                        <select id="state" name="state" required>
                            <option value="">--Select--</option>
                            
                        </select>                        
                    </div>                                      
                </li>
                
                <li>
                    <span class="plabel">City</span>
                    <div class="pf_right">
                        <select id="city" name="city" required>
                            <option value="">--Select--</option>
                        </select>                        
                    </div>                                      
                </li>
                

                <li>
                    <div class="btn_pr">
                        <button type="submit" class="btn">
                            Save
                        </button>

                        <input type="hidden" name="SourceForm" value="UMLoc">
                        <input type="hidden" name="ajax" value="1">
                    </div>
                </li>
            </ul>
        </form>
            
    </div>
    <?php
}
else
    echo 'error>Something went wrong. Please close window and try again.';
?>