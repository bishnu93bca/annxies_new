<style>
    .rev_cmt_cntr .rev_cmt_stngs {
        position: absolute;
        top: 21px;
        right: 5px;
        min-width: 60px;
        text-align:right;
    }
    .rev_cmt_cntr{
        position:relative;
    }
    .rev_cmt_cntr fieldset{
        background: #FFFFFF;
    }
    .rev_cmt_cntr legend{
        background: #cccccc;
    }
    .revPrdt td{
        padding:5px;
        vertical-align:top;
    }
    .revPrdt td img{
        width:auto;
        height:108px;
    }
    .revPrdt td h1{
        font-size:25px;
        margin-bottom:15px;
        margin-top:4px;
    }
    .revPrdt td h2{
        font-size:16px;
        margin-bottom:12px;
    }
    .star span {
        background: url("images/sprite.png") no-repeat scroll -58px -3px transparent;
        cursor: pointer;
        height: 15px;
        margin-right: 1px;
        width: 16px;
        display:inline;
    }
    .star span.star_green {
        background-position: -38px -2px;
    }
</style>
<?php
$obj        = new adminProductClass();
$reviews    = $obj -> getReviewByProductId($viewid);
$prdtData   = $obj -> productById($viewid);
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
?>	
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?><span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
</ul>


<div class="form_holder">
    <div class="revPrdt">
        <table>
            <tr>
                <td>
                    <?php
                    if(file_exists($MEDIA_FILES_ROOT.'/products/large/'.$prdtData['productImage']) && $prdtData['productImage'])
                        echo '<img src="'.$MEDIA_FILES_SRC.'/products/large/'.$prdtData['productImage'].'" alt="'.$pData['productName'].'"  width="150" height="200" />';
                    else
                        echo '<img src="'.$STYLE_FILES_SRC.'/images/no-image.jpg" alt="'.$pData['productName'].'" width="150" height="200" />';
                    ?>
                </td>
                <td>
                    <h1><a title="Edit" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&dtaction=add&editid=<?php echo $viewid;?>&page=<?php echo $page; ?>&moduleId=<?php echo $moduleId;?>&redstr=<?php echo $redirectString;?>"><?php echo $prdtData['productName'];?></a></h1>
                    <h2>SKU : <?php echo $prdtData['productCode'];?></h2>
                    <h2>Price : <?php echo SITE_CURRENCY_SYMBOL.$prdtData['productPrice'];?></h2>
                    <h2>Selling Price : <?php echo SITE_CURRENCY_SYMBOL.$prdtData['productDiscountedPrice'];?></h2>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="form_holder">
    <div>   
    <?php
    foreach($reviews as $rk=>$rv){
        if($reviews[$rk]['status'] == 'Y')
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
        <div class="rev_cmt_cntr">
            <div class="rev_cmt_stngs">
                <a title="Change Status" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&statusaction=yes&rwvaction=yes&dtaction=status&stschgto=<?php echo $status?>&id=<?php echo $reviews[$rk]['reviewId'];?>&page=<?php echo $page; ?>&redstr=<?php echo $redirectString;?>" ><?php echo $conStatus;?></a>
                								
                <a title="Delete"class="ask" href="index.php?pageType=<?php echo $pageType;?>&dtls=<?php echo $dtls;?>&revdeleteaction=yes&action=cndImage&dtaction=delete&id=<?php echo $reviews[$rk]['reviewId'];?>&redstr=<?php echo $redirectString;?>"><img src="images/delete.png" alt="trash"  border="0" /></a>
                
            </div>
            <fieldset>
                <legend><?php echo $reviews[$rk]['customerName'].' ( '.$reviews[$rk]['customerEmail'].' )';?></legend>

                <p><?php echo $reviews[$rk]['review'];?></p>
                <div class="star">
                    <?php
                    for($j=1;$j<=5;$j++)
                    {
                        ?>
                        <span<?php if($j<=$reviews[$rk]['rate']) echo ' class="star_green"';?>></span>
                        <?php
                    }
                    ?>
                </div>
            </fieldset>
        </div>
        <?php
    }
    ?>    
    </div>
</div>