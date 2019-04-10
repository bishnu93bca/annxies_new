<?php
$cobj    = new adminCategory();
$mobj    = new MemberAdmin;

$ExtraQryStr=" 1 ";
if($sampleId!='')
{
	$fetch_details = $mobj->sampleById($sampleId);
	$IdToEdit      = $fetch_details['sampleId'];
	$productId     = $fetch_details['proId'];
	$categoryId    = $fetch_details['proCid'];
	$sellerId      = $fetch_details['userId'];
	$productName   = $fetch_details['productName'];
	$p_keyword     = $fetch_details['p_keyword'];
	$description   = $fetch_details['description'];
	$productImage  = $fetch_details['productImage'];	
	$totalQty      = $fetch_details['totalQty'];	
	$qty           = $fetch_details['qty'];	
	$unitType      = $fetch_details['unitType'];	
	$currency      = $fetch_details['currency'];	
	$range1        = $fetch_details['range1'];	
	$range2        = $fetch_details['range2'];	
	$isApproved    = $fetch_details['isApproved'];	
	$sampleReqId   = $fetch_details['sampleReqId'];	
	$scurrency     = $fetch_details['scurrency'];	
	$setUp         = $fetch_details['setUp'];		
	$shippingCharge= $fetch_details['shippingCharge'];	
	$shippingCharge1= $fetch_details['shippingCharge1'];
	$sname         = $fetch_details['sname'];
	$ssurname      = $fetch_details['ssurname'];
	$semail        = $fetch_details['semail'];
	$sphone        = $fetch_details['sphone'];
	$saddress      = $fetch_details['saddress'];
	$scountry      = $fetch_details['scountry'];
	$sstate        = $fetch_details['sstate'];
	$scity         = $fetch_details['scity'];
	$szip          = $fetch_details['szip'];
}

if($editid){
    $scountry       = $mobj->stateBycode($scountry);
    $ctData         = $cobj->categoryById($categoryId);
    $cData          = $cobj->getAttributeByCategoryId(1, $categoryId, 0, 999999);
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
    </ul>
    <?php echo $ErrMsg;

if($sampleId)
{
    ?>      
        <form name="modifycontent" action="" method="post" enctype="multipart/form-data">
            <div class="form_left">
                <div class="form_holder">
                    <div class="input_left">
                        <p class="description-line1">Product Name </p>
                        <p class="description-line1">
                            <input name="productName" type="text" value="<?php echo $productName;?>" size="30" maxlength="100" readonly/>
                        </p>
                    </div>
                    <div class="input_right">
                        <p class="description-line1">Product Category </p>
                        <p class="description-line1">
                            <input name="p_keyword" type="text" value="<?php echo $ctData['category'];?>" size="30" maxlength="100" readonly/>
                        </p>
                    </div>
                    <div class="">
                        <?php
                        if($categoryId)
                            include("category_attr.php");
                        ?>
                    </div> 
                    <div class="clear"></div>
                    <div class="input_left">
                        <p class="description-line1">Image</p>
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
                        <p class="description-line1">Product Keyword </p>
                        <p class="description-line1">
                            <input name="p_keyword" type="text" value="<?php echo str_replace(",",", ",$p_keyword);?>" size="30" maxlength="100" readonly/>
                        </p>
                    </div>
                    
                    <div class="clear"></div>
                    <div class="" style="width:20%;float:left; margin-right:10px;">
                        <p class="description-line1">Quantity (<?php echo $unitType;?>)</p>
                        <p class="description-line1">
                            <input name="qty" type="text" value="<?php echo $qty;?>" size="30" maxlength="100" readonly/>
                        </p>     
                    </div>
                    <div>
                        <p class="description-line1">Price </p>                        

                        <input name="range1" id="range1" type="text" placeholder="From" value="<?php echo $range1;?>"  style="width:10%; display:inline-block;" readonly/> ~ 
                        <input name="range2" id="range2" type="text" placeholder="From" value="<?php echo $range2;?>"  style="width:10%; display:inline-block;" readonly/>


                        <input name="isApproved" id="isApproved" type="text" placeholder="Status" value="<?php echo $currency;?>"  style="width:100px; margin-right:5px; display:inline-block;" readonly/>
                    </div>
                    
                    <div class="clear"></div>
                    <p class="description-line1">Description </p>
                    <p class="description-line1">
                        <textarea name="description" style="height:80px;" readonly><?php echo $description;?></textarea>
                    </p>
                    
                </div>
                
                <div class="clear"></div>
                
                <div class="form_holder">
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
                </fieldset>
                
                </div>
                
            </div>
            
            <div class="status_right">
                <div class="form_holder">
                    <p class="description-line1">Status </p>
                    <p class="description-line1">
                        <input name="isApproved" id="isApproved" type="text" placeholder="Status" value="<?php echo $isApproved;?>"  style=" width:50%;float:left;" readonly/>
                    </p>		
                </div>	
                <div class="form_holder">      
                    <div class="" style="width:30%;float:left; margin-right:10px;">
                        <p class="description-line1">Set up fee </p>
                        <p class="description-line1">
                            <input name="shippingsetUpCharge" type="text" class="qty_input" value="<?php echo $setUp;?>" size="30" maxlength="100" readonly>
                        </p>     
                    </div>    
                    <div class="" style="width:36%;float:left; margin-right:10px;">
                        <p class="description-line1">Shipping deposit </p>
                        <p class="description-line1">
                            <input name="shippingCharge" type="text" class="qty_input" value="<?php echo $shippingCharge;?>" size="30" maxlength="100" readonly>
                        </p>     
                    </div>    
                    <div class="" style="width:36%;float:left; margin-right:10px;">
                        <p class="description-line1">Shipping deposit1 </p>
                        <p class="description-line1">
                            <input name="shippingCharge1" type="text" class="qty_input" value="<?php echo $shippingCharge1;?>" size="30" maxlength="100" readonly>
                        </p>     
                    </div>
                    <div class="" style="width:30%;float:left;">
                        <p class="description-line1">Currency </p>
                        <input name="scurrency" type="text" class="qty_input" value="<?php echo $scurrency;?>" size="30" maxlength="100" readonly>
                    </div>      
                    <div class="clear"></div>
                    <div class="" style="width:30%;float:left;">
                        <p class="description-line1">Total  </p>
                        <input name="scurrency" type="text" class="qty_input" value="<?php echo $setUp+$shippingCharge+
$shippingCharge1; echo ' '.$scurrency;?>" size="30" maxlength="100" readonly>
                    </div>  
                </div>
            </div>
             <div class="clear"></div>
            <div class="form_holder">
                <input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />
                <input name="sellerId" type="hidden" value="<?php echo $sellerId;?>" />
                <input name="productId" type="hidden" value="<?php echo $productId;?>" />
                <input name="sampleReqId" type="hidden" value="<?php echo $sampleReqId;?>" />
                <input name="page" type="hidden" value="<?php echo $page; ?>" />
                <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                <!--<input name="Save" type="submit" class="save_frm" value="Save" />-->
                <input name="SourceForm" type="hidden" value="Sample" />
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
