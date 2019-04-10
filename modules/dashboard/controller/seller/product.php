<?php
$obj = new adminProductClass();
$cobj = new adminCategory();
$cObj    = new MemberAdmin;

$ExtraQryStr=" 1 ";
if($proId!='')
{
	$productId=$proId;
	$fetch_details =$obj->productById($proId);
	$IdToEdit = $fetch_details['id'];
	$categoryId = $fetch_details['p_category'];
	$p_name = $fetch_details['p_name'];
	$p_keyword = $fetch_details['p_keyword'];
	$p_subcategory = $fetch_details['p_subcategory'];
	$country = $fetch_details['country'];
	$p_photo = $fetch_details['p_photo'];
	$p_bdes = $fetch_details['p_bdes'];
	$p_ddes = $fetch_details['p_ddes'];
	$p_price = $fetch_details['p_price'];
	$range1 = $fetch_details['range1'];
	$range2 = $fetch_details['range2'];
	$paymenttype = $fetch_details['paymenttype'];
	$p_min_quanity = $fetch_details['p_min_quanity'];
	$p_quanity_type = $fetch_details['p_quanity_type'];
	$p_capaacity = $fetch_details['p_capaacity'];
	$p_ctype = $fetch_details['p_ctype'];
	$percapacity = $fetch_details['percapacity'];
	$range12 = $fetch_details['range12'];
	$p_delivertytime = explode(' ',$fetch_details['p_delivertytime']);
	$p_packingdetails = $fetch_details['p_packingdetails'];
	$expiredate = $fetch_details['expiredate'];
	$status = $fetch_details['status'];
	$lang_status = $fetch_details['lang_status'];
	$viewcount = $fetch_details['viewcount'];
	$groupname = $fetch_details['groupname'];
	$photo1 = $fetch_details['photo1'];
	$photo2 = $fetch_details['photo2'];
	$photo3 = $fetch_details['photo3'];
	$photo4 = $fetch_details['photo4'];
	$photo5 = $fetch_details['photo5'];		
}

if($editid){
	$cData    		= $cObj->getMemberInfoByid($editid);
	$id 			= $editid;
	$name 		    = $cData['name'];
	$surname 		= $cData['surname'];
	$email 		    = $cData['email'];
	$country 		= $cData['country'];
	$gender         = $cData['gender'];
	$aboutMe 		= $cData['aboutMe'];
	$phone 			= $cData['phone'];
	//$address 		= $cData['address'];
	$city 			= $cData['city'];
	$state 			= $cData['state'];
	$country 		= $cData['country'];
	$status 		= $cData['status'];
	$profilePic		= $cData['profilePic'];
    $company   		= $cObj->getCompanyInfoByuserid($id);
    $memberShip		= $cObj->getMembershipInfoByuserid($id);
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
        <?php /*if($editid) {?>
        <li>
            <div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add New</a></div>
        </li>
        <?php	}*/?>
    </ul>
    <?php echo $ErrMsg;
    if($editid){
        include("intro.php");
    }
if($proId)
{
    ?>      
        <form name="modifycontent" action="" method="post" enctype="multipart/form-data">
            <div class="form_left">
                <div class="form_holder">
                    <p class="description-line1">Category *</p>
                    <p class="description-line1">
                        <?php
                        $parentId = 0;
                        $data = $cobj -> getCategoryByparentId($parentId);
                        if($data)
                        { 
                            ?>
                            <select name="p_category" class="categoryId">
                                <option value="">--select--</option>
                                <?php
                                for($i=0; $i<sizeof($data); $i++)
                                {
                                    if($data[$i]['c_id']==$categoryId)
                                        echo '<option value="'.$data[$i]['c_id'].'" selected '.$active.'>'.$data[$i]['category'].'</option>';
                                    else
                                        echo '<option value="'.$data[$i]['c_id'].'"'.$active.'>'.$data[$i]['category'].'</option>';	
                                    $parentId = $data[$i]['c_id'];
                                    $nbsp = '';
                                    $selectedId = $categoryId;
                                    $cobj->recursiveCategory($parentId, '', $nbsp, $selectedId);
                                }	
                                ?>
                            </select>
                            <?php 
                        }
                        ?>
                    </p>
                    <div class="input_left">
                        <p class="description-line1">Product Name *</p>
                        <p class="description-line1">
                            <input name="p_name" type="text" value="<?php echo $p_name;?>" size="30" maxlength="100" />
                        </p>
                    </div>
                    <div class="input_right">
                        <p class="description-line1">Product Keyword *</p>
                        <p class="description-line1">
                            <input name="p_keyword" type="text" value="<?php echo $p_keyword;?>" size="30" maxlength="100" />
                        </p>
                    </div>
                    
                    <div class="clear"></div>
                    <p class="description-line1">Description </p>
                    <p class="description-line1">
                        <textarea name="p_bdes" style="height:140px;"><?php echo $p_bdes;?></textarea>
                    </p>
                    
                    
                    <div class="clear"></div>
                    <p class="description-line1">Description </p>
                    <p class="description-line1">
                        <textarea name="p_ddes" style="height:140px;"><?php echo $p_ddes;?></textarea>
                    </p>
                </div>
                
                <div class="clear"></div>
                <div class="form_holder">
                    <div class="">
                    <div class="multiImg">
                        <p class="description-line1">Product main image</p>
                        <p class="description-line1">
                            <input type="file" class="input2" name="p_photo" /><br />
                            <?php
                            if(file_exists($MEDIA_FILES_ROOT.'/product/thumb/'.$p_photo) && $p_photo)
                            {
                                echo '<img src="'.$MEDIA_FILES_SRC.'/product/thumb/'.$p_photo.'" height="100" width="100" alt="" />';
                            }
                            ?>
                        </p>
                    </div>
                    
                    <div class="multiImg">
                        <p class="description-line1">Product image 1</p>
                        <p class="description-line1">
                            <input type="file" class="input2" name="photo1" /><br />
                            <?php
                            if(file_exists($MEDIA_FILES_ROOT.'/product/thumb/'.$photo1) && $photo1)
                            {
                                echo '<img src="'.$MEDIA_FILES_SRC.'/product/thumb/'.$photo1.'" height="100" width="100" alt="" />';
                            }
                            ?>
                        </p>
                    </div>
                    
                    <div class="multiImg">
                        <p class="description-line1">Product image 2</p>
                        <p class="description-line1">
                            <input type="file" class="input2" name="photo2" /><br />
                            <?php
                            if(file_exists($MEDIA_FILES_ROOT.'/product/thumb/'.$photo2) && $photo2)
                            {
                                echo '<img src="'.$MEDIA_FILES_SRC.'/product/thumb/'.$photo2.'" height="100" width="100" alt="" />';
                            }
                            ?>
                        </p>
                    </div>
                    
                    <div class="multiImg">
                        <p class="description-line1">Product image 3</p>
                        <p class="description-line1">
                            <input type="file" class="input2" name="photo3" /><br />
                            <?php
                            if(file_exists($MEDIA_FILES_ROOT.'/product/thumb/'.$photo3) && $photo3)
                            {
                                echo '<img src="'.$MEDIA_FILES_SRC.'/product/thumb/'.$photo3.'" height="100" width="100" alt="" />';
                            }
                            ?>
                        </p>    
                    </div>
                    
                    <div class="multiImg">
                        <p class="description-line1">Product image 4</p>
                        <p class="description-line1">
                            <input type="file" class="input2" name="photo4" /><br />
                            <?php
                            if(file_exists($MEDIA_FILES_ROOT.'/product/thumb/'.$photo4) && $photo4)
                            {
                                echo '<img src="'.$MEDIA_FILES_SRC.'/product/thumb/'.$photo4.'" height="100" width="100" alt="" />';
                            }
                            ?>
                        </p>     
                    </div>
                    
                    <div class="multiImg">
                        <p class="description-line1">Product image 5</p>
                        <p class="description-line1">
                            <input type="file" class="input2" name="photo5" /><br />
                            <?php
                            if(file_exists($MEDIA_FILES_ROOT.'/product/thumb/'.$photo5) && $photo5)
                            {
                                echo '<img src="'.$MEDIA_FILES_SRC.'/product/thumb/'.$photo5.'" height="100" width="100" alt="" />';
                            }
                            ?>
                        </p>
                    </div>
                </div>                
                </div>
            </div>
            
            <div class="status_right">
                <div class="form_holder">

                    <div class="input_left">
                        <p class="description-line1">Status </p>
                        <p class="description-line1">
                            <select name="status" style="width:auto;">
                                <option value="1" <?php if($status=='1' || !$status) echo 'selected';?> >Active</option>
                                <option value="0" <?php if($status=='0') echo 'selected';?>>Inactive</option>
                                <!--<option value="C" <?php if($status=='C') echo 'selected';?>>Complementary</option>-->
                            </select>
                        </p>
                    </div>			
                </div>		
                  
                <div class="form_holder">
                    <div>
                        <p class="description-line1">Price </p>
                            <select name="p_price" id="p_price" class="form-control" style="width:120px; margin-right:5px; display:inline-block;">   
                                <option value="">Currency</option>
                                <option value="USD" <?php echo ($p_price=='USD')? 'selected':'';?>> USD </option>
                                <option value="GBP" <?php echo ($p_price=='GBP')? 'selected':'';?>> GBP </option>
                                <option value="RMB" <?php echo ($p_price=='RMB')? 'selected':'';?>> RMB </option>
                                <option value="EUR" <?php echo ($p_price=='EUR')? 'selected':'';?>> EUR </option>
                                <option value="AUD" <?php echo ($p_price=='AUD')? 'selected':'';?>> AUD </option>
                                <option value="CAD" <?php echo ($p_price=='CAD')? 'selected':'';?>> CAD </option>
                                <option value="CHF" <?php echo ($p_price=='CHF')? 'selected':'';?>> CHF </option>
                                <option value="JPY" <?php echo ($p_price=='JPY')? 'selected':'';?>> JPY </option>
                                <option value="HKD" <?php echo ($p_price=='HKD')? 'selected':'';?>> HKD </option>
                                <option value="NZD" <?php echo ($p_price=='NZD')? 'selected':'';?>> NZD </option>
                                <option value="SGD" <?php echo ($p_price=='SGD')? 'selected':'';?>> SGD </option>
                                <option value="Other" <?php echo ($p_price=='Other')? 'selected':'';?>>Other </option>
                            </select> 
                        <input name="range1" id="range1" type="text" placeholder="From" class="form-control" value="<?php echo $range1;?>"  style="width:50px; display:inline-block;"/> - 	
                        <input name="range2" id="range2" type="text" placeholder="To" class="form-control" value="<?php echo $range2;?>"  style="width:50px; display:inline-block;"/>
                    </div>			
                </div>		
                <div class="form_holder">
                    <div class="">
                        <p class="description-line1">Payment Terms*</p>
                        <label class="radioLabel">
                            <input name="paymenttype" id="pt1" value="L/C" type="radio" <?php echo ($paymenttype=='L/C')? 'checked':'';?>>
                            <span style="font-size:12">L/C</span>
                        </label>
                        <label class="radioLabel">
                            <input name="paymenttype" id="pt2" value="D/A" type="radio" <?php echo ($paymenttype=='D/A')? 'checked':'';?>>
                            <span style="font-size:12">D/A </span>
                        </label>
                        <label class="radioLabel">
                            <input name="paymenttype" id="pt3" value="D/P" type="radio" <?php echo ($paymenttype=='D/P')? 'checked':'';?>>
                            <span style="font-size:12">D/P</span>
                        </label>
                        <label class="radioLabel">
                            <input name="paymenttype" id="pt4" value="T/T" type="radio" <?php echo ($paymenttype=='T/T')? 'checked':'';?>>
                            <span style="font-size:12">T/T</span>
                        </label>
                        <label class="radioLabel">
                            <input name="paymenttype" id="pt5" value="Western Union" type="radio" <?php echo ($paymenttype=='Western Union')? 'checked':'';?>>
                            <span style="font-size:12">Western Union</span>
                        </label>
                        <label class="radioLabel">
                            <input name="paymenttype" id="pt6" value="MoneyGram" type="radio" <?php echo ($paymenttype=='MoneyGram')? 'checked':'';?>>
                            <span style="font-size:12">MoneyGram</span>
                        </label>
                        <label class="radioLabel">
                            <input name="paymenttype" id="pt7" value="" type="radio" <?php echo ($paymenttype=='Others')? 'checked':'';?>>
                            <span style="font-size:12"> Others</span>
                        </label> 
                    </div>                      
                </div>                      
                <div class="form_holder">    
                    <p class="description-line1">Quantity *</p>
                    <p class="description-line1"><input name="p_capaacity" type="text" value="<?php echo $p_capaacity;?>" size="30" maxlength="100" /></p>                      
                </div>
                <div class="form_holder"> 
                    <div>
                        <p class="description-line1">Production Capacity </p>
                        <input name="p_capaacity" type="text" value="<?php echo $p_capaacity;?>" size="30" maxlength="100"  class="form-control" style="width:60px; margin-right:5px; display:inline-block;"/>

                        <select name="p_ctype" id="p_ctype" class="form-control" style="width:125px; display:inline-block;">
                            <option value="">Select Unit Type</option>
                            <option value="Bag/Bags" <?php echo ($p_ctype=='Bag/Bags')? 'selected':'';?>>Bag/Bags </option>
                            <option value="Barrel/Barrels" <?php echo ($p_ctype=='Barrel/Barrels')? 'selected':'';?>>Barrel/Barrels </option>
                            <option value="Cubic Meter" <?php echo ($p_ctype=='Cubic Meter')? 'selected':'';?>>Cubic Meter </option>
                            <option value="Dozen" <?php echo ($p_ctype=='Dozen')? 'selected':'';?>>Dozen </option>
                            <option value="Gallon" <?php echo ($p_ctype=='Gallon')? 'selected':'';?>>Gallon</option>
                            <option value="Gram" <?php echo ($p_ctype=='Gram')? 'selected':'';?>>Gram </option>
                            <option value="Kilogram" <?php echo ($p_ctype=='Kilogram')? 'selected':'';?>>Kilogram </option>
                            <option value="Kilometer" <?php echo ($p_ctype=='Kilometer')? 'selected':'';?>>Kilometer </option>
                            <option value="Long Ton" <?php echo ($p_ctype=='Long Ton')? 'selected':'';?>>Long Ton </option>
                            <option value="Meter" <?php echo ($p_ctype=='Meter')? 'selected':'';?>>Meter </option>
                            <option value="Mertic Ton" <?php echo ($p_ctype=='Mertic Ton')? 'selected':'';?>>Metric Ton </option>
                            <option value="Ounce" <?php echo ($p_ctype=='Ounce')? 'selected':'';?>>Ounce </option>
                            <option value="Pair" <?php echo ($p_ctype=='Pair')? 'selected':'';?>>Pair</option>
                            <option value="pack/packs" <?php echo ($p_ctype=='pack/packs')? 'selected':'';?>>Pack/Packs </option>
                            <option value="Piece/Pieces" <?php echo ($p_ctype=='Piece/Pieces')? 'selected':'';?>>Piece/Pieces </option>
                            <option value="Pound" <?php echo ($p_ctype=='Pound')? 'selected':'';?>>Pound</option>
                            <option value="Set/Sets" <?php echo ($p_ctype=='Set/Sets')? 'selected':'';?>>Set/Sets </option>
                            <option value="Short Ton" <?php echo ($p_ctype=='Short Ton')? 'selected':'';?>>Short Ton</option>';
                        </select>

                        <select name="percapacity" id="percapacity" class="form-control" style="width:70px; display:inline-block;">
                            <option value="">Time</option>
                            <option value="Day" <?php echo ($percapacity=='Day')? 'selected':'';?>>Day</option>
                            <option value="Week" <?php echo ($percapacity=='Week')? 'selected':'';?>>Week</option>
                            <option value="Month" <?php echo ($percapacity=='Month')? 'selected':'';?>>Month</option>
                            <option value="Year" <?php echo ($percapacity=='Year')? 'selected':'';?>>Year</option>';
                        </select>
                    </div>	
                </div>	          
                <div class="form_holder"> 
                    <p class="description-line1">Delivery Time </p>
                     <input name="p_delivertytime0" id="p_delivertytime0" type="text" class="form-control"  value="<?php echo $p_delivertytime[0];?>"  style="width:80px; display:inline-block;"/>
                     <select name="p_delivertytime1" id="p_delivertytime1" class="form-control" style="width:120px; display:inline-block;">
                        <option value="">Time</option>
                        <option value="Day"  <?php echo ($p_delivertytime[1]=='Day')? 'selected':'';?>>Day</option>
                        <option value="Week"  <?php echo ($p_delivertytime[1]=='Week')? 'selected':'';?>>Week</option>
                        <option value="Month"  <?php echo ($p_delivertytime[1]=='Month')? 'selected':'';?>>Month</option>
                        <option value="Year"  <?php echo ($p_delivertytime[1]=='Year')? 'selected':'';?>>Year</option>
                    </select> 
                </div>
                <div class="form_holder"> 
                    <p class="description-line1">Packaging Details</p>
                    <textarea name="p_packingdetails"><?php echo $p_packingdetails;?></textarea>
                </div>
            </div>
             <div class="clear"></div>
            <div class="form_holder">
                <input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />
                <input type="hidden" name="releted_product" />
                <input name="page" type="hidden" value="<?php echo $page; ?>" />
                <!--<input name="SourceForm" type="hidden" value="AddProduct" />-->
                <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                <!--<input name="Save" type="submit" class="save_frm" value="Save" />-->
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
/*if($editid) {
	include("show-gallery.php");	
}*/?>
