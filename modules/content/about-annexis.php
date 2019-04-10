<?php
$abData = $obj->getContentBycontentID(6);
$url=$abData['vidLink'];
if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) 
{  
    $video_id = $match[1];
}
if($url)
{
    ?>
    <div style="width:100%; float:left; background:#000;">
        <div class="videoWrapper">
            <div class="overlay"></div>
            <iframe width="1300" height="690" src="https://www.youtube.com/embed/<?php echo $video_id;?>?autoplay=1&showinfo=0&loop=1&controls=0&playlist=<?php echo $video_id;?>&" frameborder="0" allowfullscreen></iframe>
        </div> 
    </div>
    <?php
}
echo $abData['contentDescription'];?>
        
<script>
    jQuery(document).ready(function($) {
      // Please note that autoHeight option has some conflicts with options like imageScaleMode, imageAlignCenter and autoScaleSlider
      // it's recommended to disable them when using autoHeight module
      $('#content-slider-1').royalSlider({
        autoHeight: true,
        arrowsNav: false,
        fadeinLoadedSlide: false,
        controlNavigationSpacing: 0,
        controlNavigation: 'tabs',
        imageScaleMode: 'none',
        imageAlignCenter:false,
        loop: false,
        loopRewind: true,
        numImagesToPreload: 6,
        keyboardNavEnabled: true,
        usePreloader: false
      });
    });
</script>