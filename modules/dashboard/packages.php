<?php 
$mbObj   = new MemberView();
$package = $mbObj->getPackageBypermalink($dtaction);
?>
    <div class="tag_line">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="welcome"> 
                         <h2><strong><?php echo $package['name'];?> Membership package</strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main_content_area">
        <div class="container"> 
             <div class="h-greysmall">
                <div class="h-padding">
                    <?php 
                    echo '<h1>';
                        if(file_exists($ROOT_PATH.'/uploadedfiles/package/large/'.$package['image']) && $package['image'])
                            echo '<img src="'.$MEDIA_FILES_SRC.'/package/large/'.$package['image'].'" alt="'.$package['name'].'">';
                       
                        echo ' '.$package['name'].' Membership -'. SITE_CURRENCY_SYMBOL.number_format($package['price'],2).'/mo';
                    
                    echo '</h1>';
                    echo ($package['smallnote'])? '<br><div class="silder_top"><h4>'.$package['smallnote'].'</h4></div>':'';
                    
                    if($package['description'])
                        echo $package['description'];
                    
                    if($dtaction=='standard')
                        $mem = 4;
                    elseif($dtaction=='silver')
                        $mem = 1;
                    elseif($dtaction=='gold')
                        $mem = 2;
                    elseif($dtaction=='platinum')
                        $mem = 3;
                    if($_SESSION['FUSERLOGIN']!='ok'){ 
                    ?> 
                    <span class="red_links">
                        <a href="<?php echo $SITE_LOC_PATH.'/register/'.$package['permalink'].'/';?>" class="buynowbtn" title="Book Now"><button class="btn btn-small btn-primary">Buy Now</button></a>
                    </span>
                    <?php } ?>
                 </div>                   
              </div>
              <?php include TMPL_PATH.'/inc/sidebar.php';?>                  
        </div>
    </div>
</div>  