<?php
$obj  = new adminCategory;
$pobj = new adminProductClass;
/*
$ExtraQryStr = 'mainCategory=2';
$allC = $obj->getCategory($ExtraQryStr);

foreach($allC as $c){
    if($c['mainCategory']==1)
        $pM = '/products';
    elseif($c['mainCategory']==2)
        $pM = '/services';
    
    $url = $pM.$c['categoryUrl'];
    
    $param = array();
    $param['categoryUrl']=$url;
    $obj->categoryUpdateBycategoryId($param, $c['c_id']);
}*/

$ExtraQryStr = "1";
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

$val = 0;

if(isset($search)){
    $page = $_GET['page'] = 1;
    $val  = 1;
}

if(isset($categoryType))
    $_SESSION['categoryType'] = $categoryType;
if(isset($srchtxt))
    $_SESSION['srchtxt'] = $srchtxt;
if(isset($mainCategory))
    $_SESSION['mainCategory'] = $mainCategory;
if(isset($parentId))
    $_SESSION['parentId'] = $parentId;
if(isset($catStatus))
    $_SESSION['catStatus'] = $catStatus;

if($_SESSION['categoryType'])
    $ExtraQryStr .= ' AND categoryType="'.addslashes($_SESSION['categoryType']).'"';
if($_SESSION['mainCategory'])
    $ExtraQryStr .= ' AND mainCategory='.addslashes($_SESSION['mainCategory']);
if($_SESSION['srchtxt'])
    $ExtraQryStr .= " AND category LIKE '%".addslashes($_SESSION['srchtxt'])."%'";
if($_SESSION['catStatus'])
    $ExtraQryStr .= " AND status='".addslashes($_SESSION['catStatus'])."'";
if($_SESSION['parentId'])
    $ExtraQryStr .= " AND parent_id=".addslashes($_SESSION['parentId']);

if(isset($clear))
{
    $val  = 0;
	$ExtraQryStr = "1";
    $page        = $_GET['page']= 1;
    $_SESSION['srchtxt'] = $_SESSION['categoryType'] = $_SESSION['mainCategory'] = $_SESSION['parentId'] = $_SESSION['catStatus'] = $parentId= '';
}

if($val==0){
    if($parentId)
        $ExtraQryStr .= " and parent_id='".$parentId."'";
    else
        $ExtraQryStr.= " and parent_id=".$val;
}

$countRow = $obj->categoryCount($ExtraQryStr);
?>
<script>
$(function() {
    $(document).on('change', '.categoryFor', function(){
        var catId = $(this).val();
        var pId   = '<?php echo $_SESSION['parentId'];?>';
        $.ajax({
            url: '../modules/categorynproduct/controller/category/subcategory.php',
            type: 'POST',
            data:{'catId':catId,'pId':pId},
            cache: false,
            success: function(data){  
                $('.subCategory').html(data);
            }
        });
    });
    $('.categoryFor').trigger('change');
});
</script>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?><span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
    <?php
	if($parentId)
	{
		?>
    	<li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $_REQUEST['moduleId'];?>&parentId=<?php echo $parentId;?>'">Add New</a></div></li>
        <?php
	}
	else
	{
		?>
        <li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $_REQUEST['moduleId'];?>'">Add New</a></div></li>
        <?php
	}
	?>  
    <li><p>Recouds found: <?php echo $countRow;?></p></li> 
</ul>
<?php 
if($_SESSION['ErrMsg'])
{
	echo '<br class="clear" />'.$_SESSION['ErrMsg'];
	unset($_SESSION['ErrMsg']);
}
?>

<form action="" name="myForm" method="POST">

    <div class="form_holder">
         <div class="description-line1"> 
            Product / Service
            <select name="mainCategory" class="categoryFor" style="width:120px;margin-right:10px;">
                <option value="">Select</option>
                <?php
                $parentCat   = $obj->getCategoryByparentId(0);
                foreach($parentCat as $pCat){
                    if($pCat['c_id']==$_SESSION['mainCategory'])
                        $chk = 'selected';
                    else
                        $chk = '';
                    echo '<option value='. $pCat['c_id'].' '.$chk.'>'.$pCat['category'].'</option>';
                } 
                ?>
            </select>
            <span class="subCategory"></span>
            <input type="text" class="srchtxt" name="srchtxt" value="<?php echo $_SESSION['srchtxt'];?>" style="width:200px;margin-right:10px;" placeholder="Search by Category">

            <select name="catStatus" style="width:120px;margin-right:10px;">
                <option value="">Select</option>
                <option value=""  <?php echo ($_SESSION['catStatus']=='All')? 'selected':'';?>>All</option>
                <option value="Y" <?php echo ($_SESSION['catStatus']=='Y')? 'selected':'';?>>Active</option>
                <option value="N" <?php echo ($_SESSION['catStatus']=='N')? 'selected':'';?>>Inactive</option>
            </select>
             
            <input type="submit" name="search" value="Search" class="search_save_frm" style="width:auto !important; margin-top:0px;" />

            <input type="submit" name="clear" value="Reset" class="search_close_frm" style="width:auto !important; margin-top:0px;" />
        </div>
    </div>
    <input type="hidden" name="Sourceform" value="refine_search_order">
    
    <div class="table">
        <ul class="table_head">
            <li class="sl">Sl. No.</li>
            <li class="u_name" style="width:300px;">Category</li>
			<?php //if(!$parentId){} ?><li class="u_name" style="width:100px; text-align:center;">Sub Category</li><?php  if($parentId){ ?>
                <li class="sl" style="width:25%;">Home Page</li>
                <li class="sl" style="width:15%;">Category For</li>
                <li class="toggle_select">Toggle <input type="checkbox" class="selectall" name="toggle"></li>
            <?php } ?>
        </ul>
        <ul class="table_elem">
			<?php            
			if($countRow)
			{
                /**************************************************************
                Paging Variable Started
                ***************************************************************/
                $p = new Pager;	
                if(empty($_SESSION['pageLimit']))
                    $_SESSION['pageLimit'] = 10;
                if(!empty($pageLimit)) {
                    $_SESSION['pageLimit']=$pageLimit;
                }
                
                $limit=20;
                $start = $p->findStart($limit);
                if(!$page)
                    $page=1;
                /**************************************************************
                Paging Variable Ended
                ***************************************************************/
                $fetch_Details = $obj->getCategoryByLimit($ExtraQryStr, $start, $limit);
                
				$countRow = $obj->categoryCount($ExtraQryStr);	
				$pages = $p->findPages($countRow, $limit);
				if($page>1)
				    $slNo = (($page - 1)*$limit)+1;
				else
				    $slNo = 1;
                foreach ($fetch_Details as $selData)
                {					
					if($selData['status'] == 'Y')
					{
						$conStatus = '<img src="images/active.png" alt="Active" width="15" border="0" />';
						$status="N";
					}
					else
					{
						$conStatus = '<img src="images/inactive.png" alt="Inactive" width="15" border="0" />';
						$status="Y";
					}
					$category=	'<strong>'.$selData['category'].'</strong>';
					$ExtraQryStrNew= "parent_id=".$selData['c_id'];
					$fetch_sub_Details = $obj->categoryCount($ExtraQryStrNew);
                    ?>
					<li id="recordsArray_<?php echo $selData['c_id'];?>">
						<span class="sl"><?php echo $slNo;?></span>						 
						<span class="u_name" style="width: 300px;"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $selData['c_id'];?>&moduleId=<?php echo $_REQUEST['moduleId'];?>&parentId=<?php echo $selData['parent_id'];?>"><?php echo $category;?></a></span>
                        <?php //if(!$parentId){ }?>
                            <span class="u_name" style="width:100px; text-align:center;"><a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&type=<?php echo $type;?>&moduleId=<?php echo $moduleId;?>&parentId=<?php echo $selData['c_id'];?>"><?php if(sizeof($fetch_sub_Details)!=0) echo $fetch_sub_Details; else echo '-';?></a></span>
                        <?php  if($parentId){ ?>
                            <span class="sl" style="width:25%;"><?php echo ($selData['showHome']=='Y')? 'Yes':'No';?></span>

                            <span class="sl" style="width:15%;">
                                <?php echo ($selData['parent_id']=='1') ? "Product" : "Service";?>
                            </span>                    
                        <?php } ?>
						<span class="last_li">
                        	<a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $selData['c_id'];?>&moduleId=<?php echo $moduleId;?>&parentId=<?php echo $selData['parent_id'];?>"><img src="images/edit.gif" alt="edit" border="0" /></a>
                            <?php 
                            if($parentId){ ?> 
                          	     <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $status?>&id=<?php echo $selData['c_id'];?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>" ><?php echo $conStatus;?></a>
                                <?php if($_SESSION['UID']==2 || $selData['parentId']!=0){?>
                                    <a class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&id=<?php echo $selData['c_id'];?>&redstr=<?php echo $redirectString;?>" ><img src="images/delete.png" alt="trash"  border="0" /></a>
                                <?php }?>
                                <input type="checkbox" class="case" name="selectMulti" value="<?php echo $selData['c_id'];?>" />
                            <?php }?>
                        </span>
					</li>
					<?php
                    $slNo++;
                }
                if($parentId){
                ?>
                <li><span class="last_li">
                    <select name="multiAction" class="multi_action">
                        <option value="">Select</option>
                        <?php if($_SESSION['UTYPE']=="A") {?>
                        <option value="delete">Delete</option>
                        <?php }?>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>                
                </span></li>
                <?php
                }
            }
            else
            {
                ?><li style="text-align:center; line-height:30px">No Record Present</li><?php
            }
            ?>
        </ul>
    </div>
    <?php
    if(ceil($countRow/$limit)>1)
    {
        echo '<div class="pagination">';
       /* if($c_id)
            $pageTypee = $pageType."&dtls=".$dtls."&type=".$type."&moduleId=".$moduleId."&c_id=".$c_id;	
        else	
            $pageTypee = $pageType."&dtls=".$dtls."&type=".$type."&moduleId=".$moduleId;	*/
        
       if($c_id)
            $pageTypee = $pageType."&dtls=".$dtls."&type=".$type."&moduleId=".$moduleId."&c_id=".$c_id."&parentId=".$parentId;	
        else{
            if($parentId)
                $pageTypee = $pageType."&dtls=".$dtls."&type=".$type."&moduleId=".$moduleId."&parentId=".$parentId;	
            else
                $pageTypee = $pageType."&dtls=".$dtls."&type=".$type."&moduleId=".$moduleId;	
        }
        
        echo "<p>Page $_GET[page] Of ".ceil($countRow/$limit).'</p>';
        $pagelist = $p->pageList($_GET['page'], $pages, $pageTypee);
        if(ceil($countRow/$limit)>1)
            echo $pagelist;
        echo '</div>';
    }
    if($c_id) echo '<input name="Back" type="button" onclick="history.back(-1);" class="save_frm" value="Back" />';?>
</form>