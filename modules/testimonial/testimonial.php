<div class="tag_line">
    <div class="container">
      <div class="row">
        <div class="span12">
          <div class="welcome">
            <h2> <strong>Testimonials</strong> </h2>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="main_content_area">
    <div class="webdesign-img"> <img src="<?php echo $STYLE_FILES_SRC;?>/images/testimonial.png"> </div>
    <div class="container">
      <div class="h-grey-bg">
        <?php foreach($TestData as $testData){ ?>
        <div class="h-padding" data-id="<?php echo $testData['testimonialId'];?>">
            <p class="h-pra"><span></span><?php echo $testData['description'];?><span class="close"></span></p>
            <div class="the-author">
              	<div  style="float:left">
                <?php
                if(file_exists($MEDIA_FILES_ROOT.'/testimonials/large/'.$testData['imageName']) && $testData['imageName'])
                    echo '<img src="'.$MEDIA_FILES_SRC.'/testimonials/large/'.$testData['imageName'].'" alt="'.$testData['heading'].'"/>';
                ?>
                </div>
              <div style="float:left; margin-left:20px;"><div class="au-name"><?php echo $testData['heading'];?> </div>
              <div class="au-desi"><?php echo $testData['place'];?><br>
              <?php echo $testData['designation'];?>
              </div></div>
              </div>
            
          </div>
        <?php }?> 
    </div>
  </div>
  <div class="margin-bottom"></div>
