<?php
$fData = $eObj->uploadedFiles($_SESSION['FUSERID'], 1, 0, 30);
?>
<div class="college_list doc_list image_list">
    <ul class="col4 clearfix">
        <?php 
        foreach($fData as $file){
            include("doc_item.php");
        }?>
    </ul>
</div>