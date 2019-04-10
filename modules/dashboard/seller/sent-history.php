<div class="h-box-100 minheight p0">
    <div class="h-heading">Sample Sent History</div>
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

                echo '<td><div class="smplImg">'.$img.'</div>';

                if($smData['p_keyword'])
                    $ky = '<div class="keyWrd">SKU# '.$smData['p_keyword'].'</div>';
                else
                    $ky = '';

                echo '<div>'.$smData['productName'].$ky.'</div></td>';
                    
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
$ExtraQryStrq = "proId=".addslashes($smData['proId'])." AND sendStatus='Approved'";

$p     = new Pager;	    
$limit = 10;	
$start = $p->findStart($limit); 

$countRow     = $eObj->sampleHistoryCount($ExtraQryStrq);

$pages    = $p->findPages($countRow, $limit);
if(!$page)
    $page=1;
if($page>1)
    $slNo = (($page - 1)*$limit)+1;
else
    $slNo = 1;


$sampleQty    = $eObj->getSampleHistory($ExtraQryStrq, $start, $limit);
?>
<div class="h-box-100 minheight p0 sm-Box">  
    <div class="h-table p0">  
        <div class="form-group clearfix">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Request #</th>
                    <th>Sent To</th>
                    <th>Qty. Sent</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php      
                    if($sampleQty)
                    {
                        foreach($sampleQty as $sQty){
                        
                            if($sQty['ct']!=0)
                                $qc= $sQty['ct'].' BAGS';
                            else
                                $qc='-';
                            if($sQty['dt']!=0)
                                $qd= $sQty['dt'].' BAGS';
                            else
                                $qd='-';
                           echo '<tr class="" style="">
                                <td>'.$slNo.'</td>
                                <td>'.date('d.m.Y',strtotime($sQty['contactEntrydate'])).'</td>
                                <td>'.$sQty['requestId'].'</td>
                                <td>'.$sQty['name'].'<div>'.$sQty['uadd'].'</div></td>
                                <td>'.$sQty['qty'].' BAGS</td>
                                <td><a class="viewhistory" data-id="'.$sQty['contactID'].'" data-page="viewhistory" style="cursor:pointer"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="View"></span> View</a></td>
                              </tr>';
                            $slNo++;
                        }                        
                    }
                    else
                        echo '<tr><td align="center" colspan="7">No records found.</td></tr>';
                    
                    ?>
                </tbody>
            </table>
        </div>
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
<div class="clear"></div>
<div id="sadrzaj"></div>