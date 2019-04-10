<script>
$(function() {    
     $(document).ready( function() {
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            minDate: '0'
        });
    });    
    
    $('.expectedDate').hide();    
    $('.sendStatus').change(function(){
        var status = $(this).val();
        if(status=='Approved' || status=='Shipped')
            $('.expectedDate').show();  
       else
           $('.expectedDate').hide();   
    });
    $('.sendStatus').trigger('change');
    
});   
</script>

<?php
$mobj   = new MemberAdmin();
$cobj   = new adminCategory();

$ExtraQryStr=" 1 ";

if($contactID!='')
{
	$fetch_details = $mobj->sampleRequestbyId($contactID);
	$IdToEdit      = $fetch_details['contactID'];
	$userId        = $fetch_details['userId'];
	$name          = $fetch_details['name'];
	$email         = $fetch_details['email'];
	$phone         = $fetch_details['phone'];
	$address       = $fetch_details['address'];
	$country       = $fetch_details['country'];
	$state         = $fetch_details['state'];
	$city          = $fetch_details['city'];
	$zip           = $fetch_details['zip'];
	$sid           = $fetch_details['sid'];
	$sname         = $fetch_details['sname'];
	$ssurname      = $fetch_details['ssurname'];
	$semail        = $fetch_details['semail'];
	$sphone        = $fetch_details['sphone'];
	$saddress      = $fetch_details['saddress'];
	$scountry      = $fetch_details['scountry'];
	$sstate        = $fetch_details['sstate'];
	$scity         = $fetch_details['scity'];
	$szip          = $fetch_details['szip'];
	$productName   = $fetch_details['product'];
	$companyNm     = $fetch_details['company'];
	$productId     = $fetch_details['proId'];
	$unitType      = $fetch_details['unitType'];
	$description   = $fetch_details['description'];
	$productImage  = $fetch_details['productImage'];	
	$qty           = $fetch_details['qty'];	
	$currency      = $fetch_details['currency'];	
	$price         = $fetch_details['price'];	
	$productImage  = $fetch_details['p_photo'];	
	$categoryId    = $fetch_details['p_category'];	
	$totalQty      = $fetch_details['totalQty'];	
	$sampleId      = $fetch_details['sampleId'];	
	$sendStatus    = $fetch_details['sendStatus'];	
	$requestId     = $fetch_details['requestId'];	
	$expectedDate  = $fetch_details['expectedDate'];	
    
    $cData         = $cobj->getAttributeByCategoryId(1, $categoryId, 0, 999999);
    $scountry      = $mobj->stateBycode($scountry);
}
$menu=new menu();
$menudata= $menu -> menu_by_id($_REQUEST['moduleId']);
if($menudata)
{
	$menu_image = $menudata['menu_image'];
	$menu_name = $menudata['menu_name'];
	$parentMenuId = $menudata['parent_id'];
	$parentmenudata= $menu -> menu_by_id($parentMenuId);
	$parent_menu_name = $parentmenudata['menu_name'];
}
?>
    <ul id="breadcrumb">
        <li><a href="#"><?php echo $menu_name;?><span>→</span></a></li>
        <li><a href="#"><?php echo $parent_menu_name;?></a></li>
        <?php if($editid) {?>
        <li>
            <div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add New</a></div>
        </li>
        <?php	}?>
    </ul>
<?php
echo $ErrMsg;
if($contactID)
{
    ?>      
        <form name="modifycontent" action="" method="post" enctype="multipart/form-data">
            <div class="form_left">
                <div class="form_holder">
                    
                    <p class="description-line1">
                        Request ID: <?php echo $requestId;?>
                        <input type="hidden" name="requestId" value="<?php echo $requestId;?>">
                    </p>    
                    
                    <fieldset><legend>Buyer Info</legend>
                        <div class="input_left">
                            <p class="description-line1">Name </p>
                            <p class="description-line1">
                                <input name="name" type="text" value="<?php echo $name;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_right">
                            <p class="description-line1">Email </p>
                            <p class="description-line1">
                                <input name="email" type="text" value="<?php echo $email;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_left">
                            <p class="description-line1">Phone </p>
                            <p class="description-line1">
                                <input name="phone" type="text" value="<?php echo $phone;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_right">
                            <p class="description-line1">Address </p>
                            <p class="description-line1">
                                <input name="address" type="text" value="<?php echo $address;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_left">
                            <p class="description-line1">State of origin </p>
                            <p class="description-line1">
                                <input name="country" type="text" value="<?php echo $country;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_right">
                            <p class="description-line1">State </p>
                            <p class="description-line1">
                                <input name="state" type="text" value="<?php echo $state;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_left">
                            <p class="description-line1">City </p>
                            <p class="description-line1">
                                <input name="city" type="text" value="<?php echo $city;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_right">
                            <p class="description-line1">Zip </p>
                            <p class="description-line1">
                                <input name="zip" type="text" value="<?php echo $zip;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                    </fieldset>
                    
                    <fieldset><legend>Sample Request</legend>                        
                        <div class="input_left">
                            <p class="description-line1">Image </p>
                            <p class="description-line1">
                                <?php
                                if(file_exists($MEDIA_FILES_ROOT.'/product/thumb/'.$productImage) && $productImage)
                                {
                                    echo '<img src="'.$MEDIA_FILES_SRC.'/product/thumb/'.$productImage.'" height="100" width="100" alt="" />';
                                }
                                elseif(file_exists($MEDIA_FILES_ROOT.'/sample/thumb/'.$productImage) && $productImage)
                                {
                                    echo '<img src="'.$MEDIA_FILES_SRC.'/sample/thumb/'.$productImage.'" height="100" width="100" alt="" />';
                                }
                                else{
                                     echo '<img src="'.TMP.'/images/noimage.jpg" height="100" width="100" alt="" />';
                                }
                                ?>
                            </p>
                        </div>
                        <div class="input_right">
                            <p class="description-line1">Product </p>
                            <p class="description-line1">
                                <input name="productName" type="text" value="<?php echo $productName;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="clear"></div>
                        <div class="">
                            <?php
                            if($categoryId)
                                include("category_attr.php");
                            ?>
                        </div> 
                        <div class="clear"></div>     
                        <div class="" style="width:20%;float:left; margin-right:10px;">
                            <p class="description-line1">Quantity (<?php echo $unitType;?>)</p>
                            <p class="description-line1">
                                <input name="qty" type="text" class="qty_input" value="<?php echo $qty;?>" size="30" maxlength="100" />
                            </p>     
                        </div>
                        <div class="" style="width:20%;float:left; margin-right:10px;">
                            <p class="description-line1">Order Value</p>
                            <p class="description-line1">
                                <input name="price" class="qty_input" type="text" value="<?php echo $price;?>" size="30" maxlength="100" />
                            </p>     
                        </div>
                        <div class="" style="width:20%;float:left;">
                            <p class="description-line1">Currency </p>
                            <select name="currency" id="currency">   
                                <option value="">Currency</option>
                                <option value="USD" <?php echo ($currency=='USD')? 'selected':'';?>> USD </option>
                                <option value="GBP" <?php echo ($currency=='GBP')? 'selected':'';?>> GBP </option>
                                <option value="RMB" <?php echo ($currency=='RMB')? 'selected':'';?>> RMB </option>
                                <option value="EUR" <?php echo ($currency=='EUR')? 'selected':'';?>> EUR </option>
                                <option value="AUD" <?php echo ($currency=='AUD')? 'selected':'';?>> AUD </option>
                                <option value="CAD" <?php echo ($currency=='CAD')? 'selected':'';?>> CAD </option>
                                <option value="CHF" <?php echo ($currency=='CHF')? 'selected':'';?>> CHF </option>
                                <option value="JPY" <?php echo ($currency=='JPY')? 'selected':'';?>> JPY </option>
                                <option value="HKD" <?php echo ($currency=='HKD')? 'selected':'';?>> HKD </option>
                                <option value="NZD" <?php echo ($currency=='NZD')? 'selected':'';?>> NZD </option>
                                <option value="SGD" <?php echo ($currency=='SGD')? 'selected':'';?>> SGD </option>
                                <option value="Other" <?php echo ($currency=='Other')? 'selected':'';?>>Other </option>
                          </select> 
                        </div>  
                    </fieldset>

                    <fieldset><legend>Seller Information</legend>
                        <div class="input_left">
                            <p class="description-line1">Name </p>
                            <p class="description-line1">
                                <input name="sname" type="text" value="<?php echo $sname.' '.$ssurname;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_right">
                            <p class="description-line1">Email </p>
                            <p class="description-line1">
                                <input name="semail" type="text" value="<?php echo $semail;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_left">
                            <p class="description-line1">Phone </p>
                            <p class="description-line1">
                                <input name="sphone" type="text" value="<?php echo $sphone;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_right">
                            <p class="description-line1">Address </p>
                            <p class="description-line1">
                                <input name="saddress" type="text" value="<?php echo $saddress;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_left">
                            <p class="description-line1">State of origin </p>
                            <p class="description-line1">
                                <input name="scountry" type="text" value="<?php echo $scountry['state'];?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_right">
                            <p class="description-line1">State </p>
                            <p class="description-line1">
                                <input name="sstate" type="text" value="<?php echo $sstate;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_left">
                            <p class="description-line1">City </p>
                            <p class="description-line1">
                                <input name="scity" type="text" value="<?php echo $scity;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_right">
                            <p class="description-line1">Zip </p>
                            <p class="description-line1">
                                <input name="szip" type="text" value="<?php echo $szip;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                        <div class="input_left">
                            <p class="description-line1">Inventory </p>
                            <p class="description-line1">
                                <input name="totalQty" style="width:20%;float:left; margin-right:10px;" type="text" value="<?php echo $totalQty;?>" size="30" maxlength="100" readonly/>
                            </p>
                        </div>
                    </fieldset>
                </div>
                
                <div class="clear"></div>
                
            </div>
            
            <div class="status_right">     
                <div class="form_holder">    
                    <p class="description-line1">Status </p>
                    <p class="description-line1">
                        <select name="sendStatus" class="sendStatus" style="width:auto;">
                            <option value="Pending" <?php if($sendStatus=='Pending') echo 'selected';?>>Pending</option>
                            <option value="Request to Proceed" <?php if($sendStatus=='Requested to Proceed') echo 'selected';?>>Requested to Proceed</option>
                            <option value="Cancel" <?php if($sendStatus=='Cancel') echo 'selected';?>>Cancel</option>
                            <option value="Approved" <?php if($sendStatus=='Approved') echo 'selected';?>>Approved</option>
                            <option value="Shipped" <?php if($sendStatus=='Shipped') echo 'selected';?>>Shipped</option>
                            <option value="Deliverd" <?php if($sendStatus=='Deliverd') echo 'selected';?>>Deliverd</option>
                        </select>
                    </p>                      
                </div>
                <div class="form_holder expectedDate">    
                    <p class="description-line1">Expected Delivery Date </p>
                    <p class="description-line1 odd_Event" style="position:relative;">
                        <input id="" name="expectedDate" type="text" class="datepicker" value="<?php echo ($expectedDate>1)? date('d-m-Y',strtotime($expectedDate)):'';?>" size="70" style="width: 55%;"/>
                    </p>        
                </div>
            </div>
             <div class="clear"></div>
            <div class="form_holder">
                <input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />
                <input type="hidden" name="userId" value="<?php echo $userId;?>"/>
                <input type="hidden" name="sampleId" value="<?php echo $sampleId;?>"/>
                <input type="hidden" name="productId" value="<?php echo $productId;?>"/>
                <input type="hidden" name="sellerId" value="<?php echo $sid;?>"/>
                <input name="page" type="hidden" value="<?php echo $page; ?>" />
                <input name="SourceForm" type="hidden" value="SendSample" />
                <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                <input name="Save" type="submit" class="save_frm" value="Save" />
                <input name="Cancel" type="button" onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $_REQUEST['moduleId'];?>'" class="save_frm" value="Close" />
            </div>
        </form>

        <br class="clear" />
        <?php 
}
else{
    ?>
    <div class="table">
            <ul class="table_customer">
                <li style="text-align:center; line-height:30px;">No Record Present</li>
        </ul>
    </div>
    <?php
}
?>
