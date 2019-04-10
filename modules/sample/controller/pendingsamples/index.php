<?php
$menu   = new menu();
$mobj   = new MemberAdmin();
$menudata= $menu -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image = $menudata['menu_image'];
	$menu_name = $menudata['menu_name'];
	$parentMenuId = $menudata['parent_id'];
	$parentmenudata= $menu -> menu_by_id($parentMenuId);
	$parent_menu_name = $parentmenudata['menu_name'];
}
$ExtraQryStr= "isApproved!='Sample Received'";

if ($srchtxt)
	$_SESSION['srchtxt'] = $srchtxt;
if($_SESSION['srchtxt'])
    $ExtraQryStr .= " AND sampleReqId='".$_SESSION['srchtxt']."'";
	
$countRow   = $mobj->sampleCount($ExtraQryStr);
 
if(isset($clear))
{
	$_SESSION['srchtxt'] 	= '';
    $ExtraQryStr= "isApproved!='Sample Received'";
}

if($_SESSION['ErrMsg'])
{
	echo $_SESSION['ErrMsg'];
	unset($_SESSION['ErrMsg']);
} 
?>

<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
    <li><p>Recouds found: <?php echo $countRow;?></p></li>
</ul>

<form method="POST" name="myForm_search" action="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&username=<?php echo $username;?>&moduleId=<?php echo $moduleId;?>">
	<div class="form_holder">
        <p class="description-line1">
            <input type="text" name="srchtxt" placeholder="Search by request id" value="<?php echo $_SESSION['srchtxt'];?>" style="width:300px;" autocomplete="off">
        
            <input type="submit" name="search_order" value="Search" class="search_save_frm" style="width:auto !important; margin-top:0px;" />

            <input type="submit" name="clear" value="Reset" class="search_close_frm" style="width:auto !important; margin-top:0px;" />
        </p>
    </div>
    <input type="hidden" name="Sourceform" value="refine_search_order">
</form>

<div class="table">
	<ul class="table_head">
        <li class="sl" style="width:5%">Sl.</li>
        <li class="u_name" style="width:15%">Porduct</li>
        <li class="u_name" style="width:10%">Description</li>
        <li class="u_name" style="width:12%">Qty</li> 
        <li class="t_days" style="width:12%">Order Value</li> 
        <li class="t_days" style="width:10%">Date</li>  
        <li class="t_days" style="width:15%">Status</li>  
        <li class="t_days" style="width:10%">Request ID</li>  
        <li class="last_li"></li>
    </ul>
    <ul class="table_elem">
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

            $fetch_Details = $mobj ->getSampleByLimit($ExtraQryStr, $start, $limit);
            //echo '<pre>';print_r($fetch_Details);echo '</pre>';

			$pages = $p->findPages($countRow, $limit);
                if($page>1)
                    $No = (($page - 1)*$limit)+1;
                else
                    $No = 1;
            
            foreach($fetch_Details as $pData)
			{
				if($pData['isApproved'] == 'Y')
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
                <li id="recordsArray_<?php echo $pData['sampleId'];?>">
                    <span style="width:5%" class="sl"><?php echo $No;?></span>
                    <span class="u_name" style="width:15%">
                        <a title="<?php echo $pData['productName'];?>" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $pData['sampleId'];?>&sampleId=<?php echo $pData['sampleId'];?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>">
                            <?php 
                            if($pData['productName']){
                             if(strlen($pData['productName'])>35)
                                echo substr($pData['productName'],0,33).'...'; 
                            else
                                echo $pData['productName'];
                            }
                            ?>
                        </a>
                    </span>
                    <span class="u_name" style="width:10%">
                        <a title="<?php echo $pData['description'];?>" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $pData['sampleId'];?>&sampleId=<?php echo $pData['sampleId'];?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>">
                            <?php 
                            if($pData['description']){
                             if(strlen($pData['description'])>35)
                                echo substr($pData['description'],0,33).'...'; 
                            else
                                echo $pData['description'];
                            }
                            ?>
                        </a>
                    </span>
                    <span class="u_name" style="width:12%"> <?php echo $pData['qty'].' '.$pData['unitType'];?></span>
                    <span class="t_days" style="width:12%"> <?php echo $pData['range1'].' ~ '.$pData['range2'].' '.$pData['currency'];?></span>
                    <span class="t_days" style="width:10%"> <?php echo date('d.m.Y',strtotime($pData['entryDate']));?></span>
                    <span class="t_days" style="width:15%" title="<?php echo $pData['isApproved'];?>">
                        <?php 
                        if($pData['isApproved']){
                         if(strlen($pData['isApproved'])>25)
                            echo substr($pData['isApproved'],0,22).'...'; 
                        else
                            echo $pData['isApproved'];
                        }
                        ?>
                    </span>
                    <span class="t_days" style="width:10%"> <?php echo $pData['sampleReqId'];?></span>
                    <span class="last_li">
                        
                        <a href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $pData['sampleId'];?>&sampleId=<?php echo $pData['sampleId'];?>&page=<?php echo $page; ?>&parentId=<?php echo $parentId;?>&moduleId=<?php echo $moduleId;?>&type=<?php echo $type;?>" title="edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0" /></a>
                        <?php /*                 
                        <a title="Change Status" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=status&stschgto=<?php echo $status?>&id=<?php echo $pData['sampleId'];?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>" ><?php echo $conStatus;?></a> 
                                
                        <a class="ask"  href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=delete&id=<?php echo $pData['sampleId'];?>&pid=<?php echo $pData['proId'];?>&redstr=<?php echo $redirectString;?>" title="delete"><img src="images/delete.png" alt="" width="16" height="16" border="0" /></a>*/?>
                    </span>
                </li>
                <?php
            $No++;
		}
	}
	else
	{
		?><li style="text-align:center; line-height:30px;">No Record Present</li><?php
	}
	?>
	</ul>
</div>

<?php
if(ceil($countRow/$limit)>1)
{
    echo '<div class="pagination">';
    if($categoryId)
        $pageTypee = $pageType."&dtls=".$dtls."&type=".$type."&moduleId=".$moduleId."&categoryId=".$categoryId;	
    else	
        $pageTypee = $pageType."&dtls=".$dtls."&type=".$type."&moduleId=".$moduleId;	
    echo "<span>Page $_GET[page] Of ".ceil($countRow/$limit).'</span>';
    $pagelist = $p->pageList($_GET['page'], $pages, $pageTypee);
    if(ceil($countRow/$limit)>1)
    {
        echo $pagelist;
    }
    echo '</div>';
}
?>	
