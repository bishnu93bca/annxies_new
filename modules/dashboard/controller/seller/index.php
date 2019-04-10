<?php
$cObj    = new MemberAdmin;
$menu    = new menu;
$menudata= $menu -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image        = $menudata['menu_image'];
	$menu_name         = $menudata['menu_name'];
	$parentMenuId      = $menudata['parent_id'];
	$parentmenudata    = $menu -> menu_by_id($parentMenuId);
	$parent_menu_name  = $parentmenudata['menu_name'];
}

$ExtraQryStr = "m.usertype='Seller'";

if ($srchtxt)
	$_SESSION['srchtxt'] = $srchtxt;
if($_SESSION['srchtxt'])
    $ExtraQryStr .= " and (m.username='".addslashes($_SESSION['srchtxt'])."' or  m.name='".addslashes($_SESSION['srchtxt'])."' or  m.surname='".addslashes($_SESSION['srchtxt'])."' or m.email='".addslashes($_SESSION['srchtxt'])."')";

if(isset($clear))
{
	$_SESSION['srchtxt'] 	= '';
	$ExtraQryStr 			= "1";
}
$ExtraQryStrc = "usertype='Seller'";
$countRow = $cObj->sellerCount($ExtraQryStrc);	
?>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?><span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
    <li><p>Recouds found: <?php echo $countRow;?></p></li>
</ul>
<?php 
if($_SESSION['ErrMsg'])
{
	echo $_SESSION['ErrMsg'];
	unset($_SESSION['ErrMsg']);
}?>
<form method="POST" name="myForm_search" action="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&username=<?php echo $username;?>&moduleId=<?php echo $moduleId;?>">
	<div class="form_holder">
        <p class="description-line1">
            <input type="text" name="srchtxt" placeholder="Search by full name or username or email" value="<?php echo $_SESSION['srchtxt'];?>" style="width:300px;" autocomplete="off">
        
            <input type="submit" name="search_order" value="Search" class="search_save_frm" style="width:auto !important; margin-top:0px;" />

            <input type="submit" name="clear" value="Reset" class="search_close_frm" style="width:auto !important; margin-top:0px;" />
        </p>
    </div>
    <input type="hidden" name="Sourceform" value="refine_search_order">
</form>

<form action="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>" name="myForm" method="POST">
	<div class="table">
		<ul class="table_customer">
            <?php  
            if($countRow)
            {
                /**************************************************************
                Paging Variable Started
                ***************************************************************/
                $p      = new Pager;	
                $limit  = 20;
                $start  = $p->findStart($limit);
                if(!$page)
                    $page=1;
                /**************************************************************
                Paging Variable Ended
                ***************************************************************/

                $fetch_Details = $cObj -> getSellerDetails($ExtraQryStr, $start, $limit);
                $pages = $p->findPages($countRow, $limit);
                if($page>1)
                    $slNo = (($page - 1)*$limit)+1;
                else
                    $slNo = 1;

                foreach($fetch_Details as $cData)
                {      
                    ?>
                    <li>
                        <?php include("intro.php");?>				  
                    </li>
                    <?php
                    $slNo++;
                }
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
	<?php if(ceil($countRow/$limit)>1) {?>
    <div class="pagination">
        <?php	
        $pageTypee =  $pageType."&dtls=".$dtls."&type=".$type."&moduleId=".$moduleId;	
        echo "<p>Page $_GET[page] Of ".ceil($countRow/$limit).'</p>';
        $pagelist = $p->pageList($_GET['page'], $pages, $pageTypee);
        if(ceil($countRow/$limit)>1)
            echo $pagelist;
        ?>
    </div>
    <?php }?>		
</form>