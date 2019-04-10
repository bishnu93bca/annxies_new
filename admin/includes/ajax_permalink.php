<?php
if($_POST['ajax']){
    include("../../ext_include.php");
    //permalink--------------
    if($IdToEdit)	
        $ExtraQryStr = 'categoryId!='.$IdToEdit.' and parentId='.$parentId;	
    else	
        $ExtraQryStr = 'parentId='.$parentId;		
    echo $permalink = createPermalink($ENTITY, $permalink, $ExtraQryStr);
    //permalink---------------
}
?>