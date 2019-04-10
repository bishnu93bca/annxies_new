<?php
$menu       = new menu();
$cObj       = new MemberAdmin;
$menudata   = $menu -> menu_by_id($moduleId);
if($menudata)
{
	$menu_image        = $menudata['menu_image'];
	$menu_name         = $menudata['menu_name'];	
	$parentMenuId      = $menudata['parent_id'];
	$parentmenudata    = $menu -> menu_by_id($parentMenuId);	
	$parent_menu_name  = $parentmenudata['menu_name'];
}

if($editid){
	$cData    		= $cObj->getMemberInfoByid($editid);
    $company   		= $cObj->getCompanyInfoByuserid($id);
    $memberShip		= $cObj->getMembershipInfoByuserid($id);
}

?>
<ul id="breadcrumb">
    <li><a href="#"><?php echo $menu_name;?> <span>→</span></a></li>
    <li><a href="#"><?php echo $parent_menu_name;?></a></li>
</ul>

<?php echo $ErrMsg;
if($editid){
	include("intro.php");
}
?>

<form name="orderfrm" action="" method="post" enctype="multipart/form-data" class="form-middlegap" style="overflow: hidden;">
	<div class="">
		<div class="form_holder">
            <?php
            if($sampleId!='')
            {
                $productId     = $sampleId;
                $fetch_details = $obj->sampleById($sampleId);
                $IdToEdit      = $fetch_details['sampleId'];
                $productName   = $fetch_details['productName'];
                $p_keyword     = $fetch_details['p_keyword'];
                $description   = $fetch_details['description'];
                $productImage  = $fetch_details['productImage'];	
                $qty           = $fetch_details['totalQty'];	
                $currency      = $fetch_details['currency'];	
                $range1        = $fetch_details['range1'];	
                $range2        = $fetch_details['range2'];	
            }
            include 'product-info.php';
            ?>
            
            
            <div class="table examTable">        
                <ul class="table_head ui-sortable">
                    <li class="sl">Sl.</li>
                    <li class="sl" style="width:20%">Date</li>
                    <li class="sl" style="width:20%">Debit Items</li>
                    <li class="sl" style="width:15%">Credits Items</li>
                    <li class="sl" style="width:15%">In Stock</li> 
                </ul>

                 <ul class="table_elem">
                    <?php
                    $ExtraQryStrq = "sampleId=".addslashes($sampleId);
                    $sampleQty    = $cObj->getSampleQtyDetails($ExtraQryStrq, 0, 99999);
                    if($sampleQty)
                    {
                        $slNo=1;
                        foreach($sampleQty as $sQty)
                        {   
                            if($sQty['ct']!=0)
                                $qc= $sQty['ct'].' BAGS';
                            else
                                $qc='-';
                            if($sQty['dt']!=0)
                                $qd= $sQty['dt'].' BAGS';
                            else
                                $qd='-';
                            ?>
                             <li>
                                <span class="sl"><?php echo $slNo;?></span>      
                                <span class="sl" style="width:20%"><?php echo date('d.m.Y',strtotime($sQty['entryDate']));?></span>    
                                <span class="sl" style="width:20%"><?php echo $qd;?></span>   
                                <span class="sl" style="width:15%"><?php echo $qc;?></span>    
                                <span class="sl" style="width:15%"><?php echo $sQty['inStock'];?> BAGS</span>  
                            </li>
                            <?php
                            $slNo++;
                        }
                    }
                    else
                        echo '<li align="center">No records found !</li>';
                    ?>
                </ul>
            </div>
            
            
            
            
               <!-- <div class="examTable">   
                    
                    <table>
                        <tr>
                            <th>Quiz Question</th>    
                            <th>Currect Answer</th>    
                            <th>Answer Given</th>    
                            <th>Marks Obtained</th>    
                        </tr>
                        <?php
                        foreach($ExData as $examData)
                        {
                            ?>
                            <tr>
                                <td><?php echo $examData['question'];?></td>    
                                <td><?php echo $examData['answer'];?></td>    
                                <td><?php echo $examData['answerGiven'];?></td>    
                                <td><?php echo $examData['marks'];?></td> 
                            </tr>
                            <?php                    
                        }
                        ?>
                        <tr><th colspan="3">Total Marks Obtained</th><th><?php echo $ExData[0]['marksObtained'];?></th> </tr>
                    </table>
                </div>	-->		
		</div>
	</div>

   
		
    <br class="clear">
    <input name="Back" type="button" onclick="history.back(-1);" class="back"  value="Back" />

</form>