<div class="clearfix h-box-style">
    <div class="col-md-6">
        <?php if($planData['plan']!='standard')
        {
            ?>       
            <p class="text-warning">Virtual Office Location</p>
            <address>
                <?php echo '<b>'.$planData['office_city'].'</b><br>'.$planData['office'];?>
            </address>
            <?php
        }
        ?>
    </div>

    <div class="col-md-6 text-right">
        <h2 class="username"><?php echo $planData['name'].' '.$planData['surname'];?></h2>
    </div>
</div>

<div class="clearfix mb25">
    <div class="h-box-33">
        <span class="h-heading">Membership Package</span>
        <div class="h-box-padding"><img src="<?php echo $STYLE_FILES_SRC.'/images/badge-'.strtolower($planData['plan']).'.png';?>" class="img-responsive"></div>
    </div>  

    <div class="h-box-33 margin">
        <span class="h-heading">Current Plan</span>
        <div class="h-box-padding">
            <h1><?php echo $planData['mjesec'];?></h1>
            <h3>month</h3>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $planData['posto'];?>" aria-valuemin="0" aria-valuemax="100" 
                style="width: <?php echo $planData['posto'];?>%;">
                    <?php echo $planData['posto'];?>%
                </div>
            </div> 
            <?php echo ($planData['ofcUse'])? '<span>'.$planData['ofcUse'].' hours / month</span>':'';?>
        </div>         
    </div>  

    <div class="h-box-33 margin">
        <span class="h-heading">Data Details</span>
        <div class="h-odd">
            <strong>Membership:</strong>
            <?php echo $planData[plan];?>    
            <a class="badge" href="upgrade.php">Manage</a>
        </div>

        <div class="h-even">
            <strong>Start Date:</strong>
            <?php echo date('M j, Y', strtotime($planData['plan_start']));?> 
        </div>
        
        <div class="h-odd">
            <strong>End Date:</strong>
            <?php echo date('M j, Y', strtotime($planData['plan_end']));?>
        </div>
        
        <div class="h-even">
            <strong>Usage:</strong>
            <?php echo $planData['used'];?> 
        </div>
    </div>  
</div>

<div class="mb25 clearfix">
    <div class="h-noti-style">
        <div class="h-heading">Notification:</div>
        <div class=" mb25"><?php echo $eObj->notification($_SESSION['FUSERID']);?></div> 
    </div>
</div>  