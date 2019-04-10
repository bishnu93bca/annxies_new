<div class="h-right">
    <div class="get-started-main">
        <h1>
          Get Started Here
        </h1>
        <form class="get-form" method="post" id="quoteBtn">
          <input type="text" placeholder="Full Name" name="name">
            <input type="text" placeholder="Email" name="email">
            <input type="text" placeholder="Phone Number" name="phone">
            <input type="text" placeholder="Product" name="product">
            <p>
              By clicking inquiry now you agree to 
              term and conditions
            </p>

            <button class="btn-submit" type="submit">Get a Quote</button>
            <input type="hidden" value="quote" name="SourceForm">
            <input type="hidden" value="1" name="ajax">
            <div class="errMsg clearfix"></div>
        </form>
    </div>
    <div class="video">
      <img src="<?php echo $STYLE_FILES_SRC;?>/images/video.png" alt="">
    <a href="" class="vidPlay">
      <img src="<?php echo $STYLE_FILES_SRC;?>/images/play.png" alt="" class="play">
    </a>
        
    <video id="annxsVid" width="100%" controls="controls" muted>
          <source src="<?php echo $STYLE_FILES_SRC;?>/assets/video/annexis.mp4" type="video/mp4">
          <source src="movie.ogg" type="video/ogg">
          Your browser does not support the video tag.
    </video>     
        
    </div>
    <?php 
    $mbsObj   = new MemberView();
    $packsd   = $mbsObj->packageList(1, 0, 4);
    if($packsd)
    {
        ?>
        <div class="services">
          <h1>
            Membership Package
          </h1>
          <ul>
            <?php
            foreach($packsd as $packs){ 
                echo '<li><a href="'.$SITE_LOC_PATH.'/membership-packages/'.$packs['permalink'].'/">';
                    if(file_exists($ROOT_PATH.'/uploadedfiles/package/large/'.$packs['image']) && $packs['image'])
                        echo '<img src="'.$MEDIA_FILES_SRC.'/package/large/'.$packs['image'].'" alt="'.$packs['name'].'">';
                echo '</a><h5>'.$packs['name'].'</h5></li>';
            }
            ?>
          </ul>
          <h3>
            <a href="<?php echo $SITE_LOC_PATH.'/'.$pageType.'/compare-packages/'?>">
              Compare Packages
            </a>
          </h3>
        </div>
        <?php 
    }
    ?>
 </div>