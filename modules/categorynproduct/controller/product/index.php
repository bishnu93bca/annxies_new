<script type="text/javascript">
function show()
{
	document.getElementById('newContent').style.display = 'block'; 
}
</script>
<?php
$pobj = new adminProductClass();
$cbj = new adminCategory();

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
/*if($_SESSION['UTYPE']=="A")
{
	?>
	<ul id="breadcrumb">
	    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
	    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
	    <li><div class="button_box"><a href="javascript:void(0)" onclick="show()">Add Content</a></div></li>
	</ul>
	<?php
}
$obj = new Content();
    include("newcontent.php");

include("listview.php");
$ExtraQryStr = "1";
if($categoryId)
	$ExtraQryStr .= " and p_category='".$categoryId."'";
if($p_name)
	$ExtraQryStr .= " and p_name like '%".addslashes($p_name)."%'";*/



$ExtraQryStr = "1";

if(isset($search))
    $page = $_GET['page'] = 1;

if(isset($categoryId))
    $_SESSION['p_category'] = $categoryId;
if(isset($p_name))
    $_SESSION['p_name'] = $p_name;

if($_SESSION['p_category'])
     $ExtraQryStr .= " AND p_category='".addslashes($_SESSION['p_category'])."'";
if($_SESSION['p_name'])
     $ExtraQryStr .= " AND p_name LIKE '%".addslashes($_SESSION['p_name'])."%'";

if(isset($clear))
{   echo 'ssss';die;
	$ExtraQryStr = "1";
    $page        = $_GET['page']=1;
	$_SESSION['p_category']  = $_SESSION['p_name']= '';
}

$countRow = $pobj->productCount($ExtraQryStr);	
?>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?><span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?><span>→</span></a></li>
    <!--<li><div class="button_box"><a href="javascript:void(0)" onClick="location.href='index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&moduleId=<?php echo $moduleId;?>'">Add New</a></div></li>-->
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
    <!--<div class="form_holder info_box">
        <div class="description-line1"> 
            Category
            <?php
            if($_POST['p_category'])
                $categoryId = $_POST['p_category'];	

            $parentId = 0;
            $dataP = $cbj -> getCategoryByparentId($parentId);
            if($dataP)
            { 
                ?>
                <select name="categoryId" style="width:150px;">
                    <option value="">Select Category</option>
                    <?php
                    for($i=0; $i<sizeof($dataP); $i++)
                    {
                        if($dataP[$i]['c_id']==$_SESSION['p_category'])
                            echo '<option value="'.$dataP[$i]['c_id'].'" selected>'.$dataP[$i]['category'].'</option>';
                        else
                            echo '<option value="'.$dataP[$i]['c_id'].'">'.$dataP[$i]['category'].'</option>';	
                        $parentId = $dataP[$i]['categoryId'];
                        $nbsp = '';
                        $selectedId = $categoryId;
                        $cbj->recursiveCategory($parentId, '', $nbsp, $selectedId);
                    }	
                    ?>
                </select>
                <?php 
            }?>
            
            Product
            <input style="width:200px;" type="text" class="searchName" name="p_name" value="<?php echo $_SESSION['p_name'];?>" style=" " placeholder="Search by board / university">             
            

            <input type="submit" class="search_save_frm" style="width:auto !important; margin-top:0px;" name="search" value="Go">

            <button class="search_save_frm reset" style="width:auto !important; margin-top:0px;" name="clear" type="submit"><i class="fa fa-refresh"></i></button> 
        </div>
    </div>-->
    
    
    
    
    
    
    
    
    
    <div class="table">
        <ul class="table_head">
            <li class="sl">Sl. No.</li>
            <li class="u_name" style="width:40%">Product</li>
            <li class="t_present" style="width:20%">Category</li>
            <li class="last_li"></li>
        </ul>
        <ul class="table_elem">
			<?php
            if($countRow)
			{
                /**************************************************************
                Paging Variable Started
                ***************************************************************/
                $p = new Pager;				
                $limit=20;
                $start = $p->findStart($limit);
                if(!$page)
                    $page=1;
                /**************************************************************
                Paging Variable Ended
                ***************************************************************/
                $fetch_Details = $pobj->getProductByLimit($ExtraQryStr,$start,$limit);			
				
				$pages = $p->findPages($countRow, $limit);	
				if($page>1)
					$slNo = (($page - 1)*$limit)+1;
				else
					$slNo = 1;

				for($row=0; $row<sizeof($fetch_Details); $row++)
				{                    
					if($fetch_Details[$row]['status'] == 1)
					{
						$conStatus = '<img src="images/active.png" alt="Active" width="15" border="0" />';
						$status=0;
					}
					else
					{
						$conStatus = '<img src="images/inactive.png" alt="Inactive" width="15" border="0" />';
						$status=1;
					}
					?>
                    <li id="recordsArray_<?php echo $fetch_Details[$row]['id'];?>">
                        <span class="sl"><?php echo $slNo;?></span>
                        <span class="u_name" style="width:40%" title="<?php echo $fetch_Details[$row]['p_name'];?>"><a title="Edit" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $fetch_Details[$row]['id'];?>&page=<?php echo $page; ?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>"><?php echo substr($fetch_Details[$row]['p_name'],0,70);?></a></span>	
                        <span class="t_present" style="width:20%">
                        <?php 
                        $catName=$cbj->categoryById($fetch_Details[$row]['p_category']);                    
                        echo $catName['category'];
                        ?>
                        </span>

                        <span class="last_li">
                            
                            <a title="Change Status" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $status?>&id=<?php echo $fetch_Details[$row]['id'];?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>" ><?php echo $conStatus;?></a> 
                            
                            <a title="Edit" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $fetch_Details[$row]['id'];?>&page=<?php echo $page; ?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>"><img src="images/view.png" alt="edit" width="16" height="16" border="0" /></a>                        
                        
                            <a title="Delete"class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&id=<?php echo $fetch_Details[$row]['id'];?>&redstr=<?php echo $redirectString;?>"><img src="images/delete.png" alt="trash"  border="0" /></a>
                        </span>
                    </li>
					<?php
					$slNo++;
				}			
			}
			else
			{
				?>
				 <li style="text-align:center; line-height:30px">No Record Present</li>	
				<?php
			}
			?>
		</ul>
    </div>
    <?php if(ceil($countRow/$limit)>1) {?>
    <div class="pagination">
        <?php	
        //echo $pageTypee =  $pageType."&dtls=".$dtls."&type=Product&moduleId=".$moduleId;	
        echo "<p>Page $_GET[page] Of ".ceil($countRow/$limit).'</p>';
        $pagelist = $p->pageList($_GET['page'], $pages, $pageTypee);
        if(ceil($countRow/$limit)>1)
            echo $pagelist;
        ?>
    </div>
    <?php }?>
</form>