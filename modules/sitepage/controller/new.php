<?php
include("includes/pagebreadcrumb.php");
$obj    = new MenuCategory();
$user   = new user();                    
$menu   = new menu();   
if($parentId=='')
	$parentId = 0;
if($editid!='')
{
	$categoryId        = $editid;
	$fetch_details     = $obj->categoryById($categoryId);
	$IdToEdit          = $fetch_details['categoryId'];
	$ssiteId           = $fetch_details['siteId'];
	$parentId          = $fetch_details['parentId'];	
	$modulePackageId   = $fetch_details['moduleId'];
	$categoryName      = $fetch_details['categoryName'];
	$categoryUrl       = $fetch_details['categoryUrl'];
	$categoryType      = $fetch_details['categoryType'];
	$isTopMenu         = $fetch_details['isTopMenu'];	
	$isFooterMenu      = $fetch_details['isFooterMenu'];
	$isContent         = $fetch_details['isContent'];
	$isGallery         = $fetch_details['isGallery'];
	$isVideo           = $fetch_details['isVideo'];		
	$permalink         = $fetch_details['permalink'];	
	$categoryImage     = $fetch_details['categoryImage'];
	$sideBar           = explode('#',$fetch_details['sideBar']);
	$swapNo            = $fetch_details['swapNo'];	
	$hiddenMenu        = $fetch_details['hiddenMenu'];	
}
$menu=new menu();
$menudata= $menu -> menu_by_id($moduleId);
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
    <li><a href="#"><?php echo $menu_name;?> <span>→</span> <?php echo $parent_menu_name;?></a></li>    
</ul>
<section id="form">
    <div style="overflow: hidden;">
    <br class="clear" />
    <?php echo $ErrMsg;?>    
    <form name="modifycontent" action="" method="post" enctype="multipart/form-data">    
        <div class="form_holder"> 
            <div class="description-line">	
                <span class="description-line-text">                 
                    <?php echo $categoryParentName;?>	    
                </span>
            </div>            
            <div style="width:50%; float:left;">
                <p class="description-line1">Page *</p>        
                <p class="description-line1"><input name="categoryName" autocomplete="off" type="text" class="input2 permalink" data-entity="<?php echo TBL_MENU_CATEGORY;?>" data-parent="<?php echo $parentId;?>" data-id="<?php echo $editid;?>" value="<?php echo $categoryName;?>" maxlength="100" /></p>
                <p class="description-line1">Permalink: <input name="permalink" type="text" class="input2 gen_permalink" value="<?php echo $permalink;?>" style="width:245px;" maxlength="100" /></p>
                <p class="description-line1">Redirect URL</p>        
                <p class="description-line1"><input name="categoryUrl" type="text" class="input2" id="categoryName" value="<?php echo $categoryUrl;?>" /></p>		
                <p class="description-line1">Is it a Top Menu?</p>        
                <p class="description-line1">        
                    <select name="isTopMenu">        
                        <option value="Y" <?php if($isTopMenu=='Y') echo 'selected'?>>Yes</option>        
                        <option value="N" <?php if($isTopMenu=='N') echo 'selected'?>>No</option>        
                    </select>        
                </p>	                
                <p class="description-line1">Is it a Footer Menu?</p>        
                <p class="description-line1">        
                    <select name="isFooterMenu">
                        <option value="Y" <?php if($isFooterMenu=='Y') echo 'selected'?>>Yes</option>        
                        <option value="N" <?php if($isFooterMenu=='N') echo 'selected'?>>No</option>        
                    </select>        
                </p>    
                <p class="description-line1">Page Display Type</p>        
                <p class="description-line1">        
                    <select name="categoryType">
                        <option value="Article View" <?php if($categoryType=='Article View') echo 'selected'?>>Single Content</option>        
                        <option value="List View" <?php if($categoryType=='List View') echo 'selected'?>>Multiple Content</option>        
                    </select>        
                </p>	            
                <?php /*?> <p class="description-line1">Sidebar</p>                
                <p class="description-line1">                
                <select name="sideBar[]" multiple="multiple" size="5">                
                    <?php		
					foreach($sideBarArray as $key=>$val)		
					{		
						if(in_array($key,$sideBar))		
							echo '<option value="'.$key.'" selected>'.$val.'</option>';		
						else		
							echo '<option value="'.$key.'">'.$val.'</option>';		
					}		
                    ?>                
                </select>                
                </p><?php */?>            
            </div>
            <?php if($_SESSION['UTYPE']=="A") {?>
            <div style="width:50%; float:left;">
                <fieldset>
                    <p class="description-line1">
                        Is it a Hidden Menu? 
                        <select name="hiddenMenu">
                            <option value="Y" <?php if($hiddenMenu=='Y') echo 'selected';?>>Yes</option>
                            <option value="N" <?php if($hiddenMenu=='N' || !$hiddenMenu) echo 'selected';?>>No</option>
                        </select>
                    </p>
                </fieldset>
                <fieldset>
                    <p class="description-line1">
                        Page for ? *
                        <select name="ssiteId">
                            <option value="" >-Select-</option>
                            <option value="35" <?php echo ($ssiteId=='35')? 'selected':'';?>>Annexis</option>
                            <option value="36" <?php echo ($ssiteId=='36')? 'selected':'';?>>Annexis Directory</option>
                        </select>
                    </p>
                </fieldset>
                <fieldset>            
                    <p class="description-line1">Page Type *</p>  
                    <?php   
                    $uid = $_SESSION['UID'];                    
                    $sel_details = $user -> user_by_id($uid);                    
                    $permission = $sel_details['permission'];                    
                    $permission_array = explode(',',$permission);
                    ?> 
                    <ul id="browser" class="filetree">                
                                           
                        <li>
                            <span class="folder" style="width:10px;">
                                <input type="radio" name="modulePackageId" value="0" <?php if($modulePackageId==0) echo 'checked="checked"';?> />CMS
                            </span>                    	
                            <?php                              
                            $submenu = $menu -> getModuleByparent_Id(1);                        
                            if(sizeof($submenu)>0) 
                            {
                                echo '<ul>';
                                for($sm=0;$sm<sizeof($submenu);$sm++) 
                                {
                                    if(in_array($submenu[$sm]['menu_id'],$permission_array))
                                        echo '<li><span class="file">'.$submenu[$sm]['menu_name'].'</span></li>';					
                                }
                                echo '</ul>';
                            }
                            ?>
                        </li>                            
                        <?php            
                        $sel_Details = $menu ->getModulePackagesAndAddons();    
                                               
                        
                        if(sizeof($sel_Details)>0)
                        {                    
                            for($i=0;$i<sizeof($sel_Details);$i++)
                            {
                                if(in_array($sel_Details[$i]['menu_id'], $permission_array))	
                                {				
                                    echo '<li><span class="folder" style="width:10px;">';                                
                                    if($modulePackageId==$sel_Details[$i]['menu_id'])					
                                        echo '<input type="radio" name="modulePackageId" value="'.$sel_Details[$i]['menu_id'].'" checked="checked" />';					
                                    else					
                                        echo '<input type="radio" name="modulePackageId" value="'.$sel_Details[$i]['menu_id'].'" />';                                
                                    echo $sel_Details[$i]['menu_name'];                                
                                    echo '</span>';                                
                                    $submenu=$menu -> getModulePackagesByparent_Id($sel_Details[$i]['menu_id']);	
                                    if(sizeof($submenu)>0) 
                                    {
                                        echo '<ul>';
                                        for($sm=0;$sm<sizeof($submenu);$sm++) 
                                        {
                                            if(in_array($submenu[$sm]['menu_id'], $permission_array))
                                                echo '<li><span class="file">'.$submenu[$sm]['menu_name'].'</span></li>';					
                                        }
                                        echo '</ul>';
                                    }
                                    echo '</li>';
                                }
                            }					
                        }				
                        ?>
                    </ul>                
                </fieldset>
            </div>
            <?php } else {?>            
            <input type="hidden" name="modulePackageId" value="0" />
            <?php }?>
            <br class="clear" />
            <?php 
			/*if($editid!=1)
			include("banner.php");*/?>    
        </div>	    
        <div class="iconbox">	    
            <p  class="description-line1">	    
                <span class="save_button-box">
                	<?php if($editid!='' && $_SESSION['UTYPE']!="A") {?>
                    <input name="modulePackageId" type="hidden" value="<?php echo $modulePackageId;?>" />
                    <?php }?>    
                    <input name="page" type="hidden" value="<?php echo $page; ?>" />        
                    <input name="pageType" type="hidden" value="<?php echo $pageType; ?>" />          
                    <input name="dtaction" type="hidden" value="<?php echo $dtaction;?>" /> 
                    <input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />        
                    <input name="moduleId" type="hidden" value="<?php echo $moduleId;?>" />                    
                    <input name="parentId" type="hidden" value="<?php echo $parentId;?>" />                    
                    <input name="type" type="hidden" value="<?php echo $type;?>" />        
                    <input name="SourceForm" type="hidden" class="savebtn" value="AddCategory" />
                    <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />        
                    <input name="Save" type="submit" class="save_frm" value="Save" />        
                    <input name="SaveNext" type="submit" class="save_frm"  value="Save & Add New" />      
                    <input name="Cancel" type="button"  onclick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&moduleId=<?php echo $moduleId;?>'" class="cancel_frm" value="Close" />  
                    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                </span>	    
            </p>    
        </div>    
    </form>  
    </div>  
</section>