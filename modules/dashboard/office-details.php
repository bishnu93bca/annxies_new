<?php
$ofcDetails=$mObj->getOfficeBypermalink($dtaction);
$galData=$mObj->gallery_detailsByofficeId($ofcDetails['id_office'], 0, 999);
?>
<div class="tag_line">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="welcome"> 

                </div>

            </div>
        </div>
    </div>
</div>
<div class="main_content_area">
    <div class="container inner_content"> 
      <!--START PORTFOLIO CONTENT-->
      <section style="padding-top: 30px !important;">
        <div class="row">
          <div class="span12">
            <h2 class="tit"><strong><?php echo $ofcDetails['office'];?>
                </strong></h2>
             </div>
             <div class="span8">
         <div class="home_separator"></div>
             

    <?php 
    if($galData){
        echo '<div id="gallery-1" class="royalSlider rsDefault">';
        foreach($galData as $gl){ 
            if(file_exists($ROOT_PATH.'/uploadedfiles/office/large/'.$gl['galleryImage']) && $gl['galleryImage']) {
                echo '<a class="rsImg bugaga" data-rsw="700" data-rsh="500"  data-rsBigImg="'.$MEDIA_FILES_SRC.'/office/large/'.$gl['galleryImage'].'" href="'.$MEDIA_FILES_SRC.'/office/large/'.$gl['galleryImage'].'">';
                    echo '<img width="650" height="300" class="rsTmb" src="'.$MEDIA_FILES_SRC.'/office/thumb/'.$gl['galleryImage'].'" /></a>';
            }
        } 
        echo '</div>';
    }
if($ofcDetails['office']!='')
{
    ?>      
                 
    <div class="map" id="margin-top" style=""></div>

     <div class="row-fluid mrgbtm35 gmap" style="margin-bottom:20px;">
        <iframe  scrolling="no"  src="https://maps.google.it/maps?q=<?php echo $ofcDetails['office'];?>&output=embed"  width="100%" height="450" frameborder="0" style="border:0"></iframe>	
    </div> 
         
    <div class="row">
      <div class="span4"><h2 style=" margin:30px 0;">location detail</h2> </div>

      <div class="span4"><button data-parmalink="<?php echo $ofcDetails['permalink'];?>" class="btn btn-large btn-success selLocation" style=" margin:30px 0; float:right;">Select This Location</button> </div>     
    </div>    
     <?php
}
?>
<!--darko bootstrap-->
        <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
          <?php if($ofcDetails['airport']){ ?> 
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Airport
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse-in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
                    <div class="wrap-table">
                        <div class="inner-table">
                        <table id="result-airport" class="table table-hover">
                            <?php
                            $airport = explode('#',$ofcDetails['airport']);
                            foreach($airport as $air)
                            {
                                ?>
                            <tr class="cursor" style="background-color: rgb(240, 240, 240);">
                                <td>
                                <img src="https://maps.gstatic.com/mapfiles/place_api/icons/airport-71.png" class="placeIcon" classname="placeIcon" style="height: 15px; width: 15px;">
                                </td><td><?php echo $air;?></td>
                            </tr>
                                <?php
                            }
                            ?>
                        </table>
                        </div>
                        </div> 
              </div>
            </div>
          </div>
          <?php }if($ofcDetails['hotel']){ ?>  
            
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
              <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Hotel
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                    <div class="wrap-table">
                        <div class="inner-table">
                        <table id="result-hotels" class="table table-hover">
                            <?php
                            $hotel = explode('#',$ofcDetails['hotel']);
                            foreach($hotel as $ht)
                            {
                                ?>
                                <tr class="cursor" style="background-color: rgb(240, 240, 240);">
                                    <td>
                                    <img src="https://maps.gstatic.com/mapfiles/place_api/icons/lodging-71.png" class="placeIcon" classname="placeIcon" style="height: 15px; width: 15px;">
                                    </td><td><?php echo $ht;?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        </div>
                        </div> 
              </div>
            </div>
          </div>
            <?php } if($ofcDetails['hotel']){ ?>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
              <h4 class="panel-title">
                <a class="collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Restaurant
                </a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
              <div class="panel-body">
                    <div class="wrap-table">
                        <div class="inner-table">
                        <table id="result-restaurants" class="table table-hover">
                            <?php
                            $restaurant = explode('#',$ofcDetails['restaurant']);
                            foreach($restaurant as $rt)
                            {
                                ?>
                                <tr class="cursor" style="background-color: rgb(240, 240, 240);">
                                    <td>
                                    <img src="https://maps.gstatic.com/mapfiles/place_api/icons/restaurant-71.png" class="placeIcon" classname="placeIcon" style="height: 15px; width: 15px;">
                                    </td><td><?php echo $rt;?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        </div>
                        </div> 
              </div>
            </div>
          </div>
            <?php } ?>
        </div>
</div>
<!------------------->            
<?php include TMPL_PATH.'/inc/sidebar.php';?> 
        </div>
        
        
        
        
        
        <section style="padding:0px !important;">
          <hr style="margin-top:0px;">
          <div class="pride_bg"></div>
        </section>
      </section>
    </div>
  </div>      