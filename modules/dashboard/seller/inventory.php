<div class="h-box-100 minheight p0">
    <div class="h-heading">Sample Blance History</div>
    <div class="clear"></div>
    <div class="h-table">
        <div class="clearfix">
            <table class="table noBorder">
                <tr>
                <?php
                $smData=$eObj->getSampleBypermalink($sample);

                if(file_exists(UPFLD.'/product/thumb/'.$smData['productImage']) && $smData['productImage'])
                {
                    $img='<img src="'.SHWFL.'/product/thumb/'.$smData['productImage'].'" width="60px; class="thumbnail">';
                }
                elseif(file_exists(UPFLD.'/sample/thumb/'.$smData['productImage']) && $smData['productImage'])
                {
                    $img='<img src="'.SHWFL.'/sample/thumb/'.$smData['productImage'].'" width="60px; class="thumbnail">';
                }

                echo '<td><a href="'.SITEDASH.'/samples/inventory/?sample='.$smData['permalink'].'"><div class="smplImg">'.$img.'</a></div>';

                if($smData['p_keyword'])
                    $ky = '<div class="keyWrd">SKU# '.str_replace(",",", ",$smData['p_keyword']).'</div>';
                else
                    $ky = '';

                echo '<div><a href="'.SITEDASH.'/samples/inventory/?sample='.$smData['permalink'].'">'.$smData['productName'].'</a>'.$ky.'</div></td>';

                if($dtaction=='inventory')
                    $act = 'btn-default btn-gray';
                else
                    $act = 'btn-primary';
                if($dtaction=='sent-history')
                    $act2 = 'btn-default btn-gray';
                else
                    $act2 = 'btn-primary';


                echo '<td align="right"><a href="'.SITEDASH.'/samples/inventory/?sample='.$smData['permalink'].'" class="mr10" data-id="'.$smData['sampleId'].'" data-page="" style="cursor:pointer"><span class="btn '.$act.'" data-placement="top" title="Inventory">Inventory</span></a>
                <a href="'.SITEDASH.'/samples/sent-history/?sample='.$smData['permalink'].'" class="" data-id="'.$smData['sampleId'].'" data-page="" style="cursor:pointer">
                <span class="btn '.$act2.'" title="Sent History">Sent History</span></a></td>';

                ?>
                </tr>
            </table>
        </div>
    </div>   
</div>
<?php    
$p     = new Pager;	    
$limit = 10;	
$start = $p->findStart($limit); 
$ExtraQryStrq = "sampleId=".addslashes($smData['sampleId']);

$countRow     = $eObj->sampleTransuctionCount($ExtraQryStrq);
$pages    = $p->findPages($countRow, $limit);
if(!$page)
    $page=1;
if($page>1)
    $slNo = (($page - 1)*$limit)+1;
else
    $slNo = 1;

$sampleQty    = $eObj->getSampleQty($ExtraQryStrq, $start, $limit);
?>
<div class="h-box-100 minheight p0 sm-Box"> 
    <?php if($sampleQty){ ?> 
    <div class="p15 clearfix">
        <button type="button" data-page="addqty" class="btn btn-primary pull-right addqty" value="<?php echo $smData['sampleId'];?>" >Add Quantity</button>
    </div> 
    <?php } ?>
    <div class="clear"></div>

    <div class="h-table p0">  
        <div class="form-group clearfix">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th align="center">#</th>
                    <th align="center">Date</th>
                    <th align="center">Debit Items</th>
                    <th align="center">Credits Items</th>
                    <th align="center">In Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($sampleQty){

                        foreach($sampleQty as $sQty){

                            if($sQty['ct']!=0)
                                $qc= $sQty['ct'].' BAGS';
                            else
                                $qc='-';
                            if($sQty['dt']!=0)
                                $qd= $sQty['dt'].' BAGS';
                            else
                                $qd='-';
                           echo '<tr>
                                <td align="center">'.$slNo.'</td>
                                <td align="center">'.date('d.m.Y',strtotime($sQty['entryDate'])).'</td>
                                <td align="center">'.$qd.'</td>
                                <td align="center">'.$qc.'</td>
                                <td align="center">'.$sQty['inStock'].' BAGS</td>
                              </tr>';
                            $slNo++;
                        }
                    }
                    else
                        echo '<tr><td align="center" colspan="6">No records found.</td></tr>';
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php 
    if($countRow>0)
    { 
        $smLink = $_SERVER['REDIRECT_URL'].'?sample='.$sample;

        echo ' <div class="pagination">';
            if(ceil($countRow/$limit)>1)
                echo '<p class="total">Page '.$_GET[page]. ' of '.ceil($countRow/$limit).'</p>';
            $p = new Pager;	
            $pagelist = $p->samplepageList($_GET['page'], $smLink, $pages);	

            if(ceil($countRow/$limit)>1)
                echo $pagelist;
        echo '</div>';
    }
    ?>
</div>
<div class="clear"></div>
<div id="sadrzaj"></div>