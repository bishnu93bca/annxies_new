<?php
$gobj = new gallery;
$gallery = $gobj -> galleryBygalleryCategoryId(118, 0, 5);
print_r($gallery);
if($gallery)
{
    ?>
    <div class="leftpanel">
        <div class="theiaStickySidebar">
            <div class="homeslider owl-carousel">
                <?php 
                foreach($gallery as $galData)
                {
                    if(file_exists($MEDIA_FILES_ROOT.'/photo/gallery/large/'.$galData['imagepath']) && $galData['imagepath'])
                    {
                        ?>
                        <div class="item">
                            <div class="slider_item" style="background-image: url(<?php echo $STYLE_FILES_SRC?>/images/slider1.jpg);">
                                <!--<img src="<?php echo $STYLE_FILES_SRC?>/images/slider1.jpg" alt="" />-->
                                <div class="slider_text">
                                    <h2 class="heading">Explore our <span>suppliers</span> from India</h2>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>                
            </div>
        </div>
    </div>
    <?php
}
?>