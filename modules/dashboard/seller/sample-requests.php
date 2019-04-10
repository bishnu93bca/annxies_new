<div class="h-box-100">
    <div class="h-heading">Sample Requests</div>

    <div class="h-table">  
        <?php      
        $p     = new Pager;	    
        $limit = 10;	
        $start = $p->findStart($limit); 
        
        $countRow = $smplRCount;
        $pages    = $p->findPages($countRow, $limit);
        if(!$page)
            $page=1;
        if($page>1)
            $slNo = (($page - 1)*$limit)+1;
        else
            $slNo = 1;
        
        echo $eObj->readSampleRequest($_SESSION['FUSERID'], $slNo, $start, $limit);
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
    </div><!-- col-md-9 -->  
    
</div><!-- end row -->
<div class="clear"></div>
<div id="sadrzaj"></div>