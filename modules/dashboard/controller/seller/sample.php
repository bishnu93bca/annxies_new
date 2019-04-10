<?php
$obj = new adminProductClass();
$cobj = new adminCategory();
$mObj    = new MemberAdmin;

$ExtraQryStr=" 1 ";
if($sampleId!='')
{
	$productId=$sampleId;
	$fetch_details = $obj->sampleById($sampleId);
	$IdToEdit      = $fetch_details['sampleId'];
	$categoryId    = $fetch_details['proCid'];
	$productName   = $fetch_details['productName'];
	$p_keyword     = $fetch_details['p_keyword'];
	$description   = $fetch_details['description'];
	$productImage  = $fetch_details['productImage'];	
	$qty           = $fetch_details['totalQty'];	
	$currency      = $fetch_details['currency'];	
	$unitType      = $fetch_details['unitType'];	
	$range1        = $fetch_details['range1'];	
	$range2        = $fetch_details['range2'];	
	$selData       = $cobj->categoryById($categoryId);
}

if($editid){
	$cData    		= $mObj->getMemberInfoByid($editid);
    $company   		= $mObj->getCompanyInfoByuserid($id);
    $memberShip		= $mObj->getMembershipInfoByuserid($id);
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
    if($editid){
        include("intro.php");
    }
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
                            <input name="p_keyword" type="text" value="<?php echo $selData['category'];?>" size="30" maxlength="100" readonly/>
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
                            <input type="file" class="input2" name="productImage" /><br />
                            <?php
                            if(file_exists($MEDIA_FILES_ROOT.'/product/thumb/'.$productImage) && $productImage)
                            {
                                echo '<img src="'.$MEDIA_FILES_SRC.'/product/thumb/'.$productImage.'" height="100" width="100" alt="" />';
                            }
                            elseif(file_exists($MEDIA_FILES_ROOT.'/sample/thumb/'.$productImage) && $productImage)
                            {
                                echo '<img src="'.$MEDIA_FILES_SRC.'/sample/thumb/'.$productImage.'" height="100" width="100" alt="" />';
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
                    <p class="description-line1">Description </p>
                    <p class="description-line1">
                        <textarea name="description" style="height:140px;" readonly><?php echo $description;?></textarea>
                    </p>
                    
                </div>
                
                <div class="clear"></div>
            </div>
            
            <div class="status_right">
                <div class="form_holder">

                    <div class="input_left">
                        <p class="description-line1">Status </p>
                        <p class="description-line1">
                            <select name="status" style="width:auto;" readonly>
                                <option value="1" <?php if($status=='1' || !$status) echo 'selected';?> >Active</option>
                                <option value="0" <?php if($status=='0') echo 'selected';?>>Inactive</option>
                                <!--<option value="C" <?php if($status=='C') echo 'selected';?>>Complementary</option>-->
                            </select>
                        </p>
                    </div>			
                </div>		
                                
                <div class="form_holder">    
                    <p class="description-line1">Quantity (<?php echo $unitType;?>)</p>
                    <p class="description-line1" style="width:10%; display:inline-block;">
                        <input name="qty" type="text" value="<?php echo $qty;?>" size="30" maxlength="100" readonly/>
                    </p>                 
                </div>               
                
                <div class="form_holder">
                    <div>
                        <p class="description-line1">Price </p>
                        
                        <input name="range1" id="range1" type="text" placeholder="From" value="<?php echo $range1;?>"  style="width:10%; display:inline-block;" readonly/> ~ 
                        <input name="range2" id="range2" type="text" placeholder="From" value="<?php echo $range2;?>"  style="width:10%; display:inline-block;" readonly/>


                        <input name="isApproved" id="isApproved" type="text" placeholder="Status" value="<?php echo $currency;?>"  style="width:100px; margin-right:5px; display:inline-block;" readonly/>
                    </div>			
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
