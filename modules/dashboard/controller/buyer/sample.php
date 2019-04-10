<?php
$obj = new adminProductClass();
$cobj = new adminCategory();
$cObj    = new MemberAdmin;

$ExtraQryStr=" 1 ";

if($contactID!='')
{
	$fetch_details = $cObj->sampleRequestbyId($contactID);
	$IdToEdit      = $fetch_details['contactID'];
	$productName   = $fetch_details['product'];
	$companyNm     = $fetch_details['company'];
	$productId     = $fetch_details['proId'];
	$p_keyword     = $fetch_details['qty'];
	$description   = $fetch_details['description'];
	$productImage  = $fetch_details['productImage'];	
	$qty           = $fetch_details['qty'];	
	$currency      = $fetch_details['currency'];	
	$range1        = $fetch_details['price'];	
	$productImage  = $fetch_details['p_photo'];	
	$categoryId    = $fetch_details['p_category'];	
    $cData         = $cobj->getAttributeByCategoryId(1, $categoryId, 0, 999999);
}

if($editid){
	$cData    		= $cObj->getMemberInfoByid($editid);
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
    </ul>
    <?php echo $ErrMsg;
    if($editid){
        include("intro.php");
    }
if($contactID)
{
    ?>      
        <form name="modifycontent" action="" method="post" enctype="multipart/form-data">
            <div class="form_left">
                <div class="form_holder">
                    <div class="input_left">
                        <p class="description-line1">Product Name </p>
                        <p class="description-line1">
                            <input name="productName" type="text" value="<?php echo $productName;?>" size="30" maxlength="100" />
                        </p>
                    </div>
                    <div class="input_right">
                        <p class="description-line1">Supplier </p>
                        <p class="description-line1">
                            <input name="company" type="text" value="<?php echo $companyNm;?>" size="30" maxlength="100" />
                        </p>
                    </div>
                    <div class="clear"></div>
                    <div class="">
                        <?php
                        if($categoryId)
                            include("category_attr.php");
                        ?>
                    </div>                    
                </div>
                
                <div class="clear"></div>
                <div class="form_holder">
                    <div class="">
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
                    <p class="description-line1">Quantity </p>
                    <p class="description-line1"><input name="qty" style="width:20%" type="text" value="<?php echo $qty;?>" size="30" maxlength="100" /></p>                      
                </div>
                <div class="form_holder">
                    <div>
                        <p class="description-line1">Price </p>
                            <select name="currency" id="currency" class="form-control" style="width:120px; margin-right:5px; display:inline-block;">   
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
                        <input name="range1" id="range1" type="text" placeholder="From" class="form-control" value="<?php echo $range1;?>"  style="width:50px; display:inline-block;"/>
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
