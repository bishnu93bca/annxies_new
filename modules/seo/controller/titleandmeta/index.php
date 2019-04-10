<?php
$obj = new PageTitle();

$fetch_details          = $obj->getDefaultTitleAndMeta($_SESSION['SITE_ID']);
$IdToEdit               = $fetch_details['titleandMetaId'];
$titleandMetaUrl        = $fetch_details['titleandMetaUrl'];
$pageTitleText          = $fetch_details['pageTitleText'];
$metaTag                = $fetch_details['metaTag'];
$metaDescription        = $fetch_details['metaDescription'];
$metaRobots             = $fetch_details['metaRobots'];
$titleandMetaType       = $fetch_details['titleandMetaType'];
$status                 = $fetch_details['status'];

$homefetch_details      = $obj->getHomeTitleAndMeta($_SESSION['SITE_ID']);
$homeIdToEdit           = $homefetch_details['titleandMetaId'];
$hometitleandMetaUrl    = $homefetch_details['titleandMetaUrl'];
$homepageTitleText      = $homefetch_details['pageTitleText'];
$homemetaTag            = $homefetch_details['metaTag'];
$homemetaDescription    = $homefetch_details['metaDescription'];
$homepagemetaRobots     = $homefetch_details['metaRobots'];
$hometitleandMetaType   = $homefetch_details['titleandMetaType'];
$homestatus             = $homefetch_details['status'];

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
        <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
        <li><a href="#"><?php echo $parent_menu_name;?></a></li>
</ul>
 <section id="form">
<br class="clear" /><?php echo $ErrMsg?>
<form name="modifycontent" action="" method="post" enctype="multipart/form-data">
    <div class="form_holder">	
    	<div style="width:45%; float:left;">
            <p class="description-line1">Default Page Title *</p>
            <p class="description-line1">
                <textarea name="pageTitleText" style="width:98%; height:40px;"><?php echo $pageTitleText;?></textarea>		
            </p>
            <p class="description-line1">Robots </p>
            <p class="description-line1">
            	<input type="radio" name="metaRobots" value="index, follow" <?php if($metaRobots=='index, follow' || !$metaRobots) echo 'checked';?> style="width:auto" />index, follow 
            	<input type="radio" name="metaRobots" value="noindex, nofollow" <?php if($metaRobots=='noindex, nofollow') echo 'checked';?> style="width:auto" />noindex, nofollow
                <input type="radio" name="metaRobots" value="index, nofollow" <?php if($metaRobots=='index, nofollow') echo 'checked';?> style="width:auto" />index, nofollow
                <input type="radio" name="metaRobots" value="noindex, follow" <?php if($metaRobots=='noindex, follow') echo 'checked';?> style="width:auto" />noindex, follow
                
            </p>
        </div>
        <div style="width:45%; float:right;">
            <p class="description-line1">Default Meta Keyword</p>
            <p class="description-line1">
                <textarea name="metaTag" style="width:98%; height:40px;"><?php echo $metaTag;?></textarea>
            </p>
            <p class="description-line1">Default Meta Description</p>
            <p class="description-line1">
                <textarea name="metaDescription" style="width:98%; height:40px;"><?php echo $metaDescription;?></textarea>
            </p>
    	</div>
    </div>
    
    <div class="form_holder">	
    	<div style="width:45%; float:left;">
            <p class="description-line1">Home Page Title *</p>
            <p class="description-line1">
                <textarea name="homepageTitleText" style="width:98%; height:40px;"><?php echo $homepageTitleText;?></textarea>		
            </p>
            <p class="description-line1">Robots </p>
            <p class="description-line1">
            	<input type="radio" name="homepagemetaRobots" value="index, follow" <?php if($homepagemetaRobots=='index, follow' || !$homepagemetaRobots) echo 'checked';?> style="width:auto" />index, follow 
            	<input type="radio" name="homepagemetaRobots" value="noindex, nofollow" <?php if($homepagemetaRobots=='noindex, nofollow') echo 'checked';?> style="width:auto" />noindex, nofollow
                <input type="radio" name="homepagemetaRobots" value="index, nofollow" <?php if($homepagemetaRobots=='index, nofollow') echo 'checked';?> style="width:auto" />index, nofollow
                <input type="radio" name="homepagemetaRobots" value="noindex, follow" <?php if($homepagemetaRobots=='noindex, follow') echo 'checked';?> style="width:auto" />noindex, follow
            </p>
        </div>
        <div style="width:45%; float:right;">
            <p class="description-line1">Home Meta Keyword</p>
            <p class="description-line1">
                <textarea name="homemetaTag" style="width:98%; height:40px;"><?php echo $homemetaTag;?></textarea>
            </p>
            <p class="description-line1">Home Meta Description</p>
            <p class="description-line1">
                <textarea name="homemetaDescription" style="width:98%; height:40px;"><?php echo $homemetaDescription;?></textarea>
            </p>
    	</div>
    </div>
    
    <p  class="description-line1">
        <span class="save_button-box">	
            <input name="IdToEdit" type="hidden" value="<?php echo $IdToEdit;?>" />
            <input name="homeIdToEdit" type="hidden" value="<?php echo $homeIdToEdit;?>" />
            <input name="SourceForm" type="hidden" class="save_button" value="TitleMetaAdd" />
            <input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />
            <input name="Save" type="submit" class="save_frm" value="Save" />
            <input name="Cancel" type="button"  onclick="window.location.href='index.php'" class="cancel_frm" value="Close" />
            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
        </span>
    </p>
</form>
</section>
<?php
$menu = new menu();
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

<div class="clear"></div>
<!-- Canonical -->
<div class="can_div">
	<ul id="breadcrumb">
	    <li><a href="#"><?php echo 'Canonical';?> <span>→</span></a></li>
	    <li><a href="#"><?php echo $parent_menu_name;?><span> →</span></a></li>
	    <li> 
	    	<div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=addcanonical&moduleId=<?php echo $moduleId;?>'">Add New</a></div>
	    </li>
	</ul>
	<?php 
	if($_SESSION['ErrMsg'])
	{
		echo '<br class="clear" />'.$_SESSION['ErrMsg'];
		unset($_SESSION['ErrMsg']);
	}?>
	<div class="table">
		<ul class="table_head">
	        <li style="width:5%" class="sl">Sl</li>
	        <li style="width:50%">Page Url</li>
	        <li class="last_li"></li>
	        <?php /*?><li class="toggle_select">Toggle <input type="checkbox" class="selectall" name="toggle"></li><?php */?>
	    </ul>
	    <ul class="table_elem">
			<?php
	        $obj = new PageTitle();
	        $ExtraQryStr="1";						
	        $fetch_Details = $obj -> getcanonicalBysiteId($_SESSION['SITE_ID'], $ExtraQryStr);
			if($fetch_Details)
			{
				$slNo = 1;
				for($aa=0;$aa<sizeof($fetch_Details);$aa++)
				{
					if($fetch_Details[$aa]['status'] == 'Y')
					{
						$conStatus = '<img src="images/active.png" alt="Active" width="15" border="0" />';
						$status="N";
					}
					else
					{
						$conStatus = '<img src="images/inactive.png" alt="Inactive" width="15" border="0" />';
						$status="Y";
					}	
				?>
				 <li>
	                 <span style="width:5%" class="sl"><?php echo $slNo;?></span>
                     <span style="width:74%"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=addcanonical&editid=<?php echo $fetch_Details[$aa]['canonicalId'];?>&moduleId=<?php echo $moduleId;?>"><?php echo $SITE_LOC_PATH.$fetch_Details[$aa]['canonicalUrl'];?></a></span>		
	                 <span class="last_li">
	                    <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=addcanonical&editid=<?php echo $fetch_Details[$aa]['canonicalId'];?>&moduleId=<?php echo $moduleId;?>"><img src="images/edit.gif" alt="" width="16" height="16" border="0" /></a>
	                    <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&action=canonicalstatus&stschgto=<?php echo $status?>&id=<?php echo $fetch_Details[$aa]['canonicalId'];?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>" class="ask"><?php echo $conStatus;?></a>
	                    <a class="ask"  href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&action=canonicaldelete&id=<?php echo $fetch_Details[$aa]['canonicalId'];?>&redstr=<?php echo $redirectString;?>"><img src="images/delete.png" alt="" width="16" height="16" border="0" /></a>
	                    <?php /*?><input type="checkbox" class="case" name="selectMulti" value="<?php echo $fetch_Details[$aa]['canonicalId'];?>" /><?php */?>
	                </span>
				 </li>
				<?php
	            $slNo++;
			}
			/*?>
	         <li><span class="last_li">
	            <select name="multiAction" class="multi_action">
	                <option value="">Select</option>
	                <?php /*if($_SESSION['UTYPE']=="A") {?>
	                <option value="delete">Delete</option>
	                <?php }*/?>
	                <?php /*?><option value="active">Active</option>
	                <option value="inactive">Inactive</option>
	            </select>                
	        </span></li>
	        <?php	
	        */
		}
		else
		{
			?>
			<li style="text-align:center; line-height:30px;">No Record Present</li>
			<?php
		}
		?>
		</ul>
	</div>
</div>


<div class="clear"></div>
<div class="iconbox">
	
</div>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?> <span> →</span></a></li>
    <li>
    	<div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add New</a></div>
    </a>
    </li>
</ul>
<?php 
if($_SESSION['ErrMsg'])
{
	echo '<br class="clear" />'.$_SESSION['ErrMsg'];
	unset($_SESSION['ErrMsg']);
}?>
<div class="table">
	<ul class="table_head">
        <li style="width:5%" class="sl">Sl</li>
        <li style="width:50%">Page Url</li>
        
        <li class="toggle_select">Toggle <input type="checkbox" class="selectall" name="toggle"></li>
    </ul>
    <ul class="table_elem">
		<?php
        $obj = new PageTitle();
        $ExtraQryStr="titleandMetaType='O'";						
        $fetch_Details = $obj -> getPageTitleandMetaBysiteId($_SESSION['SITE_ID'], $ExtraQryStr);
		if($fetch_Details)
		{
			$dataExists='Yes';
			$slNo = 1;
			for($aa=0;$aa<sizeof($fetch_Details);$aa++)
			{
				if($fetch_Details[$aa]['status'] == 'Y')
				{
					$conStatus = '<img src="images/active.png" alt="Active" width="15" border="0" />';
					$status="N";
				}
				else
				{
					$conStatus = '<img src="images/inactive.png" alt="Inactive" width="15" border="0" />';
					$status="Y";
				}	
			?>
			 <li>
                 <span style="width:5%" class="sl"><?php echo $slNo;?></span>
                 <span style="width:74%"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $fetch_Details[$aa]['titleandMetaId'];?>&moduleId=<?php echo $_REQUEST['moduleId'];?>"><?php echo $SITE_LOC_PATH.$fetch_Details[$aa]['titleandMetaUrl'];?></a></span>		
                 <span class="last_li">
                    <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $fetch_Details[$aa]['titleandMetaId'];?>&moduleId=<?php echo $_REQUEST['moduleId'];?>"><img src="images/edit.gif" alt="" width="16" height="16" border="0" /></a>
                    <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $status?>&id=<?php echo $fetch_Details[$aa]['titleandMetaId'];?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>" class="ask"><?php echo $conStatus;?></a>
                    <a class="ask"  href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&id=<?php echo $fetch_Details[$aa]['titleandMetaId'];?>&redstr=<?php echo $redirectString;?>"><img src="images/delete.png" alt="" width="16" height="16" border="0" /></a>
                    <input type="checkbox" class="case" name="selectMulti" value="<?php echo $fetch_Details[$aa]['titleandMetaId'];?>" />
                </span>
			 </li>
			<?php
            $slNo++;
		}
		?>
         <li><span class="last_li">
            <select name="multiAction" class="multi_action">
                <option value="">Select</option>
                <?php /*if($_SESSION['UTYPE']=="A") {?>
                <option value="delete">Delete</option>
                <?php }*/?>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>                
        </span></li>
        <?php	
	}
	else
	{
		?>
		<li style="text-align:center; line-height:30px;">No Record Present</li>
		<?php
	}
	?>
	</ul>
</div>
<div class="clear"></div>
