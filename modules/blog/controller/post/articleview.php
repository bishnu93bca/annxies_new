<?php
$obj    = new Content();
$mObj   = new MenuCategory();
if($contentID)
	$fetch_details = $obj->getContentBycontentID($contentID);
else
	$fetch_details = $obj->getContentBymenucategoryId($editid);

$contentHeading             = $fetch_details['contentHeading'];
$homeHeading             	= $fetch_details['homeHeading'];
$contentDescription         = $fetch_details['contentDescription'];	
$contentShortDescription    = $fetch_details['contentShortDescription'];
$fb    						= $fetch_details['fb'];
$tw    						= $fetch_details['tw'];
$gp    						= $fetch_details['gp'];
$menu       = new menu();
$menudata   = $menu -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image        = $menudata['menu_image'];
	$menu_name         = $menudata['menu_name'];
	$parentMenuId      = $menudata['parent_id'];
	$parentmenudata    = $menu -> menu_by_id($parentMenuId);
	$parent_menu_name  = $parentmenudata['menu_name'];
}
if($_SESSION['UTYPE']=="A")
{
	?>
	<ul id="breadcrumb">
	    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
	    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
	    <li><div class="button_box">
	        <?php 
	        echo '<a href="index.php?pageType='.$pageType.'&dtls='.$dtls.'&dtaction=delete&id='.$fetch_details['contentID'].'&action=content&moduleId='.$moduleId.'&redstr='.$redirectString.'" class="ask">Delete Content</a>';
	        ?>
	        </div>
	    </li>
	</ul>
	<?php
}
echo $_SESSION['ErrMsg'];
unset($_SESSION['ErrMsg']);
if($fetch_details)
{
    $permalink = $fetch_details['permalink'];
	?>
	<form name="modifycontent" action="" method="post" enctype="multipart/form-data">
		<div class="form_holder">
			<div class="description-line">
                <span class="description-line-text">Heading *</span>
                <span ><input type="text" style="width:250px;" name="contentHeading" value="<?php echo $contentHeading;?>" maxlength="200"  /></span>
				<?php 
				$ExtraQryStr    = "moduleId=".$parentMenuId;				  
				$data           = $mObj -> getCategory($ExtraQryStr);
				$count          = sizeof($data);

				if($count>0)
				{ ?>
                    <div style="float:right; margin:0px;">
                    	<span class="description-line-text">For Page *
                            <select name="menucategoryId">					
                                <?php 
                                for($i=0; $i<sizeof($data); $i++)
                                {
                                    $categoryName=$data[$i]['categoryName'];
                                    $parentId=$data[$i]['parentId'];	
                                    $pRow=0;
                                    $parentNameArray='';
                                    $concatinateName='';															
                                    while($parentId!=0)
                                    {
                                        $name=$mObj -> categoryById($parentId);
                                        $parentId=$name['parentId'];
                                        $parentNameArray[$pRow] =$name['categoryName'];	
                                        $pRow++;							
                                    }								
                                                                
                                    if($parentNameArray!='')
                                    {
                                        $parentNameArray=array_reverse($parentNameArray);	
                                        
                                        for($pna=0;$pna<sizeof($parentNameArray);$pna++)
                                            $concatinateName .=$parentNameArray[$pna].' > ';
                                            
                                        $categoryName=$concatinateName.$categoryName;									
                                    }
                                    
                                    if($editid!='')
                                        $parentId = $fetch_details['parentId'];	
                                        
                                    $menucategoryIds .= $data[$i]['categoryId'].',';					
                                    
                                ?>
                                <option value="<?php echo $data[$i]['categoryId'];?>" <?php if($menucategoryId==$data[$i]['categoryId']) echo 'selected';?>><?php echo $categoryName;?></option>
                                <?php 
                                }
                                $menucategoryIds = substr($menucategoryIds,0,-1);	
                                ?>
                            </select>
                    	</span>
                    </div>
				<?php 
				}?>	
                
                <div style="float:right; margin:0px;">
                	<span class="description-line-text">Display Heading
					<select name="displayHeading">
						<option value="Y" <?php if($fetch_details['displayHeading']=='Y') echo 'selected';?>>Yes</option>
						<option value="N" <?php if($fetch_details['displayHeading']=='N') echo 'selected';?>>No</option>
					</select></span>
				</div>
			</div>	
            <div class="clear"></div>
            
            <p class="description-line1">Home Heading </p>		
            <p class="description-line1"><input name="homeHeading" type="text" class="input2" value="<?php echo $homeHeading;?>" /></p>
            
			<p class="description-line1">Description </p>
			<p class="description-line1">
                <?php
                $CKEditor = new CKEditor();
                $CKEditor->returnOutput = true;
                $CKEditor->basePath = '../ckeditor/';
                $CKEditor->config['width'] = '100%';
                $CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);
                CKFinder::SetupCKEditor($CKEditor, '../ckfinder/');
                $code = $CKEditor->editor("contentDescription", $contentDescription);				
                echo $code;
				?>
            </p>
		</div>
		<div class="form_holder">
            <div class="iconbox">	
                <span class="save_button-box">
                <input name="IdToEdit" type="hidden" value="<?php echo $fetch_details['contentID'];?>" />
                <input name="SourceForm" type="hidden" class="save_button" value="ContentGeneral" />
                <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
                <input name="Update" type="submit" class="save_frm" value="Save" />
                <input name="Cancel" type="button"  onclick="window.location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>'" class="cancel_frm" value="Close" />
                <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                </span>
            </div>
        </div>
	</form>
    <?php
}?>