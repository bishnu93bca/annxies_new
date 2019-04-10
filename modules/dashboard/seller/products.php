<div class="h-box-100">
    <div class="h-heading">Products / Service</div>
    <div class="h-table">  
        <?php
        $p = new Pager;	    
        $limit = 5;	
        
        $start = $p->findStart($limit); 
        
        $countRow = $eObj->nrproduct($_SESSION['FUSERID']);
        $pages    = $p->findPages($countRow, $limit);
        if(!$page)
            $page=1;
        if($page>1)
            $slNo = (($page - 1)*$limit)+1;
        else
            $slNo = 1;
        
        echo $eObj->readproduct($_SESSION['FUSERID'], $slNo, $start, $limit);
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
<div id="sadrzaj"><!--<div class="alert alert-warning" role="alert"></div>--></div>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width:50%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Preview</h4>
         
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>