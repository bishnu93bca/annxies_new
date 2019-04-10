<div class="h-box-100">
    <div class="h-heading">Samples</div>
    <div class="clear"></div>
    <div class="h-table">  
        <?php      
        $p     = new Pager;	    
        $limit = 10;	
        $start = $p->findStart($limit); 
        
        $countRow = $smplCount;
        $pages    = $p->findPages($countRow, $limit);
        if(!$page)
            $page=1;
        if($page>1)
            $slNo = (($page - 1)*$limit)+1;
        else
            $slNo = 1;
        
        echo $eObj->readsample($_SESSION['FUSERID'], $slNo,  $start, $limit);
        ?>  
        <div id="succ" class="col-md-12 alert alert-success" style="display:none"></div>
        <div id="prev" class="margintop30"></div>
        <?php 
        if($countRow>0)
        { 
            echo ' <div class="pagination">';
                if(ceil($countRow/$limit)>1)
                    echo '<p class="total">Page '.$_GET[page]. ' of '.ceil($countRow/$limit).'</p>';
                $p = new Pager;	
                $pagelist = $p->pageList($_GET['page'], $_SERVER['REDIRECT_URL'], $pages);	

                if(ceil($countRow/$limit)>1)
                    echo $pagelist;
            echo '</div>';
        }
        ?>
    </div>    
</div>
<div class="clear"></div>
<div id="sadrzaj"></div>
<?php /*

<div class="h-box-100 minheight p0">
    <div class="h-heading">Samples</div>
    <div class="clear"></div>
    <div class="h-table">  
        <?php      
        $p     = new Pager;	    
        $limit = 10;	
        $start = $p->findStart($limit); 
        
        $countRow = $smplCount;
        $pages    = $p->findPages($countRow, $limit);
        if(!$page)
            $page=1;
        if($page>1)
            $slNo = (($page - 1)*$limit)+1;
        else
            $slNo = 1;
        ?> 
        <div class="smplBox fleft">
            <div class="search_form">
                <form method="get" id="srch_frm">
                    <input type="text" autocomplete="off" placeholder="Search" name="search" id="srch_txt" value="" class="form-control">
                    <div id="pname" class="autosearch"></div>
                </form>
            </div>
        </div>
        <div class="smplBox fright">
            <div class="">
                <button type="button" data-page="addsample" data-id="'.$comData['id'].'" class="btn btn-default btn-black addSample mr10" value="'.$id_user.'>'.$numr.'" >Add New Sample</button>                    
            </div>
        </div>
    </div>    
</div>
<div class="h-box-100 minheight p0">
    <div class="h-heading">Approved Samples</div>
    
<?php
echo $eObj->readapprovedsample($id_user, $slNo, $start, $limit);
?>
    <div class="clear"></div>
    <div class="h-table">  
    </div>
</div>
        
        
<div class="clear"></div>
<div id="sadrzaj"></div>*/?>