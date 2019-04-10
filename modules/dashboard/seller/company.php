<?php
if($page =='addcompany')
    $eObj->sendcompanydata($_SESSION['FUSERID']); 
// elseif($page =='company')
//     $eObj->showCompanyCatagory();
else
{
    ?>
    <div class="h-box-100">
        <div class="h-heading">Company </div>

        <div class="col-md-12">  
            <div class="row">
                <div class="col-md-12">  
                    <?php echo $eObj->readcompany($_SESSION['FUSERID']);?>

                </div>

            </div>
              </div>
    </div>
    <?php
}
?>