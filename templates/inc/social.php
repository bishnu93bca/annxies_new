<?php 
$contObj    = new ContentView();
$CntData    = $contObj->getContentBycontentID(6);
?>
<ul class="f_nav">
    <?php if($CntData['fb']){ ?>
        <li><a href="<?php echo $CntData['fb'];?>" rel="nofollow" target="_blank">Facebook</a></li>
    <?php } if($CntData['tw']){ ?>
        <li><a href="<?php echo $CntData['tw'];?>" rel="nofollow" target="_blank">Twitter</a></li>
    <?php } if($CntData['linkd']){ ?> 
        <li><a href="<?php echo $CntData['linkd'];?>" rel="nofollow" target="_blank">LinkedIn</a></li>
    <?php } if($CntData['gp']){ ?>
        <li><a href="<?php echo $CntData['gp'];?>" rel="nofollow" target="_blank">Google Plus</a></li>
    <?php } ?>
</ul>