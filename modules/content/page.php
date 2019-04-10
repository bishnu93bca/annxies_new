<?php
$obj        = new ContentView();  
if($categoryId == 21){
    include("about-annexis.php");
}
elseif($categoryId == 22){
    include($ROOT_PATH.'/'.MODULE_PATH.'/blog/index.php');
}
elseif($categoryId == 23){
    include($ROOT_PATH.'/'.MODULE_PATH.'/testimonial/index.php');
}
else{
    //Pagination Variable Section Start
    $p         = new Pager;
    $limit     = 15;
    if($view=='all')
        $limit = 999;
    $start     = $p->findStart($limit);
    //Pagination Variable Section End
      
    $selData    = $obj->getContentbymenucategoryId($categoryId, $start, $limit);
    $countRow   = $obj->countContentbymenucategoryId($categoryId);
    $pages      = $p->findPages($countRow, $limit);
    if(sizeof($selData)>0) 
    {	
        for($i=0;$i<sizeof($selData);$i++) 
        {	
            
            if($selData[$i]['displayHeading']=='Y')
            {
                echo '<div class="tag_line">
                        <div class="container">
                          <div class="row1">
                            <div class="span12">
                              <div class="welcome">
                                <h2> <strong>'.$selData[$i]['contentHeading'].'</strong> </h2>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div> ';
            }  

            echo '<div class="main_content_area">';

                if(file_exists($MEDIA_FILES_ROOT.'/menu/large/'.$selData[$i]['ImageName']) && $selData[$i]['ImageName'])
                    echo '<div class="webdesign-img"><img src="'.$MEDIA_FILES_SRC.'/menu/large/'.$selData[$i]['ImageName'].'" alt="'.$selData[$i]['contentHeading'].'"/></div>';

                echo '<div class="container">'.$selData[$i]['contentDescription'];

                if(!in_array($categoryId,[25,30,31,32,41,42,43,60,61,62,63,65,66]))
                    include TMPL_PATH.'/inc/sidebar.php';

                echo '</div>';
                if($categoryId == 41)
                    echo '<div class="margin-bottom"></div>';
            echo '</div>';
          
            
        }
        

        if($categoryType=='List View' && $id=='' ) 
        {
            if($countRow>0 && ceil($countRow/$limit)>1)
            {
                echo '<div class="pagination">';		
                echo '<p class="pagelist">Page '.$_GET['page'].' of '.ceil($countRow/$limit).' | </p>';
                $pagelist = $p->pageList($_GET['page'], $_SERVER['REDIRECT_URL'], $pages);
                echo $pagelist." | <a href='?view=all'>View All</a>";		
                echo '</div>';
            }
        }
    }
}
?>